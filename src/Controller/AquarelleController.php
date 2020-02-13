<?php
namespace App\Controller;

use App\Entity\Aquarelle;
use App\Repository\AquarelleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AquarelleController extends AbstractController
{
     /**
     * @var AquarelleRepository
     */
    private $repository;

    public function __construct(AquarelleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/aquarelles", name="aquarelle.index")
     * @return Response
     */
    public function index(AquarelleRepository $repository): Response
    {
        
        $aquarelle = $this->repository->findAll();
        return $this->render('aquarelle/index.html.twig', [ 'current_menu' => 'aquarelles']);
    }

    /**
     * @Route("/aquarelle{id}", name="aquarelle.show")
     * @return Response
     */
    public function show($id): Response
    {
        /*$repository = $this->getDoctrine()->getRepository(Property::class);
        autre méthode pour récupérer les données en BDD que la public function __construct*/
        $aquarelle = $this->repository->find($id);
        return $this->render('aquarelle/show.html.twig', [ 'aquarelle' => $aquarelle,'current_menu' => 'aquarelles']);
    }
}
?>