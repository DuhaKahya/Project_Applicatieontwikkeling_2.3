<?php

namespace App\repositories;

use App\Models\Artist;
use Exception;
use PDO;

class ArtistRepository extends Repository
{
    const SLUG = ':slug';

    public function findArtistBySlug($slug)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT Artists.artistId, Artists.name, Artists.whoIs, Artists.careerSummary, Artists.importantTracks, Artists.imageProfile, Artists.imageCareerHighlights, Artists.imageImportantTracks, Artists.slug
                FROM Artists
                    JOIN ArtistMusicStyles
                        ON Artists.artistId = ArtistMusicStyles.artistId
                    JOIN MusicStyles
                        ON ArtistMusicStyles.musicStyleId = MusicStyles.musicStyleId
                WHERE
                    Artists.slug = :slug;
            ");
            $stmt->bindParam(self::SLUG, $slug);
            $stmt->execute();
            return $stmt->fetchObject(Artist::class);
        } catch (\Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Artist not found.');
            header('Location: /');
            exit();
        }
    }

    public function getAllArtists(): bool|array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    a.artistId,
                    a.name AS artistName,
                    a.whoIs AS whoIs,
                    a.imageIcon AS imageIcon,
                    a.slug AS slug,
                    ms.name AS musicStyleName
                FROM
                    Artists a
                JOIN
                    ArtistMusicStyles ams ON a.artistId = ams.artistId
                JOIN
                    MusicStyles ms ON ams.musicStyleId = ms.musicStyleId
                ORDER BY
                    a.name ASC;
            ");

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $artists = [];
            foreach ($results as $row) {
                $artistId = $row['artistId'];
                if (!isset($artists[$artistId])) {
                    $artists[$artistId] = new Artist();
                    $artists[$artistId]->artistId = $row['artistId'];
                    $artists[$artistId]->name = $row['artistName'];
                    $artists[$artistId]->whoIs = $row['whoIs'];
                    $artists[$artistId]->imageIcon = $row['imageIcon'];
                    $artists[$artistId]->slug = $row['slug'];
                    $artists[$artistId]->events = [];
                }

                $artists[$artistId]->addMusicStyleName($row['musicStyleName']);
            }
            return array_values($artists);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Artists not found.');
            header('Location: /');
            exit();
        }
    }

    public function getAllEvents(): bool|array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    ae.concertStartTime,
                    ae.concertEndTime,
                    ael.name as name,
                    ael.amount,
                    a.artistId,
                    a.name as artistName,
                    a.slug as artistSlug
                FROM
                    ArtistEvents ae
                INNER JOIN
                    ArtistEventLocations ael ON ae.artistEventLocationId = ael.artistEventLocationId
                INNER JOIN
                    Artists a ON ae.artistId = a.artistId;
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Events not found.');
            header('Location: /');
            exit();
        }
    }

    public function findScheduleByArtistSlug($slug): bool|array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    ae.concertStartTime,
                    ae.concertEndTime,
                    ael.name as name,
                    ael.amount
                FROM
                    ArtistEvents ae
                INNER JOIN
                    ArtistEventLocations ael ON ae.artistEventLocationId = ael.artistEventLocationId
                INNER JOIN
                    Artists ON Artists.artistId = ae.artistId
                WHERE
                    Artists.slug = :slug;
            ");
            $stmt->bindParam(self::SLUG, $slug);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Schedule not found.');
            header('Location: /');
            exit();
        }
    }

    public function findSongsByArtistSlug($slug): bool|array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT Songs.songId, Songs.name, Songs.musicPath, Songs.imageCover
                FROM Songs
                JOIN Artists ON Artists.artistId = Songs.artistId
                WHERE Artists.slug = :slug;
            ");
            $stmt->bindParam(self::SLUG, $slug);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, \App\Models\Song::class);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Songs not found.');
            header('Location: /');
            exit();
        }
    }
}
