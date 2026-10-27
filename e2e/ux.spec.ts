import { test, expect } from '@playwright/test'

test('home: cards, prévia e chamada principal funcionam',async({page})=>{
  await page.goto('./#/inicio')
  await expect(page.getByRole('heading',{name:/Entenda os números/})).toBeVisible()
  await expect(page.getByLabel('Resumo ilustrativo da última simulação')).toBeVisible()
  await page.getByRole('link',{name:/Fazer uma simulação/}).click()
  await expect(page.getByRole('heading',{name:'Simulador de empréstimo'})).toBeVisible()
})

test('comparativo: slider muda taxas e diferença total',async({page})=>{
  await page.goto('./#/comparacao')
  const label=page.locator('label[for="taxa-variacao"] strong')
  await expect(label).toHaveText(/0,4 ponto/)
  const result=page.locator('.compare-insight strong')
  const initial=await result.textContent()
  await page.locator('#taxa-variacao').focus()
  await page.keyboard.press('ArrowRight')
  await expect(label).toHaveText(/0,5 ponto/)
  await expect(result).not.toHaveText(initial||'')
})

test('simulador: inválidos produzem feedback em vez de NaN',async({page})=>{
  await page.goto('./#/simuladores')
  await page.locator('#taxa').fill('não é número')
  await page.getByRole('button',{name:'Calcular simulação'}).click()
  await expect(page.locator('p.status')).toContainText('taxa')
  await expect(page.locator('.accent-panel')).not.toContainText('NaN')
})

test('controles têm nomes, e menu oculto não recebe foco no celular',async({page})=>{
  await page.setViewportSize({width:320,height:720})
  await page.goto('./#/inicio')
  const aside=page.locator('#menu-principal')
  await expect(aside).toBeHidden()
  const trigger=page.locator('.menu-trigger')
  await trigger.focus()
  await expect(trigger).toBeFocused()
  await page.keyboard.press('Enter')
  await expect(trigger).toHaveAttribute('aria-expanded','true')
  await expect(aside).toBeVisible()
  await page.keyboard.press('Escape')
  await expect(aside).toBeHidden()
  await page.goto('./#/simuladores')
  for(const input of await page.locator('input:not([type=file])').all()){
    const id=await input.getAttribute('id')
    expect(id).toBeTruthy()
    await expect(page.locator('label[for="'+id+'"]')).toBeVisible()
  }
  const noOverflow=await page.evaluate(()=>document.documentElement.scrollWidth-innerWidth)
  expect(noOverflow).toBeLessThanOrEqual(2)
})

test('navegação usa histórico de hash sem recarregamento',async({page})=>{
  await page.goto('./#/inicio')
  await page.getByRole('link',{name:'Simuladores',exact:true}).click()
  await expect(page.getByRole('heading',{name:'Simulador de empréstimo'})).toBeVisible()
  await page.goBack()
  await expect(page.getByRole('heading',{name:/Entenda os números/})).toBeVisible()
})
