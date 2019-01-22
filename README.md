[![Build Status](https://travis-ci.com/Snake-Tn/metro-guestbook.svg?token=pd8qknJ7Y5UQZCgWZaQx&branch=master)](https://travis-ci.com/Snake-Tn/metro-guestbook)

### Install
This manual assumes that docker (`v>17`) and docker-compose (`v.3`) are both installed on your host machine.

Once you finish all the instructions, the application will be available on http://localhost:8001
 
##### download source code and cd to the root of the repo.
```bash
git clone https://github.com/Snake-Tn/metro-guestbook.git
cd metro-guestbook
```

##### Create docker containers:
```bash
docker-compose up
```
Docker compose will create 4 containers, `php-fpm` and `ngnix`. 
Once all containers are up and running, you can proceed to the next step.

##### Install php dependencies
Composer will just install `phpunit` and generate our `autoload` script.
**No** Framework or libraries are used.

```
docker exec -it metro-guestbook_php bash -c "composer install"
```

##### Install assets dependencies (ReactJs)
frontend application is running on ReactJs.
This step can take several minutes.
```
docker run  \
 --workdir="/assets" \
 --mount type=bind,source="$(pwd)"/assets,target=/assets,bind-propagation=rshared  \
 node:slim  /bin/bash -c "npm init -y && npm install && npm run-script build"

 ```
##### Running unit tests
```bash
docker exec -it metro-guestbook_php bash -c "vendor/bin/phpunit"
```


#### Application DEMO
Application is accessible on http://localhost:8001

#### Code design
This source code reflects my oun perspective of **clean code**, bellow a list of the most important criteria:

- Covered with unit-tests
- Single responsibility principle.
- Dependency injection.
- Composition over inheritance.
- Depend on interface instead of implementation (when it's appropriate)
- Clear methods contracts : Do not use associative arrays to pass data around, Use objects.





