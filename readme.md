# Rest Laravel jwt 

## What is the use of this project
  This a rest API service created with laravel 8 and it uses jwt token to authenticate a user.
  One can run this project on docker also. 
  ### Following features available
  1. You can make http request to the api.
  2. Register and login features with jwt authentication.
  3. Create, edit, delete, search and paginate orders making api requests.


## Live Application URL
  Go to this link to visit our live application.
  [Fuzon media react-admin rest api](https://google.com "Live Application Link")


## Prerequisite

### 1. git 
First check if you have git installed in your machine by this command.
`git --version`
If you dont have git in you machine, [install git](https://github.com/git-guides/install-git) for your machine.


### 2. docker
Check this link <https://docs.docker.com/engine/install/>
to install docker on your machine.


### 3. docker-compose
Use this [guidelines](https://docs.docker.com/compose/install/ "install docker-compose") to install docker-compose in your machine.


### 4.react-admin Rest API
[react-admin rest api](https://github.com/fuzonmedia-projects/react-admin-rest-api "react-admin application's github repo") clone this repo and follow [readme](https://github.com/fuzonmedia-projects/react-admin-rest-api/blob/master/README.md) to run this react app in local. You will use this appliaction to make api calls ,fetch display the data
on web pages. You will able to edit and delete the data also requesting to the api.


You can run this application on any OS (windows, mac, Linux, ubuntu), if you have docker installed on 
your system.

## Run this application

1. Build docker images. 
   #### `docker-compose build`

2. Run the docker containers.
   #### `docker-compose up`

3. create and edit .env file.


3. Run migrations into the docker cotainer.
  #### `docker-compose run php artisan migrate`

4. Laravel application key generate.
  #### `docker-compose run php artisan key:generate`

5. generate jwt secret 
  #### `docker-compose run php artisan jwt:secret`







      
    
   
  
