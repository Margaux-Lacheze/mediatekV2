<?php

namespace App\tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author margauxlacheze
 */
class CategorieRepositoryTest extends KernelTestCase{
    
    /**
     * Méthode qui accède au kernel et récupère l'instance du repository Categorie
     * @return CategorieRepository
     */
    public function recupRepository(): CategorieRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    /**
     *  Méthode qui créé une catégorie pour le test
     * @return Categorie
     */
    public function newCategorie() : Categorie {
        $categorie = (new Categorie())
                ->setName("TestRepository");
        return $categorie;
    }
    
    /**
     * Méthode qui teste le nombre de catégories trouvé après avoir appliqué findByName
     */
    public function testFindByName() {
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $categorieRecherche = $repository->findByName("TestRepository");
        $nbCategories = count($categorieRecherche);
        $this->assertEquals(1, $nbCategories);
    }
    
}
