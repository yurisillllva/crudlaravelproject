# Sistema de Gerenciamento de Categorias Hierárquicas

## crudlaravelproject

Sistema CRUD completo para gerenciamento de categorias e subcategorias com hierarquia ilimitada. Desenvolvido como desafio técnico utilizando as seguintes tecnologias:

Backend: API RESTful com Laravel 8

Frontend: Interface dinâmica com Vue.js 3

Banco de Dados: MySQL

A aplicação permite criar, visualizar, atualizar e excluir categorias de forma hierárquica, com recursos avançados de paginação, busca em tempo real e validações complexas.

Funcionalidades Principais
✅ CRUD completo para categorias e subcategorias
✅ Hierarquia visual com expansão/colapso
✅ Paginação com 5 itens por página
✅ Busca instantânea por nome
✅ Validação de hierarquia (impede auto-relacionamento)
✅ Exclusão em cascata
✅ Interface responsiva
✅ Feedback visual com ícones
✅ Sistema de modais para formulários
✅ Controle de erros e loading states

### Tecnologias Utilizadas
Backend (Laravel)
PHP 7.4

Laravel 8

Eloquent ORM

Laravel Sanctum (Autenticação API)

Laravel CORS

MySQL

RESTful API Design

Frontend (Vue.js)
Vue.js 3

Vue Router

Axios (Comunicação com API)

Bootstrap 4.5

Bootstrap Icons

HTML5/CSS3

ECMAScript 2020

PHPUnit

-- Instalação
--- Pré-requisitos
PHP 7.4+

Composer

Node.js 14+

MySQL 5.7+

## Passo a Passo

### Backend (Laravel)
bash
Copy
git clone backend-repo-url
cd backend
cp .env.example .env
composer install
php artisan key:generate

### Configurar .env com dados do banco
php artisan migrate --seed
php artisan serve --port=8000

### Frontend (Vue.js)
bash
Copy
git clone frontend-repo-url
cd frontend
npm install
npm run serve -- --port=8080
Estrutura da API

### Rotas Principais:

GET /api/categories - Lista paginada

POST /api/categories - Cria nova categoria

GET /api/categories/{id} - Detalhes da categoria

PUT /api/categories/{id} - Atualiza categoria

DELETE /api/categories/{id} - Exclui categoria