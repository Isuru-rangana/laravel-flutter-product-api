# Laravel Flutter Product API

A full-stack product management system with Laravel API backend and Flutter mobile app.

## Quick Start

### Backend (Laravel API)
```bash
# Start containers
docker-compose up -d

# Install dependencies
docker exec laravel-product-api composer install

# Setup environment
docker exec laravel-product-api cp .env.example .env
docker exec laravel-product-api php artisan key:generate

# Run migrations
docker exec laravel-product-api php artisan migrate --seed
```

### Mobile App (Flutter)
```bash
cd mobile
flutter run
```

## Access
- **API**: http://localhost:8000
- **Categories**: GET /api/categories
- **Products**: GET/POST /api/products

## Tech Stack
- Laravel 10 + MySQL + Docker
- Flutter + Android Emulator
