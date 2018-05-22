Yii Core API
============

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist powerkernel/yii-core-api "*"
```

or add

```
"powerkernel/yii-core-api": "*"
```

to the require section of your `composer.json` file, then run

```
php yii mongodb-migrate --migrationPath=@vendor/powerkernel/yii-core-api/src/migrations --migrationCollection=core_migration
```
