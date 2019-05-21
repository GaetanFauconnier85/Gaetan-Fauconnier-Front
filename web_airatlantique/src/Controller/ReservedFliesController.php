<?php

namespace App\Controller;

use App\Entity\Fly;
use App\Entity\Journey;
use Doctrine\Common\Collections\ArrayCollection;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class ReservedFliesController extends AbstractController
{
    /**
     * @Route("/reserved_flies", name="reserved_flies")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $tickets = $user->getTickets();
        return $this->render('reserved_flies/index.html.twig', [
            'controller_name' => 'ReservedFliesController',
            'tickets' => $tickets
        ]);
    }
}
