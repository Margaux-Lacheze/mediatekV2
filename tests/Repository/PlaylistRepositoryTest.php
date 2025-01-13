<?php

namespace App\tests\Repository;

use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author margauxlacheze
 */
class PlaylistRepositoryTest extends KernelTestCase {
    
    /**
     * Méthode qui accède au kernel et récupère l'instance du repository Playlist
     * @return PlaylistRepository
     */
    public function recupRepository(): PlaylistRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    public function testFindAllOrderByFormationNumber() {
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByFormationsNumber("DESC");
        $this->assertEquals(13, $playlists[0]->getId());
    }
}
