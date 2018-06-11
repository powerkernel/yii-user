Yii Core API
============

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add 
```
{
  "type": "git",
  "url": "git@bitbucket.org:powerkernel/yii-core-api.git"
}
```
to repositories section of your `composer.json` file

Then either run

```
php composer.phar --prefer-source require powerkernel/yii-core-api "@dev"
```

or add

```
"powerkernel/yii-core-api": "@dev"
```

to the require section of your `composer.json` file

DB Migration
------------
Run in `/bin` directory

```
php yii mongodb-migrate --migrationPath=@vendor/powerkernel/yii-core-api/src/migrations --migrationCollection=core_migration
```
