# Installation Guide

Follow these steps to run AarogyaCare locally using Docker:

## Prerequisites
* Docker Desktop & Docker Compose installed.

## Setup Steps
1. Clone the repository and navigate into it.
2. Duplicate `.env.example` into `.env`.
3. Build and launch containers:
   ```bash
   docker-compose up -d --build
   ```
4. Run migrations and database seeders inside the application container:
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```
5. Access the app on [http://localhost:8000](http://localhost:8000).
