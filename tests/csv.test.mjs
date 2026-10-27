import test from 'node:test'
import assert from 'node:assert/strict'
import { parseScenarioCSV, exportScenarioResults } from '../src/csv.ts'

test('csv simples: valida 2 linhas numéricas e permite exportação',()=>{
 const result=parseScenarioCSV('valor;taxa;prazo\n15000;1,8;36\n8000;2,0;24')
 assert.equal(result.items.length,2)
 assert.equal(result.rejected,0)
 assert.equal(result.items[0].principal,15000)
 const exported=exportScenarioResults(result.items)
 assert.match(exported,/prestacao;total_pago;juros/)
 assert.equal(exported.split('\n').length,3)
})
test('csv: BOM e quebra de linha Windows',()=>{
 const result=parseScenarioCSV('\uFEFFvalor;taxa;prazo\r\n1.500,50;1,5;12\r\n')
 assert.equal(result.items[0].principal,1500.5)
})
test('csv: recusa colunas com informações pessoais',()=>{
 assert.throws(()=>parseScenarioCSV('cpf;valor;taxa;prazo\n123;1000;1;12'),/Cabeçalho inválido/)
 assert.throws(()=>parseScenarioCSV('valor;taxa;prazo;nome\n1000;1;12;teste'),/Cabeçalho inválido/)
})
test('csv: linhas inválidas são contabilizadas sem armazenar entradas',()=>{
 const result=parseScenarioCSV('valor;taxa;prazo\n1000;1;12\nfoo;2;12\n999;2;999')
 assert.equal(result.items.length,1)
 assert.equal(result.rejected,2)
})
test('csv: evita processamento silencioso de mais de 500 linhas',()=>{
 assert.throws(()=>parseScenarioCSV('valor;taxa;prazo\n'+Array(501).fill('1000;1;12').join('\n')),/Limite/)
})
test('csv: rejeita vazio e prazo em notação científica',()=>{
 assert.throws(()=>parseScenarioCSV('valor;taxa;prazo'),/não contém cenários/)
 assert.equal(parseScenarioCSV('valor;taxa;prazo\n1000;1;1e2').rejected,1)
})
