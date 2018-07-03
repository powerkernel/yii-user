Yii User API
============

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add 
```
{
  "type": "git",
  "url": "git@github.com:powerkernel/yii-user.git"
}
```
to repositories section of your `composer.json` file

Then either run

```
php composer.phar --prefer-source require powerkernel/yii-user "@dev"
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
