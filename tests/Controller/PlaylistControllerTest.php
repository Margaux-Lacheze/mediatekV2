<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistControllerTest
 *
 * @author margauxlacheze
 */
class PlaylistControllerTest extends WebTestCase {
    
    /**
     * Teste le tri du nom des playlists alphabétiquement en ordre descendant
     */
    public function testTriDescNom() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/name/DESC');
        // vérifie le nom de la playlist sur la première ligne du tableau
        $this->assertSelectorTextContains('h5', 'Visual Studio 2019 et C#');
    }
    
    /**
     * Teste le tri des playlists par nombre de formations en ordre descendant
     */
    public function testTriDescNbFormations() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/playlists/tri/number/DESC');
        // vérifie le nom de la playlist sur la première ligne du tableau
        $this->assertSelectorTextContains('h5', 'Bases de la programmation (C#)');
    }
    
    /**
     * Teste la soumission du formulaire de filtre sur les noms de playlist
     */
    public function testFiltreNom() {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        // simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
           'recherche' => 'MCD' 
        ]);
        // vérifie le nombre de lignes obtenues
        $this->assertCount(5, $crawler->filter('h5'));
        // vérifie si le nom de la playlist en première ligne du tableau est celui attendu
        $this->assertSelectorTextContains('h5', 'Cours MCD MLD MPD');
    }
    
    /**
     * Teste le clic sur le bouton "Voir détail" d'une playlist
     */
    public function testLinkDetailPlaylist() {
        $client = static::createClient();
        $client->request('GET', '/playlists');
        // clic sur un lien (bouton "Voir détail"
        $client->clickLink('Voir détail');
        //récupération du résultat du clic
        $response = $client->getResponse();
        //contrôle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle si elle est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/playlists/playlist/13', $uri);
    }
}
