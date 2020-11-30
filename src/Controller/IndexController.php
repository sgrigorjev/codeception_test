<?php

namespace CodeceptionCuriosity\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use CodeceptionCuriosity\Container;

class IndexController
{
    /**
     * Home page
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function homeAction(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse(
            Container::get()
                ->get('template')
                ->render('index.twig')
        );
    }
}
