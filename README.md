# Simple API with PHP

This repo is just an example how to make simple Restful API with PHP and MySql.

### How To Use
The following route is an example with localhost

| Function | Req | METHOD | Route |
| ------ | ------ | ------ | ------ |
| Get Categories | - | GET | http://localhost/[YOUR_REPO_NAME]/category/read.php|
| Get All Products | - | GET | http://localhost/[YOUR_REPO_NAME]/product/read.php|
| Get Products by Category | category_id(int) | GET | http://localhost/[YOUR_REPO_NAME]/product/read_by_category.php?category_id=[id_category] |
| Delete Product | id(int) | POST | http://localhost/[YOUR_REPO_NAME]/product/delete.php?id=[id_product] |
| Login | email(string), password(string) | POST | http://localhost/[YOUR_REPO_NAME]/user/login.php |
| Register | nama(string), email(string), password(string)| POST | http://localhost/[YOUR_REPO_NAME]/user/register.php |

##### Get All Products Response Example
```json
{
    "error": false,
    "records": [
        {
            "id": "60",
            "name": "Rolex Watch",
            "description": "Luxury watch.",
            "price": "25000",
            "category_id": "1",
            "category_name": "Fashion"
        },
        {
            "id": "48",
            "name": "Bristol Shoes",
            "description": "Awesome shoes.",
            "price": "999",
            "category_id": "5",
            "category_name": "Movies"
        },
        {
            "id": "42",
            "name": "Nike Shoes for Men",
            "description": "Nike Shoes",
            "price": "12999",
            "category_id": "3",
            "category_name": "Motors"
        },
        {
            "id": "6",
            "name": "Bench Shirt",
            "description": "The best shirt!",
            "price": "29",
            "category_id": "1",
            "category_name": "Fashion"
        }
    ]
}
```

##### Get Category Response Example
```json
{
    "error": false,
    "records": [
        {
            "id": "6",
            "name": "Books",
            "description": "Kindle books, audio books and more."
        },
        {
            "id": "2",
            "name": "Electronics",
            "description": "Gadgets, drones and more."
        },
        {
            "id": "1",
            "name": "Fashion",
            "description": "Category for anything related to fashion."
        },
        {
            "id": "3",
            "name": "Motors",
            "description": "Motor sports and more"
        },
        {
            "id": "5",
            "name": "Movies",
            "description": "Movie products."
        },
        {
            "id": "13",
            "name": "Sports",
            "description": "Drop into new winter gear."
        }
    ]
}
```

##### Get Products by Category Response Example
```json
{
    "error": false,
    "records": [
        {
            "id": "60",
            "name": "Rolex Watch",
            "description": "Luxury watch.",
            "price": "25000",
            "category_id": "1",
            "category_name": "Fashion"
        },
        {
            "id": "48",
            "name": "Bristol Shoes",
            "description": "Awesome shoes.",
            "price": "999",
            "category_id": "5",
            "category_name": "Movies"
        },
        {
            "id": "42",
            "name": "Nike Shoes for Men",
            "description": "Nike Shoes",
            "price": "12999",
            "category_id": "3",
            "category_name": "Motors"
        },
        {
            "id": "6",
            "name": "Bench Shirt",
            "description": "The best shirt!",
            "price": "29",
            "category_id": "1",
            "category_name": "Fashion"
        }
    ]
}
```

##### Login Request with JSON Example
```json
{
    "email" : "user3@user.com",
    "password" : "12345"
}
```

##### Login Response Example
```json
SUCCESS LOGIN
{
    "error": false,
    "uid": "5dd235bb459820.66997611",
    "user": {
        "nama": "user3",
        "email": "user3@user.com"
    }
}
```

```json
Failed LOGIN
{
    "error": true,
    "error_msg": "Login gagal. Password/Email salah"
}
```

##### Register Request with JSON Example
```json
{
    "nama" : "user4",
    "email" : "user4@user.com",
    "password" : "12345"
}
```

##### Register Response Example
```json
FAILED REGISTER
{
    "error": false,
    "uid": "5dd368f8a52483.80420683",
    "user": {
        "nama": "user4",
        "email": "user4@user.com"
    }
}
```
```json
SUCCESS REGISTER
{
    "error": true,
    "error_msg": "User telah ada dengan email user4@user.com"
}
```
### Dummy Datas
just import **_api_db.sql_** as dummy datas

### Test the api
Try it with [postman](https://www.getpostman.com/)

License
----
Free to Use
