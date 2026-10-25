<div align="center">
  <h1>💼 e-Consignado</h1>
  <p><strong>Experimento histórico de portal PHP com simulações e ferramentas relacionadas a empréstimo consignado.</strong></p>
  <p><img alt="PHP" src="https://img.shields.io/badge/PHP-Aplica%C3%A7%C3%A3o-777BB4?logo=php&logoColor=white"> <img alt="Status" src="https://img.shields.io/badge/status-legado%20n%C3%A3o%20auditado-64748b"></p>
</div>

## Visão do projeto

O repositório registra uma antiga experiência de desenvolvimento de telas, navegação, cadastros e consultas relacionadas ao universo de **crédito consignado**. Contém páginas PHP e dados de demonstração usados durante a construção.

**Não é uma plataforma financeira em produção, simulador regulamentado ou produto de aconselhamento de crédito.** Os cálculos e regras não foram revalidados contra legislação, instituições ou taxas atuais.

## Prévia das telas

| Entrada | Simulação | Consulta |
| --- | --- | --- |
| ![Página de entrada](img/index.png) | ![Tela de simulação](img/index2.png) | ![Tela auxiliar](img/index3.png) |

## Tecnologias e estrutura

- **PHP** para as páginas e rotinas de servidor.
- **HTML/CSS/JavaScript** para interface e navegação.
- Arquivos de configuração e banco no código legado.
- Imagens e demais assets em `img/`, `css/` e `js/`.

Arquivos como `index.php`, `acesso.php`, `config.php`, `database.php` e outras rotinas `.php` fazem parte do estudo.

## Executar para estudo

Utilize um ambiente **local isolado**, PHP compatível e um banco de testes quando necessário.

```bash
git clone https://github.com/HelioConde/e-consignado.git
cd e-consignado
php -S 127.0.0.1:8000
```

Acesse `http://127.0.0.1:8000`. **Algumas páginas podem exigir dependências, sessões ou configurações históricas não reproduzidas aqui.**

## Antes de qualquer uso real

- Revise os arquivos de configuração para identificar **senhas, chaves ou dados históricos** e substitua/revogue o que for necessário.
- Valide autenticação, autorização, sessões, consultas SQL, entradas e saída HTML.
- Não processe CPFs, contratos, dados bancários ou informações de consumidores.
- Documente as regras financeiras com fontes atuais e revise com profissional habilitado antes de oferecer qualquer cálculo ao público.
- Adicione testes e mantenha a aplicação indisponível na internet até passar por auditoria.

**Status:** preservado como aprendizado técnico. Desenvolvido por [Hélio Conde](https://github.com/HelioConde).
