# Projeto de Tarefas

Projeto de gerenciamento de projetos e tarefas  

## Tecnologias

> Para desenvolvimento desse projeto utilizei como principal ferramenta o framework Laravel 11 rodando na versão 8.2 do PHP.  
> Utilizei banco de dados MYSQL, o DDL e DER das tabelas estão no diretório /database **(arquivos ddl.sql e der.png)**.  
> Para o Front-end utilizei VueJs e TailwindCSS.  
> Para executar a aplicação de maneira fácil e rápida criei um **Dockerfile e docker-compose.yml** onde todo o ambiente está preparado, inclusive o banco de dados.  

## Executando a aplicação

> Para testar o projeto é necessário a instalação do Docker e docker-compose.  
> Para subir o servidor local será necessário entrar no diretório raiz do projeto via terminal e executar o seguinte comando:  

```
docker-compose up -d --build
```
> O comando acima só é necessário quando for executar pela primeira vez pois o docker precisa instalar todas as dependências, em uma próxima vez é só rodar o comando da seguinte forma:  
```
docker-compose up -d
```

> Após a execução do comando acima, a aplicação estará disponível em http://localhost:8080.  
> Observações: O projeto está configurado para rodar na porta 8080, caso essa porta do seu local esteja ocupada, é possível mudar no arquivo **docker-compose.yml**  