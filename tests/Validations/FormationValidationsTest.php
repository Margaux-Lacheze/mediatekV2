<?php

namespace App\tests\Validations;

use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTest
 *
 * @author margauxlacheze
 */
class FormationValidationsTest extends KernelTestCase {
    
    // Création d'un objet de type Formation
    public function getFormation(): Formation {
        return (new Formation())
                ->setTitle("Tests intégration")
                ->setDescription("test validation exemple")
                ->setVideoId("UW9UoMcHLbc")
                ->setPlaylist((new Playlist())->setName('Playlist test'));
    }
    
    // Création d'une fonction d'assertion qui gère l'appel au kernel et à assertCount()
    public function assertErrors(Formation $formation, int $nbErreursAttendues) {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($formation);
        $this->assertCount($nbErreursAttendues, $errors);
    }
    
    // Teste si la date de formation est valide (pas postérieure à la date du jour)
    public function testValideDateFormation() {
        $formation = $this->getFormation()->setPublishedAt(new DateTime('2030-01-04 17:00:12'));
        $this->assertErrors($formation, 1);
    }
    
}
