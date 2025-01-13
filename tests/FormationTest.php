<?php

namespace App\tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author margauxlacheze
 */
class FormationTest extends TestCase{
    
    // Teste de la méthode qui retourne une date en format string
    public function testGetPublishedAtString() {
        $formation = new Formation();
        $formation->setPublishedAt(new DateTime("2025-01-04 17:00:12"));
        $this->assertEquals("04/01/2025", $formation->getPublishedAtString());
    }
}
