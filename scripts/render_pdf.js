const puppeteer = require('puppeteer-core');
const path = require('path');

(async () => {
  console.log('[PROCESS] Starting Puppeteer PDF renderer...');
  
  // Launch local Google Chrome
  const browser = await puppeteer.launch({
    executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  try {
    const page = await browser.newPage();
    
    // Set a large viewport for high-quality layout calculation
    await page.setViewport({ width: 1200, height: 1600 });

    const htmlPath = path.resolve(__dirname, '../scratch/manual.html');
    const fileUrl = `file://${htmlPath}`;
    console.log(`[PROCESS] Navigating to: ${fileUrl}`);
    
    await page.goto(fileUrl, { 
      waitUntil: 'networkidle0', 
      timeout: 60000 
    });

    // Wait for MathJax typesetting to complete fully
    console.log('[PROCESS] Waiting for MathJax equation rendering...');
    await page.evaluate(async () => {
      if (window.MathJax && window.MathJax.typesetPromise) {
        await window.MathJax.typesetPromise();
      } else {
        // Fallback or wait loop if not loaded instantly
        for (let i = 0; i < 20; i++) {
          if (window.MathJax && window.MathJax.typesetPromise) {
            await window.MathJax.typesetPromise();
            break;
          }
          await new Promise(resolve => setTimeout(resolve, 500));
        }
      }
    });

    // Extra buffer for rendering/reflow (MathJax svg injections and custom web fonts)
    console.log('[PROCESS] Allowing 2 seconds for layout reflow and font settling...');
    await new Promise(resolve => setTimeout(resolve, 2000));

    const pdfPath = path.resolve(__dirname, '../aiiot2026/training_manual_expanded.pdf');
    console.log(`[PROCESS] Generating high-fidelity A4 PDF book at: ${pdfPath}`);

    // Print to PDF with premium settings matching academic specifications
    await page.pdf({
      path: pdfPath,
      format: 'A4',
      printBackground: true,
      margin: {
        top: '1.8cm',
        right: '2.0cm',
        bottom: '2.0cm',
        left: '2.0cm'
      },
      displayHeaderFooter: true,
      headerTemplate: `
        <div style="font-family: 'Sarabun', sans-serif; font-size: 8px; color: #7f8c8d; width: 100%; border-bottom: 1px solid #e1e4e1; padding-bottom: 5px; margin-left: 2.0cm; margin-right: 2.0cm; display: flex; justify-content: space-between; box-sizing: border-box;">
          <span>คู่มือปฏิบัติการวิศวกรรมระบบน้ำอัตโนมัติและไอโอทีเกษตรอัจฉริยะ (รศ. Standard 2026)</span>
          <span>ฝ่ายวิจัยและนวัตกรรมระบบชลประทานอัจฉริยะ</span>
        </div>
      `,
      footerTemplate: `
        <div style="font-family: 'Sarabun', sans-serif; font-size: 8.5px; color: #7f8c8d; width: 100%; border-top: 1px solid #e1e4e1; padding-top: 5px; margin-left: 2.0cm; margin-right: 2.0cm; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box;">
          <span>ศูนย์พัฒนานวัตกรรมเกษตรดิจิทัล มหาวิทยาลัยราชภัฏรำไพพรรณี</span>
          <span>หน้า <span class="pageNumber"></span> จาก <span class="totalPages"></span></span>
        </div>
      `
    });

    console.log(`[SUCCESS] PDF book successfully generated at: ${pdfPath}`);
  } catch (error) {
    console.error('[ERROR] PDF compilation failed:', error);
    process.exit(1);
  } finally {
    await browser.close();
    console.log('[PROCESS] Chrome browser closed.');
  }
})();
