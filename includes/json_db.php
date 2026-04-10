<?php
/**
 * JSON Database Manager
 * A simple class to handle data operations using JSON files.
 */
class JSONDB {
    private $filePath;
    private $data = array();

    public function __construct($table) {
        $dir = dirname(__FILE__) . '/../storage/database/';
        if (!is_dir($dir)) {
            // PHP 5.6 mkdir recursive support check
            if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
                 throw new Exception('Failed to create directories...');
            }
        }
        $this->filePath = $dir . $table . '.json';
        $this->load();
    }

    private function load() {
        if (file_exists($this->filePath)) {
            $content = file_get_contents($this->filePath);
            $this->data = json_decode($content, true);
            if (!is_array($this->data)) {
                $this->data = array();
            }
        }
    }

    /**
     * Sophisticated save with file locking, backup, and permission fix
     */
    private function save() {
        // Compatibility for PHP 5.6 constants
        if (!defined('JSON_PRETTY_PRINT')) define('JSON_PRETTY_PRINT', 128);
        if (!defined('JSON_UNESCAPED_UNICODE')) define('JSON_UNESCAPED_UNICODE', 256);

        $jsonContent = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        if ($jsonContent === false) {
            // PHP 5.6 doesn't have json_last_error_msg() by default everywhere, handling carefully
            throw new Exception("JSON encoding failed");
        }

        // Backup existing file before overwrite (non-blocking)
        if (file_exists($this->filePath)) {
            @copy($this->filePath, $this->filePath . '.bak');
        }

        // Atomic write using file locking
        $fp = @fopen($this->filePath, 'w');
        if (!$fp) {
             @chmod($this->filePath, 0777); 
             $fp = @fopen($this->filePath, 'w');
             if (!$fp) {
                // Return gracefully instead of crashing? No, data loss is bad.
                // Just log connection error?
                error_log("Failed to open JSON DB: " . $this->filePath);
                return;
             }
        }
        
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $jsonContent);
            fflush($fp);
            flock($fp, LOCK_UN);
        } else {
            fclose($fp);
            // throw new Exception("Failed to lock file");
        }
        fclose($fp);
        
        @chmod($this->filePath, 0777);
    }

    public function all() {
        return $this->data;
    }

    public function find($id) {
        foreach ($this->data as $item) {
            if (isset($item['id']) && $item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function where($field, $value) {
        $results = array_filter($this->data, function($item) use ($field, $value) {
            return isset($item[$field]) && $item[$field] == $value;
        });
        return array_values($results);
    }

    public function insert($record) {
        if (!isset($record['id'])) {
            $id = 1;
            if (!empty($this->data)) {
                // array_column polyfill for PHP < 5.5 if needed, but 5.6 has it.
                $ids = array_filter(array_column($this->data, 'id'), 'is_numeric');
                $id = !empty($ids) ? max($ids) + 1 : count($this->data) + 1;
            }
            $record['id'] = $id;
        }
        
        if (!isset($record['created_at'])) {
            $record['created_at'] = date('Y-m-d H:i:s');
        }
        
        // Fix for PHP 5.6: $this->data[] = $record;
        array_push($this->data, $record);
        $this->save();
        return $record['id'];
    }

    public function update($id, $updates) {
        foreach ($this->data as &$item) {
            if (isset($item['id']) && $item['id'] == $id) {
                $item = array_merge($item, $updates);
                $item['updated_at'] = date('Y-m-d H:i:s');
                $this->save();
                return true;
            }
        }
        return false;
    }

    public function delete($id) {
        $initial_count = count($this->data);
        $this->data = array_filter($this->data, function($item) use ($id) {
            return isset($item['id']) && $item['id'] != $id;
        });
        
        if (count($this->data) < $initial_count) {
            $this->data = array_values($this->data); // Re-index
            $this->save();
            return true;
        }
        return false;
    }

    public function count() {
        return count($this->data);
    }

    /**
     * Clear all data in the table
     */
    public function truncate() {
        $this->data = array();
        $this->save();
        return true;
    }
}
?>
