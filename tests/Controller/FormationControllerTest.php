<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationControllerTest
 *
 * @author margauxlacheze
 */
class FormationControllerTest extends WebTestCase {
    
    /**
     * Teste le tri des formations alphabétiquement en ordre ascendant
     */
    public function testTriAscTitleFormation() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/title/ASC');
        // vérifie le nom de la ville de la première ligne du tableau
        $this->assertSelectorTextContains('h5', 'Android Studio (complément n°1) : Navigation Drawer et Fragment');
    }
    
    /**
     * Teste le tri des formations en fonction des playlists triées alphabétiquement en ordre ascendant
     */
    public function testTriAscPlaylistsFormation() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/name/ASC/playlist');
        // vérifie le nom de la playlist de la première ligne du tableau
        $this->assertSelectorTextContains('table tbody tr:first-child td:nth-child(2)', 'Bases de la programmation (C#)');
    }
    
    /**
     * Teste le tri des formations en fonction des dates de publications triées en ordre ascendant
     */
    public function testTriAscDatePublication() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/formations/tri/publishedAt/ASC');
        // vérifie la valeur de la date de publication de la première ligne du tableau
        $this->assertSelectorTextContains('table tbody tr:first-child td:nth-child(4)', '25/09/2016');
    }
    
    /**
     * Teste le formulaire de filtre des noms des formations
     */
    public function testFiltreNom() {
        $client = static::createClient();
        $client->request('GET', '/formations');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
           'recherche' => 'technique' 
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(2, $crawler->filter('h5'));
        // vérifie le nom de la formation sur la première ligne du tableau
        $this->assertSelectorTextContains('h5', 'Eclipse n°6 : Documentation technique');
    }
    
    /**
     * Teste le formulaire de filtre des noms de playlist
     */
    public function testFiltrePlaylist() {
        $client = static::createClient();
        $client->request('GET', '/formations');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'embarquée'
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        // vérifie si la date de formation est celle attendue sur la première ligne
        $this->assertSelectorTextContains('table tbody tr:first-child td:nth-child(4)', '27/10/2016');
    }
    
    /**
     * Teste le clic sur le lien de la miniature d'une formation
     */
    public function testLinkFormation() {
        $client = static::createClient();
        $client->request('GET', '/formations');
        // clic sur un lien (image miniature d'une formation)
        $client->clickLink('Miniature de la formation');
        //récupération du résultat du clic
        $response = $client->getResponse();
        //contrôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle si elle est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/formations/formation/1', $uri);
    }
}
