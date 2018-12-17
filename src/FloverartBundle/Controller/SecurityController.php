<?php

namespace FloverartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function loginAction(Request $request)
    {
        $jsonData = json_decode($request->getContent(),true);

        $login      = isset($jsonData['login']) ? $jsonData['login'] : $request->get('login');
        $password   = isset($jsonData['password']) ? $jsonData['password'] : $request->get('password');

        if (is_null($login) || is_null($password))
            return $this->json(['error' => 'Логин и/или пароль пустые'],422);

        $em = $this->getDoctrine()->getManager();

        $user = $em
            ->getRepository('FloverartBundle:Users')
            ->getAuthUser($login, $password);

        if (empty($user))
            return $this->json(['error' => 'Имя пользователя и пароль не совпадают'],422);

        return $this->json([
            'token' => $user->generateToken(),
            'user'  => [
                'login'     => $user->getLogin(),
                'access'    => ['categories', 'domains', 'users']
            ]
        ]);
    }
}
