<?php

namespace FloverAppsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FloverAppsBundle:Default:index.html.twig');
    }
}
