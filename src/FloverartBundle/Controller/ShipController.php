<?php

namespace FloverartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ShipController extends Controller
{
    /**
     * @Route("/list")
     */
    public function list()
    {
        return $this->render('FloverartBundle:Ship:list.html.twig', array(
            // ...
        ));
    }

}
