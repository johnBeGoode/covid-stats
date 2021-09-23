<?php

namespace App\Controller;

use App\Service\CallAPIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CallAPIService $callApi): Response
    {
        $datas = $callApi->getGlobalDatasForFrance();
        $datasAllDepartments = $callApi->getDatasForAllDepartments();
        
        return $this->render('home/index.html.twig', [
            'datas' => $datas,
            'datasAllDep' => $datasAllDepartments
        ]);
    }
}
