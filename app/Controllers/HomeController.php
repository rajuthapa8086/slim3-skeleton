<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends AbstractBaseController
{
    /**
     * GET /
     *
     * @param Psr\Http\Message\ServerRequestInterface $req
     * @param Psr\Http\Message\ResponseInterface $res
     * @param array $args
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function index(Request $req, Response $res, array $args)
    {
        return $this->getResponse($res, 'index.twig', [
            'contacts' => [
                (object) [
                    'name' => 'John Doe',
                    'email' => 'john@example.com'
                ],
                (object) [
                    'name' => 'Jane Doe',
                    'email' => 'jane@example.com'
                ]
            ]
        ]);
    }
}
