<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends AbstractController
{
    #[Route('/Produit/liste', name: 'produit_liste')]
    public function index(ProduitRepository $produitRepository){

      $produit = $produitRepository->findAll();

      $p = new Produit();
      $form = $this->createForm(ProduitType::class, $p,
                              array('action'  =>$this->generateUrl('produit_add')));
      
      return $this->renderForm('produit/liste.html.twig', [ 
          'produits'=> $produit,
          'form' => $form ,
        'controller_name' => 'ProduitController' ,
        ]);
}

    #[Route('/Produit/add', name: 'produit_add')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {

        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $p = $form->getData();
        }

/*
        $p->setLibelle("Clavier");
        $p->setStock(0.0);
*/
        $em = $doctrine->getManager();
        $em->persist($p);
        $em->flush();
      
      return $this->redirectToRoute('produit_liste');
    }
}


/*
Produit 1 ---------------- * Entree
OneToMany                        ManyToOne

*/

