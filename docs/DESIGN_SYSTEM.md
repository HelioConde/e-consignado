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
