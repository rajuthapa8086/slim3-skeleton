<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface as Container;
use Psr\Http\Message\ResponseInterface as Response;

abstract class AbstractBaseController
{
    /**
     * @var Interop\Container\ContainerInterface
     */
    protected $container = null;

    /**
     * @var array
     */
    protected $responseAs = [
        'keyword' => 'response',
        'send' => 'html',
        'supported' => ['html', 'json'],
    ];

    /**
     * Constructor
     *
     * @param Interop\Container\ContainerInterface $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->initResponseAs();
    }

    /**
     * Initializes responseAs
     */
    public function initResponseAs()
    {
        $get = filter_input(INPUT_GET, $this->responseAs['keyword']);
        $get = strtolower($get);
        if (!is_null($get)) {
            if (in_array($get, $this->responseAs['supported'])) {
                $this->responseAs['send'] = $get;
            }
        }
    }

    /**
     * Returns Appropriate Response
     *
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string $tempate
     * @param array $data
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    protected function getResponse(
        Response $res,
        $template = '',
        array $data = []
    ) {
        return call_user_func_array([
        $this,
        (function () {
            return 'response' . implode('', array_map(
                function ($item) {
                    return ucfirst($item);
                },
                explode('-', str_replace('_', '-', $this->responseAs['send']))
            ));
        })()
        ], [$res, $data, $template]);
    }

    /**
     * Returns Html as Response
     *
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string $tempate
     * @param array $data
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    public function responseHtml(
        Response $res,
        array $data = [],
        $template = ''
    ) {
        return $this->container->view->render($res, $template, $data);
    }

    /**
     * Returns Json as Response
     *
     * @param Psr\Http\Message\ResponseInterface $res
     * @param string $tempate
     * @param array $data
     *
     * @return Psr\Http\Message\ResponseInterface
     */
    protected function responseJson(
        Response $res,
        array $data = []
    ) {
        $res->write(json_encode($data));

        return $res->withHeader('Content-Type', 'application/json');
    }
}
