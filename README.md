# BindHQ Sales Application

Application record sales for companies.

# How to install dev
1. Clone repo
2. Create `.env.local` with your env vars

# Fast Install
1. Run `./build/install`

# How to run (If fast install fails)
1. `docker-compose build`
2. `docker-compose up -d`
3. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && composer install"`

# Run migrations (If fast install fails)
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console --env=test doctrine:database:create"`
2. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:mi"`

# Load Fixtures (If fast install fails)
1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console doctrine:fixtures:load"`

# Creating migrations
Migrations should <u><b>only</b></u> be executed after a schema change is made to one of the following databases.

1. `docker-compose run -u root --rm php-fpm bash "-c" "cd /var/www/html && ./bin/console do:mi:di"`

# How to use

1. Goto `localhost:8081` and create an account.

# Manual Administration
1. Admin: `localhost:8081/admin`

# Access Tokens
Api requests must pass the Authorisation Header with the value `Bearer {access_token}`.
Access tokens are generated automatically when a user is created. They can be retrieved for a user at `localhost:8081/admin`.

# Routes
1. `'/'` - View Company Sales Summary.
2. `'/api/companies'` - Get json of all companies.
3. `'/api/company/{companyId}/sales'` - Get Sales summary for a company.
