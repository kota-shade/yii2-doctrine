# yii2-doctrine
Yii 2 extension wrapper to communicate with Doctrine 2.

This project was cloned from https://github.com/svp1989/yii2-doctrine.git for feature development.

## Installation
You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require kota-shade/yii2-doctrine
    
## Usage ##
For connecting doctrine components insert in you **config** file
 ```php
'components' => [
...
    'doctrine'  => [
        'class' => \KotaShade\doctrine\components\DoctrineComponent::class,
        'isDev'    => true,            //for development
        'dbParams'    => [
            'driver'   => 'pdo_mysql',     //database driver
            'host'     => '127.0.0.1',
            'port'  => '3306',
            'user'     => 'user',          //database user
            'password' => 'passwd',      //password
            'dbname'   => 'db_name',        //name database
            'charset'  => 'utf8',
            'serverVersion' => '5.6.19',  //setting version allow to retrench one sql query to DB
        ],
        'entityPath' => [              //paths with you entity
            'backend/models/entity',
            'frontend/models/entity',
            'console/models/entity',
            'common/models/entity',
        ],
        'cache' => [ //for metadata caching
            'driver' => \Doctrine\Common\Cache\FilesystemCache::class,
            'options' => [
                'directory' => '@runtime/doctrine',
            ]
        ],
        'proxyPath' => '@runtime/doctrine',
    ]

]
 ```
You can use aliases for proxyPath and directory

For using doctrine console add to you **config** file 
```PHP
'controllerMap' => [
        ....
        'doctrine' => [
            'class'     => 'yii\doctrine\console\DoctrineController',
        ]
    ]
]
```
and call **./yii doctrine**, if you need transfer option use option -o=option.<br>
For example : <br>
    --_create_ table from entity **./yii orm:schema-tool:create** <br>
    --_update_ table from entity **./yii orm:schema-tool:update -o=--force** <br>
    --_create_ table from entity **./yii orm:schema-tool:drop -o=--dump-sql** etc.

