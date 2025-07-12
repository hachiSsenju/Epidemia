<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Point;
use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\PaysRepository;
use App\Repository\PointRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ZoneController extends AbstractController
{
    #[Route('/zone/add', name: 'app_zone_add')]
    public function add(EntityManagerInterface $entityManager, Request $request, PointRepository $points): Response
    {
           


        $zone = new Zone();

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $zone->setStatus('vert');
            $entityManager->persist($zone);
            $entityManager->flush();
            $zone = new Zone();

            $form = $this->createForm(ZoneType::class, $zone);
        }
        return $this->render('zone/index.html.twig', [
           'form' => $form,
        ]);
    }
    #[Route('/zone/list', name: 'app_zone_list')]
    public function list(EntityManagerInterface $entityManager,PaysRepository $paysRepository): Response
    {
        $zones= $entityManager->getRepository((Zone::class))->findAll();

        return $this->render('zone/list.html.twig', [
            'zones' => $zones,
            'payslist' => $paysRepository->findAll() 
        ]);
    }
    #[Route('/zoneCrit/list', name: 'app_zone_crit_list')]
    public function crit(EntityManagerInterface $entityManager, PaysRepository $paysRepository): Response
    {
        $zones = $entityManager->getRepository(Zone::class)->findAll();
        $rougeZones = [];

        foreach ($zones as $zone) {
            if ($zone->getStatus() === 'rouge') {
                $rougeZones[] = $zone;
            }
        }

        return $this->render('zone/list.html.twig', [
            'zones' => $rougeZones,
            'payslist' => $paysRepository->findAll()
        ]);
    }

    #[Route('/zone/update/{id}', name: 'app_zone_update')]
    public function update(EntityManagerInterface $entityManager,PaysRepository $paysRepository , int $id, Request $request): Response
    {
         $paysId= intval($_POST['pays_id']);
        $pays= $entityManager->getRepository((Pays::class))->find($paysId);
        $nb_habitants = $_POST['nbhabitans'];
        $nb_positif= $_POST['nbPositifs'];
        if ($nb_habitants > 0) {
            $percentage = ($nb_positif / $nb_habitants) * 100;
        } else {
            $percentage = 0;
        }
        
        
        if ($percentage <= 5) {
            $status = 'vert';  
        } elseif ($percentage > 5 && $percentage <= 15) {
            $status = 'orange';  
        } else {
            $status = 'rouge';  
        }
        

        $zone= $entityManager->getRepository((Zone::class))->find($id);
        $zone->setNomZone($_POST['name']);
        $zone->setPays($pays);
        $zone->setNbPositifs($_POST["nbPositifs"]);
        $zone->setStatus($status);
        $entityManager->persist($zone);
        $entityManager->flush();

        $zones= $entityManager->getRepository((Zone::class))->findAll();
        return $this->render('zone/list.html.twig', [
            'zones' => $zones,
            'payslist' => $paysRepository->findAll() 
        ]);
    }

    #[Route('/zone/delete{id}', name: 'app_zone_delete')]
    public function delete(EntityManagerInterface $entityManager,PaysRepository $paysRepository, int $id): Response
    {
        $zone =$entityManager->getRepository((Zone::class))->find($id);
        $entityManager->remove($zone);
        $entityManager->flush(); 
        $zones= $entityManager->getRepository((Zone::class))->findAll();
        return $this->render('zone/list.html.twig', [
            'zones' => $zones,
            'payslist' => $paysRepository->findAll() 
        ]);
    }

}
