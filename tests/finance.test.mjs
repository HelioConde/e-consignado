import test from 'node:test'
import assert from 'node:assert/strict'
import { simulate, installment, inferRate, remainingBalance, parseBR, validate } from '../src/finance.ts'
test('sem juros: parcela e juros',()=>{
 const s=simulate({principal:12000,rate:0,months:12})
 assert.equal(s.payment,1000);assert.equal(s.total,12000);assert.equal(s.interest,0);assert.equal(s.schedule.at(-1).balance,0)
})
test('Price: exemplo numérico',()=>{
 const p=installment({principal:10000,rate:.02,months:12})
 assert.ok(Math.abs(p-945.5966)<.02)
})
test('amortização zera saldo e concilia o total',()=>{
 const s=simulate({principal:15000,rate:.018,months:36})
 assert.equal(s.schedule.length,36);assert.equal(s.schedule[35].balance,0)
 assert.ok(Math.abs(s.schedule.reduce((a,b)=>a+b.payment,0)-s.total)<.01);assert.ok(s.interest>0)
})
test('busca inversa recupera taxa Price',()=>{
 const inferred=inferRate(22000,installment({principal:22000,rate:.015,months:48}),48)
 assert.ok(Math.abs(inferred-.015)<1e-9)
})
test('saldo teórico sem juros',()=>assert.equal(remainingBalance(300,0,12),3600))
test('saldo teórico com juros',()=>assert.ok(remainingBalance(500,.01,12)<6000))
test('saldo zero após a última parcela',()=>assert.equal(remainingBalance(500,.01,0),0))
test('formatação monetária brasileira',()=>{
 assert.equal(parseBR('10.000,25'),10000.25)
 assert.equal(parseBR('1,8'),1.8)
 assert.equal(parseBR('1.500'),1500)
})
test('não aceita valores inválidos',()=>{
 for (const principal of [0,-1,Number.NaN,Number.POSITIVE_INFINITY]) {
   assert.throws(()=>validate({principal,rate:.01,months:12}),RangeError)
 }
 assert.throws(()=>simulate({principal:1,rate:-.1,months:12}),RangeError)
 assert.throws(()=>simulate({principal:1,rate:.01,months:0}),RangeError)
 assert.throws(()=>simulate({principal:1,rate:.01,months:601}),RangeError)
})
test('recusa parcela impossível',()=>{
 assert.throws(()=>inferRate(10000,100,12),RangeError)
 assert.throws(()=>remainingBalance(200,.01,-1),RangeError)
})
