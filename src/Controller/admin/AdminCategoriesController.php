<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminCategoriesController
 *
 * @author marga
 */
class AdminCategoriesController extends AbstractController{
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorieRepository;

    const TEMPLATE_CATEGORIES = "pages/admin/admin.categories.html.twig";

    public function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository = $categorieRepository;
    }
    
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response {
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::TEMPLATE_CATEGORIES, [
                    'categories' => $categories
        ]);
    }
    
    #[Route('admin/categories/suppr/{id}', name: 'admin.categorie.suppr')]
    public function suppr(Categorie $categorie): Response {
        $categorieFormations = $categorie->getFormations();
        if(count($categorieFormations) > 0) {
            $this->addFlash('danger', 'Impossible de supprimer une catégorie rattachée à une formation');
            return $this->redirectToRoute('admin.categories');
        } else {
            $this->categorieRepository->remove($categorie, true);
            return $this->redirectToRoute('admin.categories');
        }
    }
    
    #[Route('admin/categories/ajout', name:'admin.categorie.ajout')]
    public function ajout(Request $request): Response {
        if ($this->isCsrfTokenValid('form_ajout_categorie', $request->get('_token'))) {
            $nomCategorie = $request->get("nom");
            $nomExistant = $this->categorieRepository->findByName($nomCategorie);
            if (empty($nomExistant)) {
                $categorie = new Categorie();
                $categorie->setName($nomCategorie);
                $this->categorieRepository->add($categorie, true);
            } else {
                $this->addFlash('danger', "Impossible d'ajouter une catégorie qui existe déjà");
            }
        }
        return $this->redirectToRoute('admin.categories');
    }
}

