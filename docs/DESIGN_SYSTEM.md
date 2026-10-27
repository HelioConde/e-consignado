# Design System — e-Consignado

**Objetivo:** painel financeiro didático, organizado e acessível, com alta legibilidade.

## Identidade
- Fundo principal: #0a1321; superfície: #14263b; bordas: #2c455b.
- Texto principal: #eaf3fc; secundário: #b0c1cf.
- Acento de interação: #6bf1d2 em fundos escuros; texto de botão: #052f2e.
- Anel de foco visível: 3px sólido #baffea.
- Fonte: DM Sans / Manrope, com fallback do sistema; fontes remotas opcionais.
- Espaçamentos: 4, 8, 12, 16, 20, 24, 32, 42, 56px.
- Superfícies: radius 10–21px, divisórias sutis e estados hover/focus distintos.

## Layout
- Desktop: sidebar de 258px, topbar de 66px, conteúdo de até 1200px.
- Tablet: conteúdo em uma coluna, cards em duas.
- Mobile até 800px: sidebar em drawer acionado por botão semântico; backdrop e Escape fecham o menu.
- Telas estreitas de 320px: cards em coluna, tabelas com rolagem interna.
- Impressão: remove controles e navegação; preserva resultados.

## Interação
- Um h1 por rota; h2 para seções.
- Campos com label associado e mensagens via role=status.
- Botões e links nativos e percorríveis por teclado.
- Movimento reduzido respeita prefers-reduced-motion.
- A tabela de amortização pode se estender sem mover o documento horizontalmente.

## Privacidade
- Não solicitar CPF, e-mail, login ou nome.
- IndexedDB é opcional; excluir todos os registros com confirmação.
- CSV somente com esquema numérico valor;taxa;prazo.
