<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## Sobre o projeto

Para fazer a implementação do projeto crie um .env na pasta raiz do projeto a partir do .env.example, configure com os dados do banco de dados que você deseje utilizar.

### 1. Rode inicialmente o comando para instalar todas as dependências:

   composer install

### 2. Configurado .env, rode migrate para criar as tabelas do banco de dados.

    php artisan migrate

### 3.Crie o usuário administrador. Rode o comando abaixo para alimentar as tabelas com dados iniciais.

    php artisan db:seed

### 4.Gere a chave da aplicação

    php artisan key:generate

### 5.Crie o link de storage (imagens)

    php artisan storage:link

### 6.Por fim para rodar o projeto rode o comando:

    php artisan serve


### Problemas comuns que podem vir acontecer:

| Erro                       | Solução                                                      |
|---                         |                                                           ---|
| `404 /api/noticias`        | Verifique se `api.php` está declarado no `bootstrap/app.php` |
| `CORS error`               | Configure `SANCTUM_STATEFUL_DOMAINS` no `.env`               |
| `Storage not found`        | Rode `php artisan storage:link`                              |
| Imagens não aparecem       | Verifique se o link de storage foi criado                    |

### O banco de dados pode ficar ao seu criterio ao usar o sqlite ou Mysql, mas caso use Mysql não esqueça de criar o banco de dados, o nome do banco fica ao seu critério:

CREATE DATABASE secretaria_saude CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

Sendo apenas isso:
Enjoy!!! 🚀