<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Entity\Classe;
use App\Entity\Fly;
use App\Entity\Journey;
use App\Entity\Ticket;
use App\Entity\Trip;
use App\Form\TicketType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FlyController extends AbstractController
{
    /**
     * @Route("/fly", name="fly")
     */
    public function index()
    {
        return $this->render('fly/index.html.twig', [
            'controller_name' => 'FlyController'
        ]);
    }

    /**
     * @Route("/fly/searchFly/{airport_start}/{airport_end}/{hour_start}", name="searchFly")
     */
    public function searchFly($airport_start,$airport_end, $hour_start) {

        $a1 = $this->getDoctrine()->getManager()->getRepository(Airport::class)->findOneBy(array('libelle'=>urldecode($airport_start)));

        $a2 = $this->getDoctrine()->getManager()->getRepository(Airport::class)->findOneBy(array('libelle'=>urldecode($airport_end)));


        $trip = $this->getDoctrine()->getManager()->getRepository(Trip::class)->findOneBy(array('airport_start' => $a1,'airport_end' =>$a2));

        //vols direct
        $flies = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findByTrip(urldecode($hour_start), $trip);


        $trueflies = array();

        // Fonction qui va récupérer les prix de chaque vol
        foreach ($flies as $fly) {
            array_push($trueflies, $this->getPrices($fly));
        }

        //vols qui commence après l'heure donnée
        $flyByHours = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findByHourStart(urldecode($hour_start));

        //vols qui commence après l'heure donnée et qui ont comme aeroport le a1 mais pas le a2
        $flyByAirportStarts = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findByAirportStart($hour_start,$a1,$a2);

        $vFinal[] = array();

        foreach ($flyByAirportStarts as $flyByAirportStart)
        {
            $aEnd = $flyByAirportStart->getTripUsed()->getAirportEnd();

            foreach ($flyByHours as $flyByHour) {

                if($flyByHour->getTripUsed()->getAirportStart() == $aEnd && $flyByHour->getTripUsed()->getAirportEnd() == $a2 && $flyByHour->getHourStart()>$flyByAirportStart->getHourStart()){
                    $v[] = array();
                    array_push($v,$this->getPrices($flyByAirportStart));
                    array_push($v,$this->getPrices($flyByHour));

                    unset($v[0]);
                    array_push($vFinal,$v);
                }
                else if ($flyByHour->getTripUsed()->getAirportStart() == $aEnd ){

                }

            }
        }

        unset($vFinal[0]);

        return $this->render('fly/index.html.twig',
            [
                'volsAvecEscales'=>$vFinal,
                'volsDirects'=>$trueflies,
            ]);
    }

    /**
     * @Route("/fly/reserveFly/{fly}", name="reserverVoyage")
     */
    public function reserveFly(Request $request, $fly, \Swift_Mailer $mailer)
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {

            $user = $this->getUser();

            $vol = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findOneById($fly);

            $ticket = new ticket();
            $ticket->setOwner($user);

            $fly = $this->getPrices($vol);

            $classes = array();

            if ($fly[1] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Economique'));
            }
            if ($fly[2] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Buisness'));
            }
            if ($fly[3] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Premium'));
            }

            $form=$this->createForm(TicketType::class, $ticket, array(
                'classes' => $classes
            ));

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {

                $voyage = new Journey();

                $voyage->addFly($vol);

                $ticket->setJourney($voyage);

                $em = $this->getDoctrine()->getManager();
                $em->persist($voyage);
                $em->persist($ticket);
                $em->flush();
                $body = ''.$vol->getTripUsed()->getAirportStart()->getLibelle().' -> '.$vol->getTripUsed()->getAirportEnd()->getLibelle();


                $message = (new \Swift_Message('Information voyage'))
                    ->setFrom('AirAtlantiqueContact@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $body
                    )
                ;

                $mailer->send($message);

                return $this->redirectToRoute('reserved_flies');
            }

            return $this->render('fly/form.html.twig', [
                'formulaire'=>$form->createView(),
                'fly'=>$fly,
                'flies' => null,
                'classes'=>$classes
            ]);

        } else {
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @Route("/fly/reserveManyFly/{fly1}/{fly2}", name="reserveManyVoyage")
     */
    public function reserveManyFly(Request $request, $fly1 , $fly2 ,\Swift_Mailer $mailer)
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->getUser();

            $vol1 = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findOneById($fly1);
            $vol2 = $this->getDoctrine()->getManager()->getRepository(Fly::class)->findOneById($fly2);

            $fly1 = $this->getPrices($vol1);
            $fly2 = $this->getPrices($vol2);

            $classes = array();

            if ($fly1[1] != 0 && $fly2[2] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Economique'));
            }
            if ($fly1[2] != 0 && $fly2[2] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Buisness'));
            }
            if ($fly1[3] != 0 && $fly2[3] != 0){
                array_push($classes, $this->getDoctrine()->getManager()->getRepository(Classe::class)->findOneByLibelle('Premium'));
            }

            $flies = [
                $fly1,
                $fly2
            ];

            $ticket = new Ticket();
            $ticket->setOwner($user);

            $form=$this->createForm(TicketType::class, $ticket, array(
                'classes' => $classes
            ));

            $form->handleRequest($request);


            if($form->isSubmitted() && $form->isValid()) {


                $voyage = new Journey();

                $voyage->addFly($vol1);
                $voyage->addFly($vol2);

                $ticket->setJourney($voyage);

                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->persist($voyage);
                $em->flush();

                $body = ''.$vol1->getTripUsed()->getAirportStart()->getLibelle().' -> '.$vol2->getTripUsed()->getAirportEnd()->getLibelle();


                $message = (new \Swift_Message('Information voyage'))
                    ->setFrom('AirAtlantiqueContact@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $body
                    )
                ;

                $mailer->send($message);

                return $this->redirectToRoute('reserved_flies');
            }

            return $this->render('fly/form.html.twig', [
                'formulaire'=>$form->createView(),
                'fly'=>null,
                'flies' => $flies,
                'classes' => $classes
            ]);

        }
        else
        {
            return $this->redirectToRoute('app_login');
        }

    }

    protected function getPrices($fly) {
        $premium = 300;
        $buisness = 200;
        $economic = 100;
        $plane = $fly->getPlane();
        $places = [
            $plane->getPremium(),
            $plane->getBuisness(),
            $plane->getEconomic(),
        ];
        $multiplicator = 1;
        $today = new DateTime("now");

        //Prix en fonction de la date
        if($fly->getHourStart() > $today->modify('-3 month') || $fly->getHourStart() < $today->modify('-7 day')) {
            $multiplicator = $multiplicator / 4;
        }

        $journeys = $fly->getJourneys();

        $nbPre = 0;
        $nbBui = 0;
        $nbEco = 0;

        foreach ($journeys as $journey) {
            if($journey->getTicket()->getType()->getLibelle() === 'Economique') {
                $nbEco++;
            } else if ($journey->getTicket()->getType()->getLibelle() === 'Buisness')  {
                $nbBui++;
            } else {
                $nbPre++;
            }
        }

        if($nbPre < $places[0] / 4) {
            $premium = 175 * $multiplicator;
        } else if ($nbPre > 3 * $places[0] / 4) {
            $premium = 450 * $multiplicator;
        }
        if($nbBui < $places[1] / 4) {
            $buisness = 100 * $multiplicator;
        } else if ($nbBui > 3 * $places[1] ) {
            $buisness = 400 * $multiplicator;
        }
        if($nbEco < $places[2] / 4) {
            $economic = 50 * $multiplicator;
        } else if ($nbEco > 3 * $places[2] ) {
            $economic = 200 * $multiplicator;
        }

        if ($nbPre === $places[0]) {
            $premium = 0;
        }
        if ($nbBui === $places[1]) {
            $buisness = 0;
        }
        if ($nbPre === $places[2]) {
            $economic = 0;
        }

        $trueFly = [
            $fly,
            $premium,
            $buisness,
            $economic
        ];
        return $trueFly;
    }


}
