<?php

namespace App\Controllers;

use Philo\Blade\Blade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    /**
     * @var string
     */
    protected $views = '/../../resources/Views';
    /**
     * @var string
     */
    protected $cache = '/../../resources/Cache';
    /**
     * @var Blade
     */
    protected $blade;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->views = __DIR__.$this->views;
        $this->cache = __DIR__.$this->cache;
        $this->blade = new Blade($this->views, $this->cache);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getIndex(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->responseTemplate($response, 'index', []);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $passwordResetToken
     * @return ResponseInterface
     */
    public function getResetPassword(ServerRequestInterface $request, ResponseInterface $response, $passwordResetToken)
    {
        $data = ['token' => $passwordResetToken['value']];

        return $this->responseTemplate($response, 'passwordReset', $data);
    }

    /**
     * @param ResponseInterface $response
     * @param $view
     * @param array $data
     * @return ResponseInterface
     */
    private function responseTemplate(ResponseInterface $response, $view, array $data)
    {
        $response->getBody()->write($this->blade->view()->make($view, $data));

        return $response;
    }
}