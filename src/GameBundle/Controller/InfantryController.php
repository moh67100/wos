<?php

namespace GameBundle\Controller;


use GameBundle\Entity\InfantryBuild;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use GameBundle\Entity\InfantryTown;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InfantryController extends Controller
{
    public function indexAction($id, Request $request) {
        $infantryBuild = new InfantryBuild();
        $genin = $this->getDoctrine()->getRepository('GameBundle:Infantry')->findOneById($id);
        $infantryInBuild = $this->container->get('game.infantry_manager')->getInfantryBuild($genin);

        $infantryBuild->setTown($this->getUser()->getTownCurrant());
        $infantryBuild->setInfantry($genin);
        $nb = $this->getDoctrine()->getRepository('GameBundle:InfantryTown')->nb($id, $this->getUser()->getTownCurrant());

        $form = $this->createFormBuilder($infantryBuild)
            ->add('nb', IntegerType::class, array('label' => 'Nombre'))
            ->getForm();;

        $form->handleRequest($request);
        if ($form->isValid()) {
            //Voir si assez de ressource
            $isBuildable = $this->container->get('game.infantry_manager')->ifBuildable($genin, $infantryBuild->getNb());

            if($isBuildable) {
                $infantryBuild->setBeginFormation(time());
                $em = $this->getDoctrine()->getManager();
                $em->persist($infantryBuild);
                $em->flush();
            }
        }

        return $this->render('GameBundle:Building:academie.html.twig', array('title' => 'Recrutement Genin',
            'form' => $form->createView(), 'infTown' => $nb->getNb(), 'infInBuild' => $infantryInBuild, 'infantry' => $genin));
    }

    public function academieAction(Request $request)
    {
        //Mise à jour unité
        $this->getDoctrine()->getRepository('GameBundle:InfantryBuild')->maj(1);


    }
}