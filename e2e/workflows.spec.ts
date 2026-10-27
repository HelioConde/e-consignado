import { test, expect } from '@playwright/test'

test('simulador não apresenta cálculo antigo como resultado atualizado',async({page})=>{
  await page.goto('./#/simuladores')
  await page.locator('#principal').fill('20000')
  await expect(page.getByText('Os valores foram alterados. Calcule novamente para atualizar os resultados.')).toBeVisible()
  await expect(page.locator('.accent-panel')).toContainText('RESULTADO ANTERIOR')
  await expect(page.getByRole('button',{name:'Salvar no histórico local'})).toBeDisabled()
  await page.getByRole('button',{name:'Calcular simulação'}).click()
  await expect(page.locator('.accent-panel')).toContainText('RESULTADO ESTIMADO')
  await expect(page.getByRole('button',{name:'Salvar no histórico local'})).toBeEnabled()
})

test('histórico permite salvar, reabrir e excluir cenários locais',async({page})=>{
  await page.goto('./#/simuladores')
  await page.locator('#principal').fill('20000')
  await page.getByRole('button',{name:'Calcular simulação'}).click()
  await page.getByRole('button',{name:'Salvar no histórico local'}).click()
  await expect(page.getByRole('status').filter({hasText:'Simulação salva apenas neste navegador.'})).toBeVisible()
  await page.locator('.sidebar nav a[href="#/ferramentas"]').click()
  await expect(page.locator('.counter-pill')).toContainText('1/50 registros')
  await page.getByRole('button',{name:/Reutilizar simulação de/}).click()
  await expect(page.getByRole('heading',{name:'Simulador de empréstimo'})).toBeVisible()
  await expect(page.locator('#principal')).toHaveValue('20.000')
  await page.locator('.sidebar nav a[href="#/ferramentas"]').click()
  await page.getByRole('button',{name:/Excluir simulação de/}).click()
  await expect(page.locator('.counter-pill')).toContainText('0/50 registros')
  await expect(page.getByText('Nenhum cenário salvo ainda')).toBeVisible()
})

test('CSV só numérico gera prévia e exportação dos resultados',async({page})=>{
  await page.goto('./#/ferramentas')
  await page.locator('#csv').setInputFiles({name:'simulacoes.csv',mimeType:'text/csv',buffer:Buffer.from('valor;taxa;prazo\n15000;1,8;36\n8000;2;24\nfoo;2;24')})
  await expect(page.locator('.csv-summary')).toContainText('2 cenário(s) validado(s)')
  await expect(page.locator('.csv-summary')).toContainText('1 linha(s) rejeitada(s)')
  await expect(page.locator('.csv-preview-head')).toBeVisible()
  const downloading=page.waitForEvent('download')
  await page.getByRole('button',{name:'Exportar resultados CSV'}).click()
  expect((await downloading).suggestedFilename()).toBe('resultados-simulacoes.csv')
})

test('CSV recusa arquivos com coluna CPF e não mostra valores reais',async({page})=>{
  await page.goto('./#/ferramentas')
  await page.locator('#csv').setInputFiles({name:'inadmissivel.csv',mimeType:'text/csv',buffer:Buffer.from('cpf;valor;taxa;prazo\n00000000000;15000;1;24')})
  await expect(page.locator('.tool-feedback')).toContainText('Cabeçalho inválido')
  await expect(page.locator('.csv-summary')).toContainText('0 cenário(s) validado(s)')
})

test('JSON numérico restaura histórico e rejeita colunas extras',async({page})=>{
  await page.goto('./#/ferramentas')
  page.on('dialog',dialog=>dialog.accept())
  await page.locator('#json-historico').setInputFiles({name:'historico.json',mimeType:'application/json',buffer:Buffer.from('\uFEFF[{"principal":6000,"rate":0.02,"months":12}]')})
  await expect(page.locator('.counter-pill')).toContainText('1/50 registros')
  await page.locator('#json-historico').setInputFiles({name:'privado.json',mimeType:'application/json',buffer:Buffer.from('[{"principal":6000,"rate":0.02,"months":12,"cpf":"00000000000"}]')})
  await expect(page.locator('.tool-feedback')).toContainText('colunas não permitidas')
  await expect(page.locator('.counter-pill')).toContainText('1/50 registros')
})
