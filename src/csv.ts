import { parseBR, simulate } from './finance.ts'
import type { Loan } from './finance'

export type CsvResults = { items: Loan[]; rejected: number }
const HEADER = 'valor;taxa;prazo'
const MAX_ROWS = 500

/** Accepts numeric-only scenario data, never names, CPF, account numbers or arbitrary columns. */
export function parseScenarioCSV(text: string): CsvResults {
  const lines = text.replace(/^\uFEFF/, '').split(/\r?\n/).map(line=>line.trim()).filter(Boolean)
  if (!lines.length || lines[0].toLowerCase() !== HEADER) {
    throw new Error('Cabeçalho inválido. Use somente valor;taxa;prazo (sem dados pessoais).')
  }
  if (lines.length - 1 > MAX_ROWS) throw new Error('Limite de 500 cenários por arquivo.')
  if (lines.length < 2) throw new Error('O arquivo não contém cenários.')
  const items: Loan[] = []
  let rejected = 0
  for (const line of lines.slice(1)) {
    const cells = line.split(';')
    if (cells.length !== 3 || !/^\d{1,3}$/.test(cells[2].trim())) { rejected++; continue }
    try {
      items.push(simulate({
        principal: parseBR(cells[0]),
        rate: parseBR(cells[1]) / 100,
        months: Number(cells[2].trim())
      }))
    } catch { rejected++ }
  }
  return { items, rejected }
}
export function exportScenarioResults(items: Loan[]):string {
  return [
    'valor;taxa_mensal_percentual;prazo;prestacao;total_pago;juros',
    ...items.map(item=>[
      item.principal.toFixed(2), (item.rate*100).toFixed(4),
      item.months, item.payment.toFixed(2), item.total.toFixed(2), item.interest.toFixed(2)
    ].join(';'))
  ].join('\n')
}
