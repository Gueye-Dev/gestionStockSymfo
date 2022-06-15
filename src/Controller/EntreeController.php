<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntreeRepository;
use App\Entity\Entree;
use App\Form\EntreeType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produit;

class EntreeController extends AbstractController
{
    #[Route('/Entree/liste', name: 'entree_liste')]
    public function index(EntreeRepository $entreeRepository)
    {
        $entree = $entreeRepository->findAll();

        $e = new Entree();
        $form = $this->createForm(EntreeType::class, $e,
                                array('action'  =>$this->generateUrl('entree_add')));
        
        return $this->renderForm('entree/liste.html.twig', [ 
            'entrees'=> $entree,
            'form' => $form ,
          'controller_name' => 'EntreeController' ,
          ]);
    }

  
      #[Route('/Entree/add', name: 'entree_add')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {

        $e = new Entree();
       // $p = new Produit();
        $form = $this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
        }


        $em = $doctrine->getManager();
        $em->persist($e);
        $em->flush();

        // maj du produit
        $p = $em ->getRepository(Produit::class)->find($e->getProduit()->getId());
        $stock = $p->getStock() + $e->getQte();
        $p->setStock($stock);
        $em->flush();
    
     return $this->redirectToRoute('entree_liste');
    }

  }
  
  
    

