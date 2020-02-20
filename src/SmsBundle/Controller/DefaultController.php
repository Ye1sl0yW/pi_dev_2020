<?php

namespace SmsBundle\Controller;

use Nexmo\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SmsBundle:Default:index.html.twig');
    }

    public function smsAction(Request $request){
        //print_r($request);

        return $this->render('@Sms/Default/index.html.twig',array('r'=>$request));
    }
}
