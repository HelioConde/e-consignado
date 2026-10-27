# e-Consignado

Laboratório de **simulações financeiras educativas** para GitHub Pages, feito com React, TypeScript e Vite. Funciona sem PHP, MySQL, login ou backend. Não representa banco, instituição financeira nem oferta real de crédito.

## Funcionalidades

- Cálculo Price de prestação, juros, total e amortização.
- Cálculo inverso da taxa mensal implícita e saldo devedor teórico.
- Comparação de três cenários ilustrativos.
- Histórico opcional e apenas numérico em IndexedDB, sem dados pessoais.
- Validação local de CSV sem dados pessoais; exportação CSV, JSON e impressão/PDF.
- Navegação acessível e layout responsivo em celular, tablet e desktop.
- Playwright com 36 capturas de página inteira, auditoria de JavaScript, HTTP e overflow.

## Rodar

Requer Node 22+.

    npm install
    npm run dev

## Testar e compilar

    npm test
    npm run build
    npx playwright install chromium
    npm run test:e2e

## GitHub Pages

Em Settings > Pages, selecione GitHub Actions. A publicação da branch main executa testes, build e Playwright antes de enviar somente dist/ ao Pages. Endereço: https://helioconde.github.io/e-consignado/.

O workflow de pull request guarda imagens e diagnósticos como artifacts em Actions. Capturas não são enviadas para a página pública.

## Segurança e limites

Simulador matemático, não oferta de crédito. Não inclui CET, tarifas, seguros, impostos nem particularidades contratuais. Nunca informe CPF, nome, telefone, contratos ou dados bancários reais. Nenhuma taxa apresentada é atribuída a um banco.

A versão PHP antiga foi substituída nesta árvore, mas permanece no histórico Git; qualquer credencial antiga deve ser imediatamente revogada e o histórico revisado. Referência para preservar o legado: commit 133d62d3d16d810a84d57289be8afad92232e72e.

Documentação: docs/DESIGN_SYSTEM.md e docs/SECURITY_AUDIT.md.
