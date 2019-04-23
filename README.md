# WebService REST PHP
Descrição do serviço... (EM CONSTRUÇÃO)

## Instalação

Utilize o [composer](https://getcomposer.org/) para o autoload e para futuras implementações.

Primeiro faça o download ou clone o repositório.

```bash
git clone git@github.com:igorraphael/webservice-php-app-todo.git
```

Rode o composer install, para gerar o autoload(PSR-4).

```bash
composer install
```

Importe o [db.sql](./db.sql)


## Uso 
Utilize algum programa para enviar as requisições. #[Postman](https://www.getpostman.com/) é extramente bom e facil de utilizar.

### Endpoint's 
* **/webservice/todo/listar** - *GET* 
* **/webservice/todo/add** - *POST* - param : nome_tarefa(string), data_hora(datetime) e importancia(string).
* **/webservice/todo/update_status** - *PUT* - param : id_tarefa(int) e status(int) # 0 ou 1.
* **/webservice/todo/delete_task** - *DELETE* - param : id_tarefa(int).


## Contribuindo
Pull requests são bem-vindos. Por favor, abra um issue para discutirmos o que você gostaria de mudar.


