# API para Cardápio Virtual

## Desenvolvimento local (Docker)

Iniciar container e serviços (aplicação, nginx e MySQL)

```
chmod +x setup.sh
./setup.sh
```

## Desenvolvimento local (Symfony)

Iniciar servidor de desenvolvimento:

```
symfony server:start --no-tls --port=8000 -d
```

Parar servidor de desenvolvimento:
```
symfony server:stop
```

# Deploy

```
dep deploy
```

## Documentação:

```
https://pratofacil.dynv6.net/swagger/index.html
```