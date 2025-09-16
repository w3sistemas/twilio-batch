#!/usr/bin/env bash
set -e

echo "Instalando dependências..."
composer require maatwebsite/excel:^3.1 twilio/sdk
composer require laravel/breeze --dev

echo "Instalando breeze (blade)..."
php artisan breeze:install blade || true
npm install
npm run build

echo "Gerando tabela de filas (DB queue)..."
php artisan queue:table || true

echo "Migrações..."
php artisan migrate

echo "Feito! Lembre-se de registrar o provider em config/app.php:"
echo "  App\Providers\TwilioBatchServiceProvider::class,"
