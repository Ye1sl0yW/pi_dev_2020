<?php

namespace PointsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PointsBundle:Default:index.html.twig');
    }
}
