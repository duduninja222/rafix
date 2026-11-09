# Mercado Boa Compra - Sistema de supermercado com PHP

**Integrantes:** (preencher nomes e quem fez cada parte)

## Pré-requisitos
XAMPP (Apache + MySQL/MariaDB), PHP 8+, navegador.

## Como executar
1. Inicie **Apache** e **MySQL** no painel do XAMPP.
2. Copie esta pasta para `C:\xampp\htdocs\supermercado`.
3. Abra `http://localhost/phpmyadmin`, aba **Importar**, e importe `sql/supermercado.sql` (cria o banco, as tabelas e os dados de exemplo).
4. Se seu MySQL tiver senha, ajuste `includes/conexao.php` (padrão: usuário `root`, sem senha).
5. Acesse `http://localhost/supermercado/`.

## Estrutura
- `includes/` conexão PDO reutilizável, cabeçalho e rodapé
- `categorias.php`, `categoria_form.php`, `categoria_excluir.php` CRUD de categorias
- `produtos.php`, `produto_form.php`, `produto_detalhes.php`, `produto_excluir.php` CRUD de produtos (com busca, filtro e alertas)
- `sql/supermercado.sql` criação e carga do banco · `css/style.css` estilos

## Registro de testes
| Situação | Esperado | Observado | Situação |
|---|---|---|---|
| Cadastrar categoria e produto válidos | Salvar e exibir nas listas | | |
| Campos obrigatórios vazios | Recusar e orientar | | |
| Preço negativo / estoque fracionado | Recusar sem alterar | | |
| Código ou nome de categoria repetido | Impedir duplicidade | | |
| Editar nome, preço e categoria | Altera só o produto escolhido | | |
| Buscar e filtrar | Só resultados correspondentes | | |
| Excluir categoria com produtos | Impedir e explicar | | |
| Cancelar / confirmar exclusão | Preserva / remove | | |
| id inexistente ou inválido | Mensagem sem erro interno | | |
| Reabrir a aplicação | Dados mantidos | | |
| Texto com `<` e `>` | Mostrado literal | | |
| Estoque e validade | Destaque e aviso de vencido | | |

## Contribuições
(registrar quem programou e quem testou cada etapa)
