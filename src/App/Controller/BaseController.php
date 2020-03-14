<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BaseController
{
    
    protected $container;
    protected $jobRepository;
    protected $isAdmin = false;

    public function __construct(\League\Container\Container $container)
    {
        $this->container = $container;
        $this->jobRepository = $container->get(\App\Models\JobRepository::class);
    }
    
    protected function getSession(ServerRequestInterface $request)
    {
        $session = $request->getAttribute('session');
        $segment = $session->getSegment('jobController');
        $this->isAdmin = $segment->get('isAdmin');
        return $segment;
    }

    protected function render($view, $params = []): ResponseInterface
    {
        $templateRenderer = $this->container->get(\League\Plates\Engine::class);
        $response = new \Laminas\Diactoros\Response();
        $response->getBody()
                ->write($templateRenderer->render($view, $params));
        return $response->withStatus(200);
    }
    
    protected function renderJson($data = [])
    {
        $response = new \Laminas\Diactoros\Response();
        $response->getBody()->write(json_encode($data));
        $response->withAddedHeader('content-type', 'application/json')->withStatus(200);
        return $response;
    }
    
}