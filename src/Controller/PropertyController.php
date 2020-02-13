<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/photos", name="property.index")
     * @return Response
     */
    public function index(PropertyRepository $repository): Response
    {
        /*$repository = $this->getDoctrine()->getRepository(Property::class);
        autre méthode pour récupérer les données en BDD que la public function __construct*/
        $property = $this->repository->findAll();
        return $this->render('property/index.html.twig', [ 'current_menu' => 'properties']);
    }

    /**
     * @Route("/photo{id}", name="property.show")
     * @return Response
     */
    public function show($id): Response
    {
        /*$repository = $this->getDoctrine()->getRepository(Property::class);
        autre méthode pour récupérer les données en BDD que la public function __construct*/
        $property = $this->repository->find($id);
        return $this->render('property/show.html.twig', [ 'property' => $property,'current_menu' => 'properties']);
    }
    
}
?>