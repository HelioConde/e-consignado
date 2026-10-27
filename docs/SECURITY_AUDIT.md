# Auditoria de segurança

Em 27/10/2026, o histórico público legado apresentava rotinas PHP/MySQL, configurações em texto e arquivos de teste e cookies. Não reproduzir essas informações na distribuição.

Esta modernização usa uma nova árvore Git sem páginas PHP, configurações de banco, scripts de busca de CPF, cookies nem conteúdo em vendor. O GitHub Pages recebe somente dist/.

**Atenção:** retirar arquivos de uma branch não limpa os commits antigos. Credenciais e cookies potencialmente expostos devem ser tratados como comprometidos, revogados e, se necessário, removidos do histórico via processo específico com coordenação de clones e forks.

Não publicar dados de clientes reais. O importador aceita apenas três colunas numéricas e não persiste arquivos. A aplicação não tem autenticação real — é um demonstrador público, sem operações bancárias.
