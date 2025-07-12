<?php

namespace App\Controller;

use App\Entity\Point;
use App\Entity\Zone;
use App\Repository\PointRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PointController extends AbstractController
{
    #[Route('/point/add', name: 'app_point_add')]
    public function add(EntityManagerInterface $entityManager, ZoneRepository $zoneRepository, PointRepository $points): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $id= intval($_POST['zone_id']);
        $zone = $entityManager->getRepository(Zone::class)->find($id);
        $point = new Point();
        $point->setNomPoint($_POST['name']);
        $point->setNbSymptomatiques($_POST['nbsymptomatiques']);
        $point->setNbHabitants($_POST['nbHabitants']);
        $point->setNbPositifs($_POST['nbPositifs']);
        $point->setZone($zone); 
        $entityManager->persist($point);
        $entityManager->flush();

            $nb_habitants =0;
            foreach ($points->findAll() as $point) {
                $nb_habitants += $point->getNbHabitants();
            }
            $nb_positif= 0;
            foreach ($points->findAll() as $point) {
                $nb_positif += $point->getNbPositifs();
            }
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
            $zone->setStatus($status);
              $entityManager->flush();

        }
        return $this->render('point/index.html.twig', [
            'zones' => $zoneRepository->findAll(),
        ]);
    }
    #[Route('/point/list', name: 'app_point_list')]
    public function list(EntityManagerInterface $entityManager, ZoneRepository $zoneRepository,PointRepository $pointRepository): Response
    {

        return $this->render('point/list.html.twig', [
            'zones' => $zoneRepository->findAll(),
            'points' => $pointRepository->findAll(),
        ]);
    }
    #[Route('/point/update/{id}', name: 'app_point_update')]
    public function update(EntityManagerInterface $entityManager, ZoneRepository $zoneRepository,PointRepository $pointRepository,  int $id): Response
    {
        $zone_id= intval($_POST["zone_id"]);
        $zone = $zoneRepository->find($zone_id);
        $point = $pointRepository->find($id);
        $point->setNomPoint($_POST['name']);
        $point->setNbSymptomatiques($_POST['nb_symptomatiques']);
        $point->setNbPositifs($_POST['nbPositifs']);
        $point->setNbHabitants($_POST['nbHabitants']);
        $point->setZone($zone); 
        $entityManager->flush();
         $nb_habitants =0;
            foreach ($pointRepository->findAll() as $point) {
                $nb_habitants += $point->getNbHabitants();
            }
            $nb_positif= 0;
            foreach ($pointRepository->findAll() as $point) {
                $nb_positif += $point->getNbPositifs();
            }
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
            $zone->setStatus($status);
            $entityManager->flush();
        return $this->render('point/list.html.twig', [
            'zones' => $zoneRepository->findAll(),
            'points' => $pointRepository->findAll(),
        ]);
    }
    #[Route('/point/delete/{id}', name: 'app_point_delete')]
    public function delete(EntityManagerInterface $entityManager, ZoneRepository $zoneRepository,PointRepository $pointRepository , int $id): Response
    {
        $point = $pointRepository->find($id);
        $zone = $point->getZone();
        $entityManager->remove($point);
        $entityManager->flush();
         $nb_habitants =0;
            foreach ($pointRepository->findAll() as $point) {
                $nb_habitants += $point->getNbHabitants();
            }
            $nb_positif= 0;
            foreach ($pointRepository->findAll() as $point) {
                $nb_positif += $point->getNbPositifs();
            }
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
            $zone->setStatus($status);
            $entityManager->flush();
        return $this->render('point/list.html.twig', [
            'zones' => $zoneRepository->findAll(),
            'points' => $pointRepository->findAll(),
        ]);
    }
}
