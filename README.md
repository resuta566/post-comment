
# post-comment
How to run.
	

> Single post with nested comments up to 3 nest depth.

**Back-end**
```
cd backend
cp .env.example .env
composer install
<--if not yet-->
php artisan key:generate
php artisan serve

.env variables

DB_DATABASE=post-comment
DB_USERNAME=root
DB_PASSWORD=
```
**Front-end**
```
npm i
npm run dev

.env variables

API_URL=http://127.0.0.1:8000
```
