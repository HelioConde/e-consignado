import { useEffect, useState } from 'react'
import type { FormEvent, ChangeEvent } from 'react'
import { addSaved, clearSaved, listSaved, removeSaved } from './storage'
import type { Saved } from './storage'
import { brl, inferRate, installment, parseBR, pct, remainingBalance, simulate } from './finance'
import type { Loan, Params } from './finance'

type Route = 'inicio' | 'simuladores' | 'taxas' | 'comparacao' | 'ferramentas' | 'ajuda'
const routes: { id: Route; label: string; icon: string }[] = [
  { id: 'inicio', label: 'Visão geral', icon: '◫' },
  { id: 'simuladores', label: 'Simuladores', icon: '▦' },
  { id: 'taxas', label: 'Descobrir taxa', icon: '%' },
  { id: 'comparacao', label: 'Comparar', icon: '⇄' },
  { id: 'ferramentas', label: 'Ferramentas', icon: '▤' },
  { id: 'ajuda', label: 'Ajuda', icon: '?' },
]
function fromHash(): Route {
  const key = window.location.hash.replace(/^#\/?/, '')
  return routes.find(item => item.id === key)?.id ?? 'inicio'
}
function download(name: string, content: string, type: string) {
  const url = URL.createObjectURL(new Blob(['\ufeff', content], { type }))
  const a = document.createElement('a')
  a.href = url
  a.download = name
  a.click()
  setTimeout(() => URL.revokeObjectURL(url), 1000)
}
function TextField({id,label,value,onChange,hint}: {id:string;label:string;value:string;onChange:(v:string)=>void;hint?:string}) {
  return <label className="field" htmlFor={id}><span>{label}</span><input id={id} name={id} autoComplete="off" spellCheck={false} inputMode={id.includes("prazo")?"numeric":"decimal"} value={value} onChange={e=>onChange(e.target.value)} />{hint && <small>{hint}</small>}</label>
}
function CardLink({icon,title,description,to}: {icon:string;title:string;description:string;to:Route}) {
  return <a href={'#/'+to} className="feature"><span className="feature-icon" aria-hidden="true">{icon}</span><strong>{title}</strong><span>{description}</span><span className="feature-arrow" aria-hidden="true">Abrir →</span></a>
}
function Metric({label,value,caption}: {label:string;value:string;caption?:string}) {
  return <div className="metric"><span>{label}</span><strong>{value}</strong>{caption&&<small>{caption}</small>}</div>
}
function csvFor(loan:Loan):string {
  return ['Parcela;Prestação;Juros;Amortização;Saldo',...loan.schedule.map(s=>[s.index,s.payment.toFixed(2),s.interest.toFixed(2),s.amortization.toFixed(2),s.balance.toFixed(2)].join(';'))].join('\n')
}

export default function App() {
  const [route, setRoute] = useState<Route>(fromHash)
  const [menu,setMenu] = useState(false)
  const [compareSpread,setCompareSpread] = useState(0.4)
  const [principal,setPrincipal] = useState('15.000')
  const [rate,setRate] = useState('1,80')
  const [months,setMonths] = useState('36')
  const [loan,setLoan] = useState<Loan|null>(()=>simulate({principal:15000,rate:.018,months:36}))
  const [message,setMessage] = useState('')
  const [allRows,setAllRows] = useState(false)
  const [implied,setImplied] = useState<string|null>(null)
  const [ratePrincipal,setRatePrincipal] = useState('15.000')
  const [ratePayment,setRatePayment] = useState('570')
  const [rateMonths,setRateMonths] = useState('36')
  const [balanceResult,setBalanceResult] = useState<string|null>(null)
  const [balancePayment,setBalancePayment] = useState('570')
  const [balanceRate,setBalanceRate] = useState('1,80')
  const [balanceMonths,setBalanceMonths] = useState('18')
  const [records,setRecords] = useState<Saved[]>([])
  const [toolMessage,setToolMessage] = useState('')
  const [csvRows,setCsvRows] = useState(0)

  useEffect(()=>{
    function sync() { setRoute(fromHash()); setMenu(false); setMessage(''); window.scrollTo(0,0) }
    window.addEventListener('hashchange',sync)
    if(!window.location.hash) window.history.replaceState(null,'','#/inicio')
    return ()=>window.removeEventListener('hashchange',sync)
  },[])
  useEffect(()=>{
    if(route==='ferramentas') listSaved().then(setRecords).catch(()=>setToolMessage('Histórico local indisponível neste navegador.'))
  },[route])
  useEffect(()=>{
    function close(e:KeyboardEvent){ if(e.key==='Escape')setMenu(false) }
    window.addEventListener('keydown',close)
    return ()=>window.removeEventListener('keydown',close)
  },[])

  function onSimulate(e:FormEvent) {
    e.preventDefault()
    try{
      const params:Params={principal:parseBR(principal),rate:parseBR(rate)/100,months:Number(months)}
      const result=simulate(params)
      setLoan(result);setAllRows(false);setMessage('Simulação atualizada. Valores ilustrativos.')
    }catch(err){setMessage(err instanceof Error?err.message:'Dados inválidos')}
  }
  function onInfer(e:FormEvent){
    e.preventDefault()
    try{setImplied(pct(inferRate(parseBR(ratePrincipal),parseBR(ratePayment),Number(rateMonths))))}
    catch(err){setImplied(err instanceof Error?err.message:'Dados inválidos')}
  }
  function onBalance(e:FormEvent){
    e.preventDefault()
    try{setBalanceResult(brl(remainingBalance(parseBR(balancePayment),parseBR(balanceRate)/100,Number(balanceMonths))))}
    catch(err){setBalanceResult(err instanceof Error?err.message:'Dados inválidos')}
  }
  async function saveCurrent(){
    if(!loan)return
    try{await addSaved({principal:loan.principal,rate:loan.rate,months:loan.months});setToolMessage('Cenário numérico salvo apenas neste navegador.');setRecords(await listSaved())}
    catch{setToolMessage('Não foi possível salvar neste navegador.')}
  }
  async function erase(id:string) {
    try{await removeSaved(id);setRecords(await listSaved());setToolMessage('Registro excluído.')}
    catch{setToolMessage('Falha ao excluir registro.')}
  }
  async function eraseAll(){
    if(!window.confirm('Excluir permanentemente todo o histórico local?'))return
    try{await clearSaved();setRecords([]);setToolMessage('Histórico local apagado.')}
    catch{setToolMessage('Falha ao apagar histórico.')}
  }
  async function readCSV(event:ChangeEvent<HTMLInputElement>){
    const file=event.target.files?.[0]
    if(!file)return
    setCsvRows(0)
    if(!file.name.toLowerCase().endsWith('.csv')||file.size>1000000){setToolMessage('Escolha um CSV com até 1 MB.');return}
    const input=(await file.text()).replace(/^\ufeff/,'')
    const rows=input.split(/\r?\n/).filter(Boolean)
    if(!/^valor;taxa;prazo$/i.test(rows[0]?.trim()||'')){setToolMessage('Cabeçalho esperado: valor;taxa;prazo. Não importe dados pessoais.');return}
    let valid=0
    for(const line of rows.slice(1,501)){
      const cells=line.split(';')
      if(cells.length!==3)continue
      try{simulate({principal:parseBR(cells[0]),rate:parseBR(cells[1])/100,months:Number(cells[2])});valid++}catch{ /* ignora linha inválida */ }
    }
    setCsvRows(valid)
    setToolMessage(valid+' linha(s) numéricas validadas localmente. Nenhum dado enviado ou gravado.')
    event.target.value=''
  }
  const current=routes.find(item=>item.id===route) ?? routes[0]
  const comparison = loan ? [Math.max(0,loan.rate-compareSpread/100),loan.rate,Math.min(1,loan.rate+compareSpread/100)].map(rate=>simulate({principal:loan.principal,months:loan.months,rate})) : []
  return <div className="shell">
    <a className="skip" href="#conteudo">Pular para o conteúdo</a>
    {menu&&<button className="scrim" aria-label="Fechar menu" onClick={()=>setMenu(false)} />}
    <aside className={'sidebar'+(menu?' open':'')} id="menu-principal" aria-label="Menu principal">
      <a className="brand" href="#/inicio"><span className="mark">e<span>.</span></span><span>e-Consignado<small>Laboratório financeiro</small></span></a>
      <p className="menu-label">MENU PRINCIPAL</p>
      <nav aria-label="Navegação principal">{routes.map(item=><a key={item.id} href={'#/'+item.id} aria-current={route===item.id?'page':undefined} className={'nav-link'+(route===item.id?' active':'')}><span aria-hidden="true">{item.icon}</span>{item.label}</a>)}</nav>
      <div className="sidebar-foot"><span aria-hidden="true">◇</span><strong>Privacidade primeiro</strong><p>Simulações executadas no navegador, sem conta nem servidor de dados.</p><small>● Aplicação educativa</small></div>
    </aside>
    <div className="main-area">
      <header className="topbar"><button className="menu-trigger" aria-label={menu?'Fechar menu':'Abrir menu'} aria-controls="menu-principal" aria-expanded={menu} onClick={()=>setMenu(v=>!v)}>☰</button><span className="breadcrumb">Laboratório <b aria-hidden="true">/</b> <strong>{current.label}</strong></span><span className="top-badge">DEMONSTRAÇÃO EDUCATIVA</span></header>
      <main id="conteudo" className="content" tabIndex={-1} aria-label={current.label}>
        {route==='inicio'&&<>
          <div className="hero">
            <div className="hero-copy"><span className="eyebrow"><span className="eyebrow-dot" aria-hidden="true"/> SEU ESPAÇO DE SIMULAÇÕES</span>
            <h1>Entenda os números.<br/><em>Escolha com clareza.</em></h1>
            <p>Simule parcelas, acompanhe juros e compare condições em um só lugar. Tudo no navegador, sem cadastro e sem compartilhar seus dados.</p>
            <div className="actions"><a className="primary" href="#/simuladores">Fazer uma simulação <span aria-hidden="true">→</span></a><a className="secondary" href="#/comparacao">Comparar cenários</a></div>
            <div className="hero-points"><span>✓ Sem cadastro</span><span>✓ Cálculos locais</span><span>✓ Uso educativo</span></div></div>
            <div className="hero-preview" aria-label="Resumo ilustrativo da última simulação"><div className="preview-head"><span>PRÉVIA DE SIMULAÇÃO</span><span className="preview-indicator">● Exemplo</span></div><span className="preview-label">Parcela estimada</span><strong>{loan?brl(loan.payment):'—'}</strong><div className="preview-rule"/><div className="preview-line"><span>Valor de referência</span><b>{loan?brl(loan.principal):'—'}</b></div><div className="preview-line"><span>Prazo</span><b>{loan?.months??'—'} meses</b></div><div className="preview-bars"><span style={{width:loan?Math.max(8,loan.principal/loan.total*100)+'%':'65%'}}/></div><div className="preview-foot"><span>Principal</span><span>Juros</span></div><a href="#/simuladores">Ver cálculo completo <span aria-hidden="true">↗</span></a></div>
          </div>
          <div className="section-heading"><div><span className="eyebrow">ESCOLHA UMA FERRAMENTA</span><h2>Por onde deseja começar?</h2></div><span className="hint">Três formas de explorar seus cenários</span></div>
          <div className="features"><CardLink to="simuladores" icon="▦" title="Simular empréstimo" description="Prestação, juros e tabela de amortização."/><CardLink to="taxas" icon="%" title="Descobrir taxa" description="Estime a taxa mensal implícita em uma prestação."/><CardLink to="comparacao" icon="⇄" title="Comparar opções" description="Visualize diferenças de custo entre cenários."/></div>
          <div className="notice" role="note"><strong>Transparência antes de tudo.</strong> Este simulador é educativo e não oferece crédito. Os cálculos não incluem tarifas, impostos, seguros ou o Custo Efetivo Total (CET). <a href="#/ajuda">Entenda as limitações →</a></div>
        </>}
        {route==='simuladores'&&<>
          <div className="page-heading"><span className="eyebrow">SIMULADOR PRICE</span><h1>Simulador de empréstimo</h1><p>Preencha os valores e veja a estimativa da prestação e da evolução da dívida.</p></div>
          <div className="two-columns"><section className="panel"><h2>Parâmetros</h2><form onSubmit={onSimulate} className="form-grid"><TextField id="principal" label="Valor solicitado (R$)" value={principal} onChange={setPrincipal}/><TextField id="taxa" label="Taxa mensal (%)" value={rate} onChange={setRate}/><TextField id="prazo" label="Prazo (meses)" value={months} onChange={setMonths}/><button type="submit" className="primary">Calcular simulação</button></form><p role="status" className="status">{message}</p><button className="text-button" type="button" onClick={()=>{setPrincipal('15.000');setRate('1,80');setMonths('36');setMessage('Exemplo fictício preenchido.')}}>Preencher exemplo fictício</button></section>
          <section className="panel accent-panel"><span className="eyebrow">RESULTADO ESTIMADO</span>{loan?<><span className="result-label">Prestação mensal</span><strong className="big-number">{brl(loan.payment)}</strong><div className="metric-grid"><Metric label="Total pago" value={brl(loan.total)}/><Metric label="Juros estimados" value={brl(loan.interest)}/><Metric label="Taxa anual efetiva" value={pct(loan.annualRate)}/><Metric label="Parcelas" value={String(loan.months)}/></div>
          <div className="cost-composition"><div className="cost-title"><strong>Composição do pagamento</strong><span>Valor + juros</span></div><div className="cost-bar" role="img" aria-label={`Capital: ${pct(loan.principal/loan.total)}; juros: ${pct(loan.interest/loan.total)}`}><span style={{width:loan.principal/loan.total*100+'%'}}/></div><div className="cost-legend"><span><i className="legend-capital"/> Capital {pct(loan.principal/loan.total)}</span><span><i className="legend-interest"/> Juros {pct(loan.interest/loan.total)}</span></div></div>
          </>:<p>Calcule para ver seus resultados.</p>}</section></div>
          {loan&&<section className="panel spaced"><div className="section-heading"><div><h2>Tabela de amortização</h2><p>Valores estimados e arredondados a centavos.</p></div><div className="actions"><button className="secondary" type="button" onClick={()=>download('simulacao-price.csv',csvFor(loan),'text/csv;charset=utf-8')}>Exportar CSV</button><button className="secondary" type="button" onClick={()=>window.print()}>Imprimir / PDF</button></div></div><p className="table-scroll-hint">Deslize a tabela horizontalmente para visualizar mais colunas →</p><div className="table-scroll"><table><thead><tr><th>Parcela</th><th>Prestação</th><th>Juros</th><th>Amortização</th><th>Saldo</th></tr></thead><tbody>{loan.schedule.slice(0,allRows?undefined:12).map(row=><tr key={row.index}><td>{row.index}</td><td>{brl(row.payment)}</td><td>{brl(row.interest)}</td><td>{brl(row.amortization)}</td><td>{brl(row.balance)}</td></tr>)}</tbody></table></div>{loan.months>12&&<button type="button" className="text-button" onClick={()=>setAllRows(v=>!v)}>{allRows?'Mostrar somente 12':'Mostrar todas as '+loan.months+' parcelas'}</button>}</section>}
        </>}
        {route==='taxas'&&<>
          <div className="page-heading"><span className="eyebrow">CÁLCULO INVERSO</span><h1>Descubra a taxa implícita</h1><p>Estime os juros mensais a partir do valor financiado, prestação e prazo.</p></div>
          <div className="two-columns"><section className="panel"><h2>Dados da prestação</h2><form className="form-grid" onSubmit={onInfer}><TextField id="taxa-valor" label="Valor financiado (R$)" value={ratePrincipal} onChange={setRatePrincipal}/><TextField id="taxa-parcela" label="Valor da prestação (R$)" value={ratePayment} onChange={setRatePayment}/><TextField id="taxa-prazo" label="Número de parcelas" value={rateMonths} onChange={setRateMonths}/><button type="submit" className="primary">Calcular taxa</button></form></section><section className="panel accent-panel"><span className="eyebrow">TAXA ESTIMADA</span><strong className="big-number" role="status">{implied??'—'}</strong><p>Esta é uma taxa matemática estimada para prestações fixas, não necessariamente o CET contratual.</p></section></div>
          <section className="panel spaced"><h2>Saldo devedor teórico</h2><p>Estimativa pelo valor presente das parcelas futuras. Não representa o valor oficial de quitação.</p><form className="form-grid form-grid-wide" onSubmit={onBalance}><TextField id="saldo-parcela" label="Parcela (R$)" value={balancePayment} onChange={setBalancePayment}/><TextField id="saldo-taxa" label="Taxa mensal (%)" value={balanceRate} onChange={setBalanceRate}/><TextField id="saldo-prazo" label="Parcelas restantes" value={balanceMonths} onChange={setBalanceMonths}/><button type="submit" className="primary">Estimar saldo</button></form>{balanceResult&&<div className="inline-result" role="status">Saldo teórico: <strong>{balanceResult}</strong></div>}</section>
        </>}
        {route==='comparacao'&&<>
          <div className="page-heading"><span className="eyebrow">ANÁLISE DE CENÁRIOS</span><h1>Compare três cenários</h1><p>Exemplos ilustrativos baseados no valor e prazo da última simulação. Não correspondem a propostas de instituições.</p></div>
          <div className="compare-controls"><div><label htmlFor="taxa-variacao">Diferença entre taxas <strong>± {compareSpread.toFixed(1).replace('.',',')} ponto(s) percentual(is)</strong></label><p>Deslize para testar como mudanças nos juros afetam o custo total.</p></div><input id="taxa-variacao" type="range" min="0.1" max="1" step="0.1" value={compareSpread} onChange={event=>setCompareSpread(Number(event.target.value))} /></div>
          <div className="compare-grid">{comparison.map((item,index)=><section className={'compare-card'+(index===1?' recommended':'')} key={index}><span className="eyebrow">{index===1?'CENÁRIO BASE':'CENÁRIO '+(index+1)}</span><h2>{pct(item.rate)} <small>ao mês</small></h2><span>Prestação estimada</span><strong className="big-number">{brl(item.payment)}</strong><div className="divider"></div><Metric label="Total pago" value={brl(item.total)}/><Metric label="Juros totais" value={brl(item.interest)}/><Metric label="Prazo" value={item.months+' meses'}/></section>)}</div>{comparison.length===3&&<div className="compare-insight" aria-live="polite"><span className="insight-symbol" aria-hidden="true">↘</span><div><strong>Diferença no total pago: {brl(comparison[2].total-comparison[0].total)}</strong><span>Entre a menor e a maior taxa deste comparativo, mantendo valor e prazo iguais.</span></div></div>}<div className="notice"><strong>Comparações educativas.</strong> Os exemplos não são propostas bancárias. Para alterar o valor ou prazo de referência, <a href="#/simuladores">faça outra simulação →</a>.</div>
        </>}
        {route==='ferramentas'&&<>
          <div className="page-heading"><span className="eyebrow">UTILITÁRIOS LOCAIS</span><h1>Ferramentas locais</h1><p>Guarde cenários genéricos e examine um CSV numérico. Não coloque informações de clientes neste aplicativo.</p></div>
          <div className="two-columns"><section className="panel"><h2>Histórico opcional</h2><p>Dados numéricos salvos apenas no IndexedDB deste dispositivo; não há sincronização.</p><button className="primary" type="button" onClick={saveCurrent}>Salvar simulação atual</button><button className="secondary spaced-button" type="button" onClick={()=>download('historico-simulacoes.json',JSON.stringify(records,null,2),'application/json')}>Exportar histórico JSON</button><ul className="history-list">{records.map(item=><li key={item.id}><span>{brl(item.principal)} · {pct(item.rate)} a.m. · {item.months} meses</span><button className="text-button" type="button" onClick={()=>void erase(item.id)} aria-label={'Excluir simulação de '+brl(item.principal)}>Excluir</button></li>)}</ul>{records.length>0&&<button className="text-button danger" type="button" onClick={eraseAll}>Apagar todo o histórico</button>}</section><section className="panel"><h2>Validar planilha CSV</h2><p>Importação local de um CSV numérico com as colunas <code>valor;taxa;prazo</code>. Limite de 500 linhas, até 1 MB. Nenhum arquivo é enviado.</p><label className="field" htmlFor="csv"><span>Arquivo CSV sem dados pessoais</span><input id="csv" type="file" accept=".csv,text/csv" onChange={readCSV}/></label><button className="secondary spaced-button" type="button" onClick={()=>download('exemplo-simulacoes.csv','valor;taxa;prazo\n15000;1,8;36\n8000;2,0;24','text/csv;charset=utf-8')}>Baixar exemplo CSV</button><p>{csvRows} linha(s) válidas na última leitura.</p></section></div><p role="status" className="status">{toolMessage}</p>
        </>}
        {route==='ajuda'&&<>
          <div className="page-heading"><span className="eyebrow">TRANSPARÊNCIA</span><h1>Ajuda e limites do simulador</h1><p>Entenda o que os números representam antes de tomar qualquer decisão financeira.</p></div>
          <div className="faq"><section className="panel"><h2>Qual é o método de cálculo?</h2><p>Usamos a Tabela Price, com prestações aproximadamente constantes, taxa mensal fixa e amortização decrescente do saldo. A última parcela compensa arredondamentos.</p></section><section className="panel"><h2>Os valores são ofertas bancárias?</h2><p>Não. As simulações são educativas. Nenhuma taxa ou marca de instituição representa condições de crédito vigentes.</p></section><section className="panel"><h2>O que falta na conta?</h2><p>Tarifas, seguros, tributos, outras despesas, particularidades contratuais e o Custo Efetivo Total (CET). Para propostas reais, use documentos oficiais da instituição financeira.</p></section><section className="panel"><h2>Meus dados são enviados?</h2><p>Não há backend ou telemetria própria. O histórico só é criado ao clicar em salvar e fica no navegador. Evite importar qualquer dado pessoal.</p></section><section className="panel"><h2>Como funciona o GitHub Pages?</h2><p>Esta aplicação é formada por arquivos estáticos compilados. Todos os cálculos funcionam no navegador, sem PHP nem banco de dados remoto.</p></section></div>
        </>}
      </main>
      <footer className="footer"><span>e-Consignado · Projeto educativo</span><span>Não é aconselhamento financeiro nem oferta de crédito.</span></footer>
    </div>
  </div>
}
