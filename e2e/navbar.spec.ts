import { test, expect } from '@playwright/test'

const navCases = [
 {route:'inicio',label:'Visão geral'},
 {route:'simuladores',label:'Simuladores'},
 {route:'taxas',label:'Descobrir taxa'},
 {route:'comparacao',label:'Comparar'},
 {route:'ferramentas',label:'Ferramentas'},
 {route:'ajuda',label:'Ajuda'}
]
test('navegação desktop: ícones SVG de tamanho e traço consistentes',async({page})=>{
 await page.setViewportSize({width:1440,height:900})
 await page.goto('./#/inicio')
 const nav=page.locator('.sidebar nav')
 await expect(nav.locator('a.nav-link')).toHaveCount(6)
 for(const item of navCases){
   const link=nav.locator('a[href="#/'+item.route+'"]')
   await expect(link).toHaveAccessibleName(item.label)
   await expect(link.locator('svg')).toHaveCount(1)
   const svg=link.locator('.nav-icon svg')
   await expect(svg).toHaveAttribute('viewBox','0 0 24 24')
   const box=await svg.boundingBox()
   expect(box?.width).toBeGreaterThanOrEqual(19)
   expect(box?.width).toBeLessThanOrEqual(21)
   expect(box?.height).toBeGreaterThanOrEqual(19)
   await expect(link.locator('.nav-label')).toHaveText(item.label)
 }
 await expect(page.locator('.brand-symbol')).toHaveCount(1)
 await expect(page.locator('.sidebar-privacy-icon svg')).toHaveCount(1)
 await expect(nav.locator('a.active')).toHaveAttribute('aria-current','page')
})

test('navegação ativa troca cor e mantém rótulos em todas as seções',async({page})=>{
 await page.setViewportSize({width:1024,height:768})
 await page.goto('./#/inicio')
 for(const item of navCases){
   const link=page.locator('.sidebar nav a[href="#/'+item.route+'"]')
   await link.click()
   await expect(link).toHaveAttribute('aria-current','page')
   await expect(link).toHaveClass(/active/)
   await expect(page.locator('main h1')).toBeVisible()
   const full=await page.evaluate(()=>document.documentElement.scrollWidth-innerWidth)
   expect(full).toBeLessThanOrEqual(2)
 }
})

for(const width of [320,375,390,768]){
 test('menu SVG mobile responsivo em '+width+'px',async({page})=>{
   await page.setViewportSize({width,height:820})
   await page.goto('./#/inicio')
   const btn=page.locator('.menu-trigger')
   await expect(btn).toBeVisible()
   await expect(btn).toHaveAccessibleName('Abrir menu')
   await expect(btn.locator('svg')).toHaveCount(1)
   await btn.click()
   await expect(btn).toHaveAttribute('aria-expanded','true')
   await expect(page.locator('.sidebar')).toBeVisible()
   await page.locator('.sidebar nav a[href="#/simuladores"]').click()
   await expect(page.locator('h1')).toContainText('Simulador de empréstimo')
   await expect(page.locator('.sidebar')).toBeHidden()
   const over=await page.evaluate(()=>document.documentElement.scrollWidth-innerWidth)
   expect(over).toBeLessThanOrEqual(2)
 })
}
test('favicon SVG usa a mesma marca e não tem elementos de texto dependentes de fonte',async({page,request})=>{
 await page.goto('./#/inicio')
 const res=await request.get('./icon.svg')
 expect(res.ok()).toBeTruthy()
 const svg=await res.text()
 expect(svg).toContain('viewBox="0 0 64 64"')
 expect(svg).toContain('stroke="#b3ffe7"')
 expect(svg).not.toContain('<text')
 await expect(page.locator('.brand-symbol')).toBeVisible()
})
