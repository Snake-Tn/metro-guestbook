### Install
This manual assumes that docker (`v>17`) and docker-compose (`v.3`) are installed on your host machine.

Once you finish all the instructions, the application will be available on http://local.metro-guestbook:8001
 
##### download source code and cd to the root of the repo.
```bash
git clone https://github.com/Snake-Tn/metro-guestbook.git
cd metro-guestbook
```


##### hosts config
Add an entry `127.0.0.1 local.metro-guestbook` to your `/etc/hosts` file:
```bash
sudo sh -c "echo '127.0.0.1 local.metro-guestbook' >> /etc/hosts"
```

##### Create docker containers:
```bash
docker-compose up
```
Docker compose will create 4 containers, `php-fpm` and `ngnix`. 
Once all containers are up and running, you can proceed to the next step.

##### Install php dependencies
Composer will just install `phpunit` and generate our `autoload` script.

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
Application is accessible on http://local.metro-guestbook:8001



