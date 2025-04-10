Clone Repositório
```sh
git clone https://github.com/wesleyfernandocabrera/appz.git


```sh
cd appz
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```
Rodar as migrations
```sh
php artisan migrate

Pare os containers se acaso
```sh
docker compose down

Apague os dados do MySQL se acaso der erro no php artisan migrate
```sh
rm -rf ./.docker/mysql/dbdata/*

LINK APP
[http://localhost:8000](http://localhost:8000)

# appz

criar novo
echo "# appz" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/wesleyfernandocabrera/appz.git
git push -u origin main

usar existente

git remote add origin https://github.com/wesleyfernandocabrera/appz.git
git branch -M main
git push -u origin main

#finalizar



talvez tem que rodar isso 

# Pare os containers
docker compose down

# Apague os dados do MySQL
rm -rf ./.docker/mysql/dbdata/*

# Suba novamente
docker compose up -d