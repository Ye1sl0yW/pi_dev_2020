<?php

namespace NotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NotesBundle:Default:index.html.twig');
    }
}
