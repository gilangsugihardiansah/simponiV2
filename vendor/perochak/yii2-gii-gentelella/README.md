Gentelella based CRUD Generator
==================

This generator generates controller and views that implement CRUD (Create, Read, Update, Delete) operations for the specified data model.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist perochak/yii2-gii-gentelella "*"
```

or add

```json
"perochak/yii2-gii-gentelella": "1.0.0"
```

to the require section of your composer.json.

To use this extension, add to main config in gii section following code:

```php
    'gii' => [
            ...
            'generators' => [
                'crud' => [
                    'class' => 'perochak\gii\crud\Generator',
                ],
            ],
        ],
```
