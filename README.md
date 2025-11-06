
# Agenda

Agenda de contatos simples sem controle de acesso, apenas CRUD. Utilizando Laravel, VueJS e Docker.


## Execução
* docker-compose build
* docker-compose up -d


## Interface
Interface acessível pelo caminho http://localhost:5173. 
Divida em duas partes:
* A primeira com campos editáveis, onde é possível cadastrar novos contatos ou editar existentes (se foi selecionado para editar previamente). Necessário clicar em Adicionar ou Atualizar para as alterações fazerem Efeito.
* A segunda parte é uma tabela com a lista de contatos, e a opção de editar ou excluir cada contato. Ao clicar em editar, seus dados serão copiados para a area de edição e é permitida a alteração dos dados do respectivo contato.

## API
O Backend é feito por uma API utilizando Laravel e PostgreSQL, com as seguintes rotas:
* [GET] http://localhost:8000/api/contatos retorna a lista de contatos
* [POST] http://localhost:8000/api/criarContato adiciona um novo contato. Necessário passar um JSON no seguinte formato:
```javascript
{
  "Nome": "ABC",
  "Email": "a@b.com",
  "Endereco": "Rua x, 123",
  "Telefone": "47987654231"
}
```
* [PUT] http://localhost:8000/api/atualizarContato/{id} atualiza um contato específico. Necessário passar um JSON no seguinte formato:
```javascript
{
  "Nome": "ABC",
  "Email": "a@b.com",
  "Endereco": "Rua x, 123",
  "Telefone": "47987654231"
}
```
* [DELETE] http://localhost:8000/api/excluirContato/{id} deleta um contato específico. 

Foi utilizado o Insomnia para auxiliar no desenvolvimento e testes das rotas. O arquivo com as chamdas do insmonia exportadas está ja raíz do projeto.