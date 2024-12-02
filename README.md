<h3  align="center">Book Test - CSC Group</h3>

  

## 📝 Sumário

- [Sobre](#sobre)

- [Ambiente](#ambiente)

- [Começando](#comecando)

- [Informações Adicionais](#info)  
  

## 🧐 Sobre <a name = "sobre"></a>



Este projeto é um sistema de gerenciamento de livros que permite realizar operações CRUD (Criar, Ler, Atualizar e Excluir) em registros de livros. Além disso, o sistema consome uma API externa para buscar informações adicionais sobre o autor, como nome e biografia, e exibir esses dados junto com os detalhes do livro.

## 🏝️ Ambiente <a name="ambiente"></a>

Este projeto utiliza docker compose na versão 3.8, contendo as seguintes imagens:

- Nginx
- PHP
- PostgreSQL

  

## 🏁 Começando <a name = "comecando"></a>

Clone o projeto com
````
git clone git@github.com:Lucas040201/book-test.git
````
**OU**
````
git clone https://github.com/Lucas040201/book-test.git
````

Para configurar o projeto, execute o comando `sh build.sh`, dentro da raiz do projeto, para construir as imagens e, consequentemente, os containers.

Ao baixar o projeto pela primeira vez, há algumas configurações necessárias para o funcionamento do sistema. Primeiramente, certifique-se de entrar no container **backend**. Entrar no container é imprescindível, pois é necessário rodar o comando `composer install` para baixar todas as dependências do Laravel.

Após instalar as dependências, crie um arquivo `.env` na raiz do Laravel, apenas copie o `.env.example`. Depois de criar o `.env`, será necessário gerar a chave da aplicação. Para isso, rode o comando `php artisan key:generate` dentro do container **backend**. Em seguida, execute as migrations com o comando `php artisan migrate`.

**Obs:** Não se esqueça de acessar o endereço `localhost:8080` para visualizar seu ambiente em funcionamento.


## :heavy_plus_sign: Informações adicionais <a name="info"></a>

Este projeto inclui testes unitários e de integração. Para executá-los, é necessário acessar o container **backend**. Utilize o seguinte comando:

```bash
docker exec -it nome-container-backend-1 sh
```

O container **backend** utiliza o Alpine Linux, portanto, o shell disponível será o padrão desse sistema. Após acessar o container, basta executar o comando:

```bash
php artisan test
```
Além disso, a API está documentada, para acessar, acesse: `http://localhost:8080/api/documentation`
  
## 👌 Fim