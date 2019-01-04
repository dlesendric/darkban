# Kanban Project
This project represents Kanban board 
This project is in Symfony 4.2+ with ReactJS

### System requirements for build
* PHP 7.1+
* MySQL 5.7+
* npm | yarn

## Setup
```bash
# run composer install
$ composer install

# run npm or yarn
$ npm/yarn install
```
To setup database and connection change connection string, edit .env file
Or create .env.local and override DATABASE_URL.
```dotenv
# ~/.env
DATABASE_URL=mysql://root:root@127.0.0.1:3306/kanban
```

```bash
# change parameters for mysql connection in .env file
$ php bin/console doctrine:database:create

# for development (unit test) run
$ php bin/console doctrine:database:create --env=test

# run migration
# repeat step for unit testing with argument --env=test
$ php bin/console doctrine:migrations:migrate
# or php bin/console doctrine:schema:update --force

# run php server
$ php bin/console server:run

# run react as separate express server
$ cd frontend
$ npm install
$ npm run start 

# to run unit test
$ vendor/bin/phpunit
```

To create db user run following command  or register via app
```bash
#create new user
$ php bin/console create:user
```


### Generate jwt ssh keys
I pushed mine, but you should change it if auth not working or you want to use this project as your starting point
```bash
$ mkdir -p config/jwt # For Symfony3+, no need of the -p option
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```