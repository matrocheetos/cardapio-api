# API para Cardápio Virtual

## Desenvolvimento local (Docker)

Iniciar container e serviços (aplicação, FrankenPHP e MySQL)

```
./start.bat
```

## Desenvolvimento local (Laravel)

Iniciar servidor de desenvolvimento:

```
php artisan serve --port=8001
```

# Deploy

Github Actions, commit na `main` branch

## Documentação:

```
php artisan scribe:generate
```

- http://localhost:8001/docs

- https://pratofacil.dynv6.net/docs