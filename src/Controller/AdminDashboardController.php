<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
