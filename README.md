[![Build Status](https://travis-ci.com/Snake-Tn/metro-guestbook.svg?token=pd8qknJ7Y5UQZCgWZaQx&branch=master)](https://travis-ci.com/Snake-Tn/metro-guestbook)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Snake-Tn/metro-guestbook/badges/quality-score.png?b=master&s=05f3f61e1a4506ce510df380cdc9d8ee40603dd5)](https://scrutinizer-ci.com/g/Snake-Tn/metro-guestbook/?branch=master)

## Architecture

The frontend is running on [React](https://reactjs.org/) and consuming a Restful API.
The backend has 4 [Docker](https://www.docker.com/) containers: nginx, php-fpm, mariadb and redis.
Redis is used to store user's session.

![app architecture](uml/app_design.png? "app architecture")

#### Database (MariaDB)

![Database schema](uml/db_design.png? "Database schema")

#### Code design
Bellow the class diagram containing the most relevent classes and relationships, in order to keep it readable, I skipped some infra-structure classes sush as Container and Router.
![Classes diagram](uml/class_diagram.png? "Classes diagram")

This source code reflects my oun perspective of **clean code**, bellow a list of the most important criteria:
- Covered with unit-tests
- Single responsibility principle.
- Dependency injection.
- Composition over inheritance.
- Depend on interface instead of implementation (when it's appropriate)
- Clear method's contract : Do not use associative arrays to pass data around, Use objects.
- Don't make me think : Avoid using 'clever' solutions, always go for the simplest and most straight forward implementation. 

## How to install
This manual assumes that docker (`v>17`) and docker-compose (`v.3`) are both installed on your host machine.

Once you finish bellow instructions, the application will be available on http://localhost:8001
 
##### download source code and cd to the root of the repo.
```bash
git clone https://github.com/Snake-Tn/metro-guestbook.git
cd metro-guestbook
```

##### Install php dependencies
Composer will just install `phpunit` and generate our `autoload` script.

**No Framework or libraries** are going to be installed.

```
docker-compose run  --no-deps php bash -c "composer install && phpunit"
```

##### Install assets dependencies (ReactJs)
frontend application is running on ReactJs.
This step can take several minutes.
```
command -v npm && (cd assets && npm install && npm run-script build) || \
docker run  \
 --workdir="/assets" \
 --mount type=bind,source="$(pwd)"/assets,target=/assets,bind-propagation=rshared  \
 node:slim  /bin/bash -c "npm init -y && npm install && npm run-script build"

 ```
##### Create docker containers:
```bash
docker-compose up
```
Docker compose will create 4 containers, `php` , `ngnix` , `mariadb` and `redis`. 
Once all containers are up and running, you can proceed to the next step.

#### Application DEMO
Application is accessible on 
- http://localhost:8001 (Guest book wall)
- http://localhost:8001/admin (Guest book admin)


