<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Form\SortieType;
//use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SortieRepository;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;

class SortieController extends AbstractController
{
    #[Route('/Sortie/liste', name: 'sortie_liste')]
    public function index(SortieRepository $sortieRepository)
    {
        $sortie = $sortieRepository->findAll();

        $s = new Sortie();
        $form = $this->createForm(SortieType::class, $s,
                                array('action'  =>$this->generateUrl('sortie_add')));
        
        return $this->renderForm('sortie/liste.html.twig', [ 
            'sorties'=> $sortie,
            'form' => $form ,
          'controller_name' => 'SortieController' ,
          ]);
    }

    
    #[Route('/Sortie/add', name: 'sortie_add')]
    public function add(ManagerRegistry $doctrine, Request $request , SortieRepository $sortieRepository)
    {
        
        $sortie = $sortieRepository->findAll();
        

        $s = new Sortie();
       // $p = new Produit();
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $s = $form->getData();
            $qsortie = $s->getQte();
            $p = $em ->getRepository(Produit::class)->find($s->getProduit()->getId());
            if( $p->getStock() <  $s->getQte() ){
                $s = new Sortie();
                $form = $this->createForm(SortieType::class, $s,
                    array('action' => $this->generateUrl('sortie_add')) );

       // $msg = " Le stock disponible est inférieur à  ". $qsortie;

            return $this->renderForm('sortie/liste.html.twig', [ 
                'sorties'=> $sortie,
                'form' => $form ,
                'error_message' =>  " Le stock disponible est inférieur à  ". $qsortie,
                'controller_name' => 'SortieController' ,
                ]);

            }else{
                $em->persist($s);
                $em->flush();
        
                
                // maj du produit
                $stock = $p->getStock() -  $s->getQte();
                $p->setStock($stock);
                $em->flush(); 

            }

        }
           
     return $this->redirectToRoute('sortie_liste');
    }






}
