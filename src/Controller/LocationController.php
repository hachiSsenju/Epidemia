<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Point;
use App\Entity\Zone;
use App\Repository\PointRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(): Response
    {
        return $this->render('location/add.html.twig', [
            'controller_name' => 'LocationController',
        ]);
    }
    
#[Route('/location/new', name: 'app_location_new')]
public function new(PointRepository $points ,EntityManagerInterface $entityManager): Response
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
    return $this->render('location/add.html.twig', [
        'apiKey' => 'AIzaSyBnZkG7MY5E_8OZuVJhU-yE0l6nu1K0s_w',
        'point' => $point 
        // or inject from env
    ]);
}


#[Route('/save-location', name: 'save_location', methods: ['POST'])]
public function save(Request $request,EntityManagerInterface $entityManager,PointRepository $points): Response
{
    $idF= $_POST['point_id'];
    $id= intval($idF);
    $point=$points->find($id);
    $lat = $request->request->get('latitude');
    $lng = $request->request->get('longitude');
    $location = new Location();
    $location->setLatitude($lat);
    $location->setLongitude($lng);
    $location->setLabel($point->getNomPoint());
    $location->setPoint($point);
    if($location){

        $entityManager->persist($location);
        $entityManager->flush();
    }
    else{
        $entityManager->remove($point);
        $entityManager->flush();
        $this->addFlash('error', 'Location could not be saved.'); // Add
    }
    return $this->redirectToRoute('app_map'); 
}

}
