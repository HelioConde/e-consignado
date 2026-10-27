import { defineConfig, devices } from '@playwright/test'
export default defineConfig({
  testDir:'./e2e',timeout:30000,expect:{timeout:10000},
  fullyParallel:true,retries:process.env.CI?1:0,workers:process.env.CI?2:undefined,
  reporter:[['list'],['html',{outputFolder:'playwright-report',open:'never'}],['json',{outputFile:'test-results/results.json'}]],
  outputDir:'test-results',
  use:{baseURL:'http://127.0.0.1:4173/e-consignado/',screenshot:'only-on-failure',trace:'retain-on-failure',locale:'pt-BR',reducedMotion:'reduce'},
  projects:[{name:'chromium',use:{...devices['Desktop Chrome']}}],
  webServer:{command:'npm run preview -- --host 127.0.0.1 --port 4173 --strictPort',url:'http://127.0.0.1:4173/e-consignado/',timeout:120000,reuseExistingServer:!process.env.CI}
})
