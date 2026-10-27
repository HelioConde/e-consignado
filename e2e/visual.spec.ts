import { test, expect } from '@playwright/test'
import { mkdir } from 'node:fs/promises'
import { dirname } from 'node:path'
const sizes=[
  {name:'mobile-320',width:320,height:720},{name:'mobile-375',width:375,height:812},
  {name:'mobile-390',width:390,height:844},{name:'tablet-768',width:768,height:1024},
  {name:'laptop-1024',width:1024,height:768},{name:'desktop-1440',width:1440,height:900}
]
const routes=['inicio','simuladores','taxas','comparacao','ferramentas','ajuda']
for(const size of sizes)for(const route of routes){
  test('captura '+route+' '+size.name,async({page},info)=>{
    await page.setViewportSize({width:size.width,height:size.height})
    const audit={route,viewport:size.name,console:[] as string[],javascript:[] as string[],http:[] as string[],network:[] as string[],layout:{} as Record<string,unknown>}
    page.on('console',m=>{if(m.type()==='error')audit.console.push(m.text())})
    page.on('pageerror',e=>audit.javascript.push(e.message))
    page.on('response',r=>{if(r.status()>=400 && r.url().includes('127.0.0.1:4173'))audit.http.push(r.status()+' '+r.url())})
    page.on('requestfailed',req=>{if(req.url().includes('127.0.0.1:4173'))audit.network.push(req.url()+': '+req.failure()?.errorText)})
    const response=await page.goto('./#/'+route,{waitUntil:'networkidle'})
    await expect(page.getByRole('heading',{level:1})).toBeVisible()
    audit.layout=await page.evaluate(()=>{
      const width=innerWidth
      const doc=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth)
      const escaped:string[]=[]
      for(const el of document.querySelectorAll('main h1,main h2,main p,main button,main input,main .panel,main .feature,main .compare-card')){
        if(el.closest('.table-scroll'))continue
        const rect=el.getBoundingClientRect(),style=getComputedStyle(el)
        if(style.display==='none'||rect.width<1)continue
        if(rect.left < -3 || rect.right > width+3)escaped.push(el.tagName.toLowerCase()+':'+Math.round(rect.left)+'..'+Math.round(rect.right))
      }
      return {width,document:doc,overflow:Math.max(0,doc-width),escaped:escaped.slice(0,30),brokenImages:[...document.images].filter(i=>i.complete&&i.naturalWidth===0).map(i=>i.src)}
    })
    const screenshot=info.outputPath('screenshots',size.name,route+'.png')
    await mkdir(dirname(screenshot),{recursive:true})
    await page.screenshot({path:screenshot,fullPage:true,animations:'disabled'})
    await info.attach('captura-pagina-inteira',{path:screenshot,contentType:'image/png'})
    await info.attach('diagnostico.json',{body:Buffer.from(JSON.stringify(audit,null,2)),contentType:'application/json'})
    expect(response?.ok()).toBe(true)
    expect([...audit.console,...audit.javascript,...audit.http,...audit.network]).toEqual([])
    const layout=audit.layout as {overflow:number;escaped:string[];brokenImages:string[]}
    expect(layout.overflow).toBeLessThanOrEqual(2);expect(layout.escaped).toEqual([]);expect(layout.brokenImages).toEqual([])
  })
}
test('simulador calcula e exporta CSV',async({page})=>{
  await page.goto('./#/simuladores')
  await page.getByRole('button',{name:'Calcular simulação'}).click()
  await expect(page.getByText('Simulação atualizada. Valores ilustrativos.')).toBeVisible()
  const downloaded=page.waitForEvent('download')
  await page.getByRole('button',{name:'Exportar CSV'}).click()
  expect((await downloaded).suggestedFilename()).toBe('simulacao-price.csv')
})
test('menu mobile abre e fecha sem impedir navegação',async({page})=>{
  await page.setViewportSize({width:375,height:812})
  await page.goto('./#/inicio')
  await page.getByRole('button',{name:'Abrir menu'}).click()
  await expect(page.getByRole('button',{name:'Fechar menu'})).toBeVisible()
  await page.getByRole('link',{name:/Descobrir taxa/}).click()
  await expect(page.getByRole('heading',{name:'Descubra a taxa implícita'})).toBeVisible()
})
