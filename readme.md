# laravel-vue-role

## Getting Started

Sebagai pembelajaran penggunaan vue pada laravel 6.5.2 dan penggunaan role managament spatie-permission yang di sediakan pada laravel

sumber https://www.itsolutionstuff.com/post/laravel-58-user-roles-and-permissions-tutorialexample.html

Langkah sebelum memulai :
- sudah menginstal composer (depedencies)
- npm install

proses yang di jalan kan :
- auth:api with jwt-auth
- vue-auth (bearer token) with websanova
- permission with spatie-permission

jalankan perintah penambahan table :
```bash
php artisan migrate
```

jalankan perintah penambahan data :
```bash
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=CreateAdminUserSeeder
```

table pada spatie-permission
![table](https://github.com/maulana20/laravel-vue-role/blob/master/image/table.PNG)

login admin (username: admin@test.com password: admin)
![login](https://github.com/maulana20/laravel-vue-role/blob/master/image/login.PNG)

create role contoh staff
![role](https://github.com/maulana20/laravel-vue-role/blob/master/image/role.PNG)

create user contoh staff
![user](https://github.com/maulana20/laravel-vue-role/blob/master/image/user.PNG)

logout kemudian login dengan staff dan buka role list
![access](https://github.com/maulana20/laravel-vue-role/blob/master/image/access.PNG)
