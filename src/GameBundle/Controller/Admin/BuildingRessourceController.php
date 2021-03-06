<?php
/**
 * This file is part of the World Of Shinobi (Minegame).
 *
 * Copyright (c) 2017. Vincent Glize <vincent.glize@live.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GameBundle\Controller\Admin;

use GameBundle\Entity\Building;
use GameBundle\Entity\BuildingRessource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GameBundle\Form\BuildingRessourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BuildingRessourceController extends Controller
{
    public function indexAction()
    {
        return $this->render('GameBundle:Admin/BuildingRessource:index.html.twig', array('title' => 'Gestion des ressource nécessaire pour les batiments'));
    }

    public function addAction(Request $request)
    {
        $building = new BuildingRessource();

        $form = $this->createForm(BuildingRessourceType::class, $building);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($building);
            $em->flush();
            $msg = "Bien enregistré";
        }

        return $this->render('GameBundle:Admin/BuildingRessource:form.html.twig', array('title' => 'Ajout de ressource nécessaire pour les batiments',
            'form' => $form->createView()));
    }

    public function addIdAction($id, Request $request)
    {

        $building = new BuildingRessource();
        $b = $this->getDoctrine()->getRepository('GameBundle:Building')->findOneById($id);
        $building->setBuilding($b);

        $form = $this->createFormBuilder($building)
            ->add('nb', IntegerType::class, array('label' => 'Ressource nécessaire'))
            ->add('ressource', EntityType::class, array(
                'class' => 'GameBundle:Ressource',
                'choice_label' => 'name'
            ))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($building);
            $em->flush();
            if($b->getId() != $id)
                return $this->redirectToRoute('game_admin_building_ressource_add_id', array('id' => $b->getId()));
        }

        $buildingR = $this->getDoctrine()->getRepository('GameBundle:BuildingRessource')->findByBuilding($id);

        return $this->render('GameBundle:Admin/BuildingRessource:form.html.twig', array('title' => 'Ajout de ressource nécessaire pour '.$building->getBuilding()->getName(),
            'buildingRessource' => $buildingR,
            'building' => $b,
            'form' => $form->createView()));
    }

    public function listAction() {
        $building = $this->getDoctrine()->getRepository('GameBundle:BuildingRessource')->getAll();
        return $this->render('GameBundle:Admin/BuildingRessource:list.html.twig', array('title' => 'Liste des batiments',
                                                                                        'building' => $building));
    }

    public function listIdAction($id) {
        $building = $this->getDoctrine()->getRepository('GameBundle:BuildingRessource')->getAllById($id);
        return $this->render('GameBundle:Admin/BuildingRessource:list.html.twig', array('title' => 'Liste des batiments',
                                                                                        'building' => $building,
                                                                                        'id' => $id));
    }

    public function editAction($id, Request $request) {
        $building = $this->getDoctrine()->getRepository('GameBundle:BuildingRessource')->find($id);

        $form = $this->createForm(BuildingRessourceType::class, $building);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($building);
            $em->flush();
        }

        return $this->render('GameBundle:Admin/BuildingRessource:form.html.twig', array('title' => 'Edit de batiment',
            'form' => $form->createView(), 'building' => $building));
    }

    public function deleteAction(BuildingRessource $br) {
        $id = $br->getBuilding()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($br);
        $em->flush();
        return $this->redirectToRoute('game_admin_building_ressource_add_id', array('id' => $id));
    }

}
