<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    protected $_chain;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        $this->_chain = new \App\Model\Chain();

        return $this->render('index.html.twig', [
            'chain' => $this->_chain,
            'env' => $this->container->get('kernel')->getEnvironment()
        ]);
    }
}