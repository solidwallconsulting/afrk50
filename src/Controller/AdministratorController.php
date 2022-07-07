<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/admin")
 */
class AdministratorController extends AbstractController
{
    /**
     * @Route("/config", name="config_admin_index")
     */
    public function index(): Response
    {
        return $this->render('administrator/config.html.twig', [
            
        ]);
    }
}
