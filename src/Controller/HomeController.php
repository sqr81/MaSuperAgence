<?php
namespace App\Controller;
use App\Repository\AquarelleRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repository, AquarelleRepository $aquarellesrepository): Response
    {
        $properties = $repository->findLatest();
        $aquarelles = $aquarellesrepository->findLatest();
        return $this->render('pages/home.html.twig', 
        ['properties'=> $properties,
        'aquarelles'=> $aquarelles]);
    }
}
?>