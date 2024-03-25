# Teste de desenvolvimento em Yii2 - Coalize

A aplicação será executada tendo um container Docker como base. Nas especificações do teste foi solicitado que utilizasse PHP 7.1, porém essa versão gerou conflitos com algumas extensões PHP utilizadas pelo framework. Por isso optei por utilizar a versão definida no template do Yii (yiisoftware/yii2-php:7.4-apache). Espero que isso não seja um problema!

### Instruções para instalação e execução
``` bash
# clonar o projeto
git clone https://github.com/tuliozl/teste_desenvolvimento_coalize.git

#acessar o diretório
cd teste_desenvolvimento_coalize

# atualizar os pacotes do fornecedor
docker-compose run --rm php composer update --prefer-dist

# executar a istalação
docker-compose run --rm php composer install 

# altear propriedade de grupo de diretórios e criar diretório para upload de imagens
docker-compose run --rm php chgrp -R www-data runtime/ 
docker-compose run --rm php chmod -R a+rwx runtime/ 
docker-compose run --rm php chgrp -R www-data web/assets/ 
docker-compose run --rm php chmod -R a+rwx web/assets/ 
docker-compose run --rm php mkdir web/upload/ 
docker-compose run --rm php chgrp -R www-data web/upload/ 
docker-compose run --rm php chmod -R a+rwx web/upload/

# iniciar o container
docker-compose up -d
```

### Banco de dados
Executar as migrations para criar as tabelas da aplicação
``` bash
docker-compose run --rm php yii migrate
```

### Usuário para autenticação
O usuário para autenticação é criado através do comando ```createuser``` e passando os parâmetros -u (username), -f (firstname) e -p (password).
``` bash
docker-compose run --rm php yii createuser -u=tulio -f=Tulio -p=123mudar
```

### Consumindo as APIs
No reposiório eu disponibilizei um arquicom com as *collections* e um *environment* para execução de testes. Na *environment* há apenas a variável *access_token* que será preenchida automaticamente com o *Bearer token* após a autenticação. Todas as cosultas da *collection* que exigem autenticação já estão configuradas para exibir a variável ```{{access_token}}``` na aba Auth.

##### Autenticação
```POST http://127.0.0.1/auths/login``` enviando *username* e *password*. Retorna status e access_token.

##### Clientes
###### *Create*
```POST http://127.0.0.1/clients``` enviando *photo*, *name*, *gender* (F/M), *cpf*, *address*, *number*, *district*, *city*, *state* e *zipcode* (obrigatórios); *complement* (opcional).

###### *List*
```GET http://127.0.0.1/clients```. Para controlar quantidade de itens retornados e paginação, deve-se enviar os parâmetros *page* (página atual) e *size* (itens por página). Se os parâmetros não forem passados, por padrão será exibido 5 registros e a página atual será 0.

##### Produtos
###### *Create*
```POST http://127.0.0.1/products``` enviando *photo*, *name*, *price* e *client_id* (obrigatórios).

###### *List*
```GET http://127.0.0.1/products```. Para controlar quantidade de itens retornados e paginação, deve-se enviar os parâmetros *page* (página atual) e *size* (itens por página). Se os parâmetros não forem passados, por padrão será exibido 5 registros e a página atual será 0.
Para filtrar os produtos de um cliente, enviar o parâmetro *client* com o seu ID.


> Foi configurado o CRUD para Produtos e Clientes e está disponível na collection.