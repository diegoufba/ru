# Trabalho de Banco de Dados - Gerenciador do RU


Este trabalho foi criado para a disciplina MATA60 - BANCO DE DADOS da UFBA, tem como objetivo mostrar de maneira visual as operações no banco de dados.


## Tecnologias utilizadas
Back-end: XAMPP 8.0.28 (Apache 2.4.56, PHP 8.0.28, SQLite 2.8.17/3.38.5) https://www.apachefriends.org/pt_br/download.html \


Front-end: React, Nodejs v18.15.0 https://nodejs.org/en


## Como configurar
Coloque o pasta do projeto na raiz do seu servidor apache (para o xampp é a pasta 'htdocs') \
Importe o banco de dados ru.sql (localizado na raiz do projeto) \
Edite o arquivo header.php localizado na pasta api com suas credenciais do banco de dados (se você só instalou o xampp, essas são as credenciais padrão)


Baixe as dependências do React com o comando `npm install`


## Como rodar
Inicie o servidor apache e o mysql (pelo aplicativo do xampp ou manualmente) \
Inicie o front-end com o comando `npm start`