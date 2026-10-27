# Design System — e-Consignado 3.1

## Direção visual e Image to Code

A atualização foi baseada nas capturas Playwright do projeto (início, simulador, comparação e ferramentas em 1440px e 320px), preservando o tema azul-noturno/verde-água, a navegação lateral e o estilo de produto educativo.

Problemas observados: hero sem contexto numérico, cartões com pouca hierarquia, ausência de decomposição visual do custo, comparação estática e aproveitamento inconsistente do espaço em telas grandes. A implementação acrescenta prévia resumida, dados explicativos, controles reais, visualização do custo e estilos responsivos.

## Taste: tokens

Tokens definidos em \`src/polish.css\` e aplicados sobre a base original \`src/styles.css\`:

- Canvas \`#0b1422\`; superfície \`#14273b\`; superfície elevada \`#192e44\`.
- Linha \`#314b61\`; texto \`#f4f9fd\`; secundário \`#bdcfdd\`.
- Destaque \`#73eed4\`; hover \`#a0ffe8\`; foco \`#b8fff0\`.
- Espaçamento: 4, 8, 12, 16, 20, 24, 32, 48 px.
- Raios: 10, 16, 22 px; superfície principal recebe sombra leve, não brilho excessivo.

### Componentes e regras

- **Hero:** proposta de valor clara, CTA primário e painel de prévia identificada como exemplo.
- **Feature card:** cada cartão é um único link com foco visível e hover discreto.
- **Resultado financeiro:** prestação, métricas e barra proporcional capital/juros com rótulo para leitores de tela.
- **Comparação:** slider controlado de ±0,1 até ±1 p.p. e diferença de custo com atualização imediata.
- **Tabelas:** cabeçalho legível, linhas zebradas, rolagem interna em telas estreitas, impressão sem sidebar.
- **Mensagens:** resultados e limitações financeiras explicitamente identificados.

## Web Design Guidelines e acessibilidade

- Botões e links semânticos; barra de navegação e main com nome acessível.
- \`:focus-visible\` com contorno de 3px, sem perda de contraste.
- Rótulos associados a todos os campos; resultados numéricos têm contexto.
- Navegação mobile: drawer escondido também de leitura visual e tabulação; abre com teclado e fecha com Escape.
- Respeito a \`prefers-reduced-motion\`; nenhuma animação essencial.
- Layout testado em 320, 375, 390, 768, 1024 e 1440 px no Playwright.

## QA

- \`npm test\`: testes de matemática financeira.
- \`npm run build\`: verificação TypeScript + Vite.
- \`npm run test:e2e\`: 36 screenshots de página inteira, exceções JS/HTTP, overflow e imagens quebradas, além de interações principais e \`e2e/ux.spec.ts\`.
- Os artifacts do GitHub Actions incluem screenshots, relatório HTML e diagnósticos JSON.

## Princípios de conteúdo

- Não afirmar que os cálculos representam taxas reais ou ofertas bancárias.
- Não pedir CPF nem armazenar dados pessoais; histórico apenas numérico no navegador.
- Não substituir validação das fórmulas por efeitos visuais.
- Em mudanças futuras, revisar desktop e 320px após modificar componentes financeiros.

## Fluxos UX/UI 3.2

- **Estado pendente:** editar qualquer parâmetro do simulador indica que o valor mostrado é anterior; é obrigatório recalcular antes de salvar. O botão de salvar é desabilitado nesse estado.
- **Histórico recuperável:** cada cartão numérico oferece Reutilizar e Excluir, com confirmação para apagar tudo. Mostrar quantidade armazenada e um estado vazio com instrução.
- **Importação/Exportação local:** JSON histórico estritamente validado, com máximo de 50 itens, e confirmação para persistência; CSV de até 500 linhas com esquema numérico fixo, prévia e exportação de resultados.
- **Feedback:** comunicar quantas linhas CSV foram validadas ou rejeitadas; indicar erros de esquema sem expor dados do arquivo.
- **Responsividade:** área de ações do histórico quebra em telas estreitas, botão principal ocupa toda a largura no celular, tabelas têm rolagem interna.
- **QA:** executar \`e2e/workflows.spec.ts\` junto às 36 capturas Playwright já existentes. Cobrir estado pendente, salvar/carregar/excluir, CSV válido/inválido e JSON numérico/com campo pessoal.


## Identidade da navbar — ícones SVG

- Os seis destinos usam ícones do mesmo conjunto SVG interno em \`src/components/NavIcons.tsx\`, com grade de **24×24**, stroke \`1.8\`, pontas e junções arredondadas.
- Visão geral: quatro painéis; Simuladores: calculadora; Taxas: porcentagem; Comparar: setas bidirecionais; Ferramentas: maleta; Ajuda: interrogação em círculo.
- A área de cada ícone mede **32×32px**, com gráfico de **20×20px**. O estado ativo realça o fundo e preserva o rótulo textual acessível.
- A marca lateral e \`public/icon.svg\` têm o mesmo desenho vetorial geométrico verde-água, sem dependência de tipografia para renderização.
- O botão mobile usa ícones menu/fechar, rótulos ARIA e \`aria-expanded\`, preservando as interações de teclado e Escape.
- Preferência de movimento reduzido elimina transições dispensáveis.
- Playwright em \`e2e/navbar.spec.ts\` valida os seis SVGs e tamanhos, a seleção das páginas, o favicon e o menu de 320 a 768px.
