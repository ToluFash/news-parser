# News Parser

Application to ingest news, process and store.

# How to install dev
1. Clone repo
2. Create `.env.local` with your env vars

# How to run
1. `docker-compose build`
2. `docker-compose up -d`
3. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && composer install"`

4. Get the bridge IP address
    ```sh
    $ docker network inspect bridge | grep Gateway | grep -o -E '[0-9\.]+'
    # OR an alternative command
    $ ifconfig docker0 | awk '/inet:/{ print substr($2,6); exit }'
    ```
5. Update hosts file to have record for `bridge IP address` news-parser.dev
# Run migrations
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:mi"`
2. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && npm install"`
3. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && npm run watch"`

# If database is not created automatically
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console doctrine:database:create"`

# Creating migrations
Migrations should <u><b>only</b></u> be executed after a schema change is made to one of the following databases.

1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:di"`

# How to use

1. Goto `http://news-parser.dev`

# Manual Administration
1. Run `docker-compose run -u root --rm fb-download bash "-c" "cd /var/www/html && ./bin/console app:feed-download"`
2. Run `docker-compose run -u root --rm process-news bash "-c" "cd /var/www/html && ./bin/console messenger:consume newsProcess"`
3. Run `docker-compose run -u root --rm store-news bash "-c" "cd /var/www/html && ./bin/console messenger:consume newsStore"`
