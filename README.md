
## Laravel-5.7 / Vuejs / Jwt-auth Codeline Laravel test

### Demo Video

https://www.useloom.com/share/0de6cf32d0234ea5bd75ae315c3bd267


### Installation
##### 1 - Download or clone the project from the specified git-repo.
##### 2 - Make sure, that your system is running on PHP 7.1
##### 3 - Run "composer install" command to install the required php/laravel dependencies
##### 4 - Run "npm install" command to install the required dependencies
##### 5 - Goto .env.example file of the project, rename it to ".env" file and update following settings
  ###### 5.1 - Mysql Database settings
  ###### 5.2 - Assign APP_URL by "http://yourdomain.com"
  ###### 5.3 - add MIX_APP_URL="${APP_URL}"
##### 6 - Run "php artisan migrate"
##### 7 - Run "composer dump-autoload"
##### 8 - Run "php artisan db:seed"
##### 9 - Assign "777" permissions to application's "storage"
##### 10 - Run php artisan key:generate
##### 11 - Run npm run dev
##### 12 - Run php artisan jwt:secret to generate auth token
##### 12 - Run php artisan storage:link to generate link to folder
##### 13 - Access the application with the specified Urls and login to app and go


### User Credentials
    email : vhs1092@gmail.com
    pass : victor

### Application Description
simple web application for films.

1) BACKEND

1.1) Implement RESTful API to manage films DONE

Films should have fields: DONE

Name
Description
Release Date
Rating
Ticket Price
Country
Genre
Photo

1.2) All fields are required, rating is on scale from 1 to 5, 1 film can have several genres. 


2) FRONTEND

2.1) create frontend page /films/ to show all films through API. 1 film per 1 page. 

2.2) add redirect from / to /films/  


2.3) implement frontend page /films/film-slug-name to show specific film. URL should have film's slug. 

2.4) implement frontend page /films/create with form to create new film. 

2.5) add registration and authentication 

2.6) add possibility to post comments for each films. Fields "Name" and "Comment" are required. 

2.7) only registered users can post comments 