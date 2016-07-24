# Slim 3 Skeleton

(Implementing MVC in Slim Framework 3)

## Features:

 * Database Support.
 * Responding as HTML or JSON on the fly. (or with custom response).
 * Twig Template Engine.
 * Controllers.

## Installing and Configuring

 * `$ git clone https://rajuthapa8086/slim3-skeleton.git my-app`
 * `$ cd my-app`
 * `$ cp ./config.php.dist ./config.php`
 * Edit the `config.php`
 * `$ composer install`
 * `$ composer dump-autoload --optimize`
 * `$ chmod -R ./templates/cache 0777`
 * Run `$ php -S localhost:4040 -t public/`

## Swtiching Responses
**To get html as response:**
```
http://localhost:4040/?response=html
```
Or (By default the response is html)
```
http://localhost:4040/
```
**To get json as response:**
```
http://localhost:4040?response=json
```


## Database Usage
```php
// As for example in books controller
<?php

namepace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

BooksController extends AbstractBaseController
{
    /**
     * GET /books
     *
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function index(Request $req, Response $res, $args)
    {
        $db = $this->container->db;
        $sql = <<<SQL
SELECT * FROM "books";
SQL;
        return $this->getResponse($res, 'books/index.twig', [
            'books' => $db['query']($sql, 'execute');
        ]);
    }
}
```

## Notes
* For further more information about database usages [see this gist](https://gist.github.com/rajuthapa8086/0f002a02fa57fce995382877fbfcfa86).

* For twig template [see official documentaion](http://twig.sensiolabs.org/documentation)