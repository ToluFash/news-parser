# News Parser

Application to ingest news, process and store.

# How to install dev
1. Clone repo
2. Create `.env.local` with your env vars
3. Update hosts file to have record for 127.0.0.1 news-parser.dev

# How to run
1. `docker-compose build`
2. `docker-compose up -d`
3. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && composer install"`

# Run migrations
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:mi"`
2. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && yarn install"`
3. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && yarn watch"`

# If database is not created automatically
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console doctrine:database:create"`

# Creating migrations
Migrations should <u><b>only</b></u> be executed after a schema change is made to one of the following databases.

1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:di"`
