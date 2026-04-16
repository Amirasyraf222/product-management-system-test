
### Setup Instruction
- Clone project using `git clone https://github.com/Amirasyraf222/product-management-system-test.git`
- Run `composer install` 
- Run `npm install` 
- Rename `.env.example` to `.env`
- Run `New-Item database/database.sqlite -ItemType File` to create new sqlite file
- Run `php artisan migrate --seed` to migrate database and seed data
- Run `php artisan storage:link` to link to storage app
- Run `php artisan key:generate` to generate key if required (if needed)
- Run `php artisan serve` to run the backend system
- Run `npm run dev` to run the frontend system


- Flow :
    1. Serve `http://127.0.0.1:8000/` to test on UI


### Additional Info :
- I added multiple pages and functions that maybe not in the requirement



