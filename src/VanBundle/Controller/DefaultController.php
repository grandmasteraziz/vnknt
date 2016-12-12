<?php

namespace VanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VanBundle\VanBundle;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VanBundle:Default:index.html.twig');
    }

    public function listeleAction()
    {
        return $this->render('VanBundle:Default:listele.html.twig');
    }
}
