/** Fórmulas educativas Price. Não incluem CET, taxas adicionais, seguros ou impostos. */
export type Params = { principal: number; rate: number; months: number }
export type Line = { index: number; payment: number; interest: number; amortization: number; balance: number }
export type Loan = Params & { payment: number; total: number; interest: number; annualRate: number; schedule: Line[] }
export function roundMoney(value: number): number {
  if (!Number.isFinite(value)) throw new RangeError('Valor inválido')
  return Math.round((value + Number.EPSILON) * 100) / 100
}
export function validate({principal,rate,months}: Params): void {
  if (!Number.isFinite(principal) || principal <= 0 || principal > 1e9) throw new RangeError('Informe um valor entre R$ 0,01 e R$ 1 bilhão.')
  if (!Number.isFinite(rate) || rate < 0 || rate > 1) throw new RangeError('A taxa mensal deve estar entre 0% e 100%.')
  if (!Number.isInteger(months) || months < 1 || months > 600) throw new RangeError('O prazo deve ser de 1 a 600 meses.')
}
export function installment({principal,rate,months}: Params): number {
  validate({principal,rate,months})
  if (rate === 0) return principal / months
  return principal * rate / (1 - Math.pow(1 + rate, -months))
}
export function simulate(p: Params): Loan {
  validate(p)
  const base = installment(p), schedule: Line[] = []
  let balance = roundMoney(p.principal)
  for (let index = 1; index <= p.months; index++) {
    const interest = roundMoney(balance * p.rate)
    const payment = index === p.months ? roundMoney(balance + interest) : roundMoney(base)
    const amortization = roundMoney(payment - interest)
    balance = roundMoney(Math.max(0,balance - amortization))
    schedule.push({index,payment,interest,amortization,balance})
  }
  const total = roundMoney(schedule.reduce((sum,line)=>sum+line.payment,0))
  return {...p,payment:roundMoney(base),total,interest:roundMoney(total-p.principal),annualRate:Math.pow(1+p.rate,12)-1,schedule}
}
export function inferRate(principal:number,payment:number,months:number):number {
  validate({principal,rate:0,months})
  if (!Number.isFinite(payment) || payment <= 0 || payment > 1e9) throw new RangeError('Informe uma prestação positiva válida.')
  const minimum = principal / months
  if (payment < minimum - .005) throw new RangeError('A prestação informada é inferior ao valor sem juros.')
  if (Math.abs(payment-minimum) < .005) return 0
  if (payment > installment({principal,rate:1,months})) throw new RangeError('A taxa implícita ultrapassaria 100% ao mês.')
  let low=0,high=1
  for(let i=0;i<90;i++){const middle=(low+high)/2; if(installment({principal,rate:middle,months})>payment)high=middle; else low=middle}
  return (low+high)/2
}
export function remainingBalance(payment:number,rate:number,months:number):number {
  if(!Number.isFinite(payment)||payment<=0||payment>1e9||!Number.isFinite(rate)||rate<0||rate>1||!Number.isInteger(months)||months<0||months>600) throw new RangeError('Parcela, taxa ou prazo inválidos.')
  return months===0?0:roundMoney(rate===0?payment*months:payment*(1-Math.pow(1+rate,-months))/rate)
}
export function parseBR(value:string):number {
  const raw=value.trim().replace(/\s/g,'')
  if (/^-?\d{1,3}(\.\d{3})+(,\d+)?$/.test(raw)) return Number(raw.replace(/\./g,'').replace(',','.'))
  if (/^-?\d+(,\d+)?$/.test(raw)) return Number(raw.replace(',','.'))
  if (/^-?\d+(\.\d+)?$/.test(raw)) return Number(raw)
  return NaN
}
export function brl(value:number):string { return new Intl.NumberFormat('pt-BR',{style:'currency',currency:'BRL'}).format(value) }
export function pct(value:number):string { return new Intl.NumberFormat('pt-BR',{style:'percent',minimumFractionDigits:2,maximumFractionDigits:2}).format(value) }
