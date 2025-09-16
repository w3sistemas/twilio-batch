# Twilio Lookup Batch — Overlay para Laravel

Este pacote **NÃO é um projeto Laravel completo**. É um **overlay** com código pronto para
processar lotes (upload Excel/CSV) via Twilio Lookup e exportar resultados.
Você aplica estes arquivos **por cima** de um projeto Laravel 11 recém-criado.

## Passo a passo (novo projeto)

```bash
# 1) Criar projeto laravel (sem vendor no overlay)
composer create-project laravel/laravel twilio-batch
cd twilio-batch

# 2) Copiar o conteúdo deste ZIP para a raiz do projeto (sobrescrevendo se pedir)

# 3) Instalar pacotes necessários
composer require maatwebsite/excel:^3.1 twilio/sdk
composer require laravel/breeze --dev

# 4) Instalar Breeze (login simples) e construir assets (Blade)
php artisan breeze:install blade
npm install
npm run build

# 5) Registrar o provider do módulo (uma vez)
#   Abra config/app.php e adicione na seção 'providers' (array):
#   App\\Providers\\TwilioBatchServiceProvider::class,

# 6) Ajustar .env (DB, QUEUE e Twilio)
#   Exemplo:
#   QUEUE_CONNECTION=database
#   TWILIO_ACCOUNT_SID=seu_sid
#   TWILIO_AUTH_TOKEN=seu_token

# 7) Migrar e criar tabelas da fila (se usar database queue)
php artisan migrate
php artisan queue:table
php artisan migrate

# 8) Rodar o worker
php artisan queue:work

# 9) Acessar /batches autenticado; usar upload para criar um lote e acompanhar o processamento.
```

## Rotas
- GET /batches — dashboard/listagem
- POST /batches — upload/gerar lote
- GET /batches/{batch}/download — baixa Excel do resultado quando pronto

## Observações
- O provider `TwilioBatchServiceProvider` carrega as rotas de `routes/batches.php` automaticamente.
- As views estão em `resources/views/batches/`.
- Limites de arquivo, validações e erros estão implementados no controller.
- Para produção, configure um worker (ex.: Supervisor) para manter `queue:work` ativo.
