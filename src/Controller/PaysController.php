<?php
namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Pays;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
final class PaysController extends AbstractController
{
    #[Route('/pays/add', name: 'add_pays')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $pays = new Pays();
            $pays->setNomPays($_POST['name']);
            $entityManager->persist($pays);
            $entityManager->flush();

        }
        return $this->render('pays/index.html.twig', [
            'controller_name' => 'PaysController',
        ]);
    }

    #[Route('/pays/list', name: 'list_pays')]
    public function list(EntityManagerInterface $entity_manager): Response
    {
       $payslist= $entity_manager->getRepository((Pays::class))->findAll();

        return $this->render('pays/list.html.twig', [
            'payslist' => $payslist,
        ]);
    }

    #[Route('/pays/update/{id}', name: 'app_pays_update')]
public function update( EntityManagerInterface $entityManager, int $id):Response
{
    $pays = $entityManager->getRepository((Pays::class))->find($id);
$pays->setNomPays($_POST['nom']);
$entityManager->flush();

    $payslist= $entityManager->getRepository((Pays::class))->findAll();

    return $this->render('pays/list.html.twig', [
        'payslist' => $payslist,
    ]);
}

#[Route('/pays/delete/{id}', name: 'app_pays_delete')]
public function delete( EntityManagerInterface $entityManager, int $id):Response
{
    $pays = $entityManager->getRepository((Pays::class))->find($id);
$entityManager->remove($pays);
$entityManager->flush();
    $payslist= $entityManager->getRepository((Pays::class))->findAll();

    return $this->render('pays/list.html.twig', [
        'payslist' => $payslist,
    ]);
}

}
