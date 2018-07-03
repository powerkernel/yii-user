Yii User API
============

Prerequisites
-------------
- [Yii API Starter Kit](https://github.com/powerkernel/yii-api-starter-kit)
- [Yii Common](https://github.com/powerkernel/yii-common)
- [Yii Auth API](https://github.com/powerkernel/yii-auth)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run

```
composer require powerkernel/yii-user "@dev"
```

or add

```
"powerkernel/yii-user": "@dev"
```

to the require section of your `composer.json` file

DB Migration
------------
Run in `/bin` directory

```
php yii mongodb-migrate --migrationPath=@vendor/powerkernel/yii-user/src/migrations --migrationCollection=user_migration
```

API Documentation
-----------------
[View on Postman](https://documenter.getpostman.com/view/4282480/RWM6xXs3)