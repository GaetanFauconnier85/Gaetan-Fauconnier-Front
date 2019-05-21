<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Entity\Fly;
use App\Entity\Journey;
use App\Entity\Plane;
use App\Entity\Trip;
use App\Form\SearchType;
use App\Form\TestType;
use App\Form\SearchFlyType;
use App\Repository\FlyRepository;
use phpDocumentor\Reflection\Types\Array_;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Tests\A;
use \DateTime;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {

        $test = ['message' => 'Type your message here'];

        $form=$this->createForm(SearchType::class, $test);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $aeroport_start = $data["aeroport_start"];
            $aeroport_end = $data["aeroport_end"];
            $hourStart = $data["hour_start"];

            return $this->redirectToRoute('searchFly', [
                "airport_start" => urlencode($aeroport_start->getLibelle()),
                "airport_end" => urlencode($aeroport_end->getLibelle( )),
                "hour_start" => urlencode($hourStart->format('d-m-Y'))
            ]);

        }

        return $this->render("home/index.html.twig",[
            "titre"=>"Création d'un nouveau compte",
            "form"=>$form->createView(),
        ]);
    }
}
