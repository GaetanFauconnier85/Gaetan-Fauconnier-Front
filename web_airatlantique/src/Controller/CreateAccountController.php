<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserFormType;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;

class CreateAccountController extends AbstractController
{
    /**
     * @Route("/create_account", name="create_account")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $encoder = new Argon2iPasswordEncoder();
            $encoded = $encoder->encodePassword($user->getPassword(), $user);
            $user->setPassword($encoded);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render("create_account/index.html.twig",[
            "titre"=>"Création d'un nouveau compte",
            "form"=>$form->createView(),

        ]);
    }

}
