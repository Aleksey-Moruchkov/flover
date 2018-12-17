<?php

namespace FloverartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function getUser()
    {
        $user = parent::getUser();
        $em = $this->getDoctrine()->getManager();
        $rule = $em->getRepository('FloverartBundle:UserPermissions')
            ->getListPermissions($user->getId());

        $user->setRule($rule);

        return $user;
    }
}
