<?php

namespace Shov\StocksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/g")
     */
    public function indexAction()
    {
        return $this->render('ShovStocksBundle:Default:index.html.twig');
    }
}
