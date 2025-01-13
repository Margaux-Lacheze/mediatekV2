<?php


namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AccueilControllerTest
 *
 * @author margauxlacheze
 */
class AccueilControllerTest extends WebTestCase {
    
    /**
     * Teste que la page d'accueil est bien accessible
     */
    public function testAccessPage() {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
}
