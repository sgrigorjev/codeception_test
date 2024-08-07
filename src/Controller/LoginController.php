<?php

namespace CodeceptionCuriosity\Controller;

use CodeceptionCuriosity\Provider\UserProvider;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use CodeceptionCuriosity\Container;

class LoginController
{
    /**
     * Login action
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function loginAction(ServerRequestInterface $request) : ResponseInterface
    {

        $username = $request->getParsedBody()['username'];
        $password = $request->getParsedBody()['password'];

        $provider = new UserProvider();
        $user = $provider->find($username);

        if (!$user || !$user->verifyPassword($password)) {
            header('Location: /login/failed');
            exit;
        }

        $context = [
            'user' => $user,
        ];

        return new HtmlResponse(
            Container::get()
                ->get('template')
                ->render('login/login.twig', $context)
        );
    }

    /**
     * Login failed action
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function failedAction(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse(
            Container::get()
                ->get('template')
                ->render('login/failed.twig')
        );
    }
}
