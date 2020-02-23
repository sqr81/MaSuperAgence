<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/*use Symfony\Component\BrowserKit\Response as BrowserKitResponse;*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PopertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

/*2.pour recup les photos on a besoin d un constructeur dans lequel on injecte le repo
et on lui donne un nom ($repository)*/
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        /*3.intialisation en creant une propriete*/
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
/*1.recup l ensemble des photos*/
    public function index()
    {
        /*4. sauvegarde dans une variable de la propriete*/
        $properties = $this->repository->findAll();
        /*5 generation de la vue (compact est une methode pour un tableau*/
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }
    
    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Création réussie');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {        
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }
        /* pour que le formulaire gere la requete */
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {   
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token') )){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé');          
        }
        return $this->redirectToRoute('admin.property.index');          
    }
    
}


?>