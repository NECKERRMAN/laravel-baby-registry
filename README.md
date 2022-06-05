# Storksie | babyregistries made easy

## Author

This application is created by
<!-- language: lang-none -->
------------------------------------------------------------------------------------------
```
    ____  ____  ____  _____   __   ____  _______   ________________ __ __________  ______
   / __ \/ __ \/ __ )/  _/ | / /  / __ \/ ____/ | / / ____/ ____/ //_// ____/ __ \/ ____/
  / /_/ / / / / __ \ / //  |/ /  / / / / __/ /  |/ / __/ / /   / ,<  / __/ / /_/ / __/   
 / _, _/ /_/ / /_/ // // /|  /  / /_/ / /___/ /|  / /___/ /___/ /| |/ /___/ _, _/ /___   
/_/ |_|\____/_____/___/_/ |_/  /_____/_____/_/ |_/_____/\____/_/ |_/_____/_/ |_/_____/
```
------------------------------------------------------------------------------------------

## How to use Storksie? 

1. Create an account
2. Create a registry with a TOP SECRET password
3. Add the articles you want
4. Send the registry link (along with your chosen TOP SECRET password) to friends and/or family
5. Wait for the first email that an item has been bought!


## Deployment @home

* Clone this repo
  ```
  git clone git@github.com:gdmgent-webdev2/werkstuk---geboortelijst-NECKERRMAN.git
  ```

* Cd into /werkstuk---geboortelijst-NECKERRMAN.git

* Run composer install on your terminal

* Copy .env.example file to .env on the root folder and fill in correct details

* Run the following commands:
  ```
    - php artisan key:generate
    - npm install && npm run dev
    - php artisan migrate
    - php artisan serve
  ```

* Storksie is now ready on your localhost
