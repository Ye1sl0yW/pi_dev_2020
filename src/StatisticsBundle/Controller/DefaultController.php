<?php

namespace StatisticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StatisticsBundle:Default:index.html.twig');
    }
}
