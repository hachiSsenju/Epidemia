<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Point;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function map(EntityManagerInterface $em): Response
    {
        // Fetch all location entities from the database
        $points = $em->getRepository(Location::class)->findAll();

        // Build an array for the frontend map
        $locations = [];

        foreach ($points as $point) {
            $locations[] = [
                'lat' => $point->getLatitude(),
                'lng' => $point->getLongitude(),
                'label' => $point->getLabel() ?? 'No label' // Or another field
            ];
        }

        return $this->render('map/map.html.twig', [
            'locations' => $locations,
            'apiKey' => 'AIzaSyBnZkG7MY5E_8OZuVJhU-yE0l6nu1K0s_w'
        ]);
    }
}
