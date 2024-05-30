-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Gegenereerd op: 07 apr 2024 om 15:31
-- Serverversie: 11.1.3-MariaDB-1:11.1.3+maria~ubu2204
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Project_Applicatieontwikkeling_2_3`
--
DROP DATABASE IF EXISTS `Project_Applicatieontwikkeling_2_3`;
CREATE DATABASE IF NOT EXISTS `Project_Applicatieontwikkeling_2_3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Project_Applicatieontwikkeling_2_3`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ArtistEventLocations`
--

CREATE TABLE `ArtistEventLocations` (
                                        `artistEventLocationId` int(11) NOT NULL,
                                        `name` varchar(255) NOT NULL,
                                        `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ArtistEventLocations`
--

INSERT INTO `ArtistEventLocations` (`artistEventLocationId`, `name`, `amount`) VALUES
                                                                                   (1, 'Patronaat Main Hall', 300),
                                                                                   (2, 'Patronaat Second Hall', 200),
                                                                                   (3, 'Patronaat Third Hall', 150),
                                                                                   (4, 'Grote Markt', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ArtistEvents`
--

CREATE TABLE `ArtistEvents` (
                                `artistEventId` int(11) NOT NULL,
                                `artistId` int(11) NOT NULL,
                                `price` int(11) DEFAULT NULL,
                                `concertStartTime` datetime NOT NULL,
                                `concertEndTime` datetime NOT NULL,
                                `artistEventLocationId` int(11) NOT NULL,
                                `amountOfPeople` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ArtistEvents`
--

INSERT INTO `ArtistEvents` (`artistEventId`, `artistId`, `price`, `concertStartTime`, `concertEndTime`, `artistEventLocationId`, `amountOfPeople`) VALUES
                                                                                                                                                       (2, 7, 15, '2024-07-26 18:00:00', '2024-07-26 19:00:00', 1, 2),
                                                                                                                                                       (3, 4, 15, '2024-07-26 21:00:00', '2024-07-26 22:00:00', 2, 33),
                                                                                                                                                       (4, 3, 10, '2024-07-26 19:30:00', '2024-07-26 22:00:00', 3, 6),
                                                                                                                                                       (5, 8, 15, '2024-07-27 19:30:00', '2024-07-27 20:30:00', 1, 2),
                                                                                                                                                       (6, 2, 10, '2024-07-27 18:00:00', '2024-07-27 19:00:00', 2, 12),
                                                                                                                                                       (7, 5, 15, '2024-07-28 18:00:00', '2024-07-28 19:00:00', 1, 2),
                                                                                                                                                       (8, 12, 15, '2024-07-28 19:30:00', '2024-07-28 20:30:00', 1, 6),
                                                                                                                                                       (9, 9, 15, '2024-07-28 21:00:00', '2024-07-28 22:00:00', 1, 1),
                                                                                                                                                       (11, 6, 10, '2024-07-28 18:00:00', '2024-07-28 19:00:00', 3, 3),
                                                                                                                                                       (12, 11, 10, '2024-07-28 19:30:00', '2024-07-28 20:30:00', 3, 6),
                                                                                                                                                       (14, 11, NULL, '2024-07-29 18:00:00', '2024-07-29 19:00:00', 4, 0),
                                                                                                                                                       (15, 7, NULL, '2024-07-29 19:00:00', '2024-07-29 20:00:00', 4, 0),
                                                                                                                                                       (17, 5, NULL, '2024-07-29 20:00:00', '2024-07-29 21:00:00', 4, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ArtistMusicStyles`
--

CREATE TABLE `ArtistMusicStyles` (
                                     `artistMusicStyleId` int(11) NOT NULL,
                                     `artistId` int(11) NOT NULL,
                                     `musicStyleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ArtistMusicStyles`
--

INSERT INTO `ArtistMusicStyles` (`artistMusicStyleId`, `artistId`, `musicStyleId`) VALUES
                                                                                       (1, 2, 1),
                                                                                       (2, 2, 2),
                                                                                       (3, 4, 1),
                                                                                       (4, 4, 2),
                                                                                       (5, 5, 1),
                                                                                       (6, 6, 1),
                                                                                       (7, 7, 2),
                                                                                       (8, 8, 2),
                                                                                       (9, 8, 4),
                                                                                       (10, 9, 2),
                                                                                       (11, 3, 3),
                                                                                       (12, 3, 5),
                                                                                       (13, 10, 3),
                                                                                       (14, 11, 4),
                                                                                       (15, 12, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Artists`
--

CREATE TABLE `Artists` (
                           `artistId` int(11) NOT NULL,
                           `name` varchar(255) NOT NULL,
                           `whoIs` text NOT NULL,
                           `careerSummary` text NOT NULL,
                           `importantTracks` text NOT NULL,
                           `imageIcon` varchar(255) NOT NULL,
                           `imageProfile` varchar(255) NOT NULL,
                           `imageCareerHighlights` varchar(255) NOT NULL,
                           `imageImportantTracks` varchar(255) NOT NULL,
                           `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Artists`
--

INSERT INTO `Artists` (`artistId`, `name`, `whoIs`, `careerSummary`, `importantTracks`, `imageIcon`, `imageProfile`, `imageCareerHighlights`, `imageImportantTracks`, `slug`) VALUES
                                                                                                                                                                                  (2, 'Myles Sanko', 'Myles Sanko is a British singer, songwriter, and musician known for his soulful and jazz-influenced music. Hailing from Ghana, West Africa, Sanko has gained recognition for his smooth vocals, emotive performances, and heartfelt lyrics. He has released several albums, including', 'Myles Sanko, the British singer and songwriter of Ghanaian descent, has forged a compelling career marked by soulful vocals, musical versatility, and a commitment to authenticity.With a foundation rooted in classic soul and jazz traditions, Sanko\'s music embodies a unique blend of timeless melodies and contemporary flair. His albums, including', 'Myles Sanko has produced a collection of tracks that resonate with audiences, showcasing his soulful voice and musical versatility. While the popularity of songs can evolve over time, here are some tracks that have been particularly well-received:-', '/images/artist/myles-sanko.png', '/images/artist/myles-sanko-profile.png', '/images/artist/myles-sanko-highlights.png', '/images/artist/myles-sanko-tracks.png', 'myles-sanko'),
                                                                                                                                                                                  (3, 'Jonna Fraser', 'Jonna Fraser, born Jonathan Jeffrey Grando, is a Dutch-Surinamese musician and rapper based in Amsterdam. He gained prominence in the Dutch music scene for his distinctive blend of hip-hop and R&B. Known for his smooth rhymes and soulful melodies, Jonna Fraser has built a devoted fan base and is recognized for addressing social issues through his music. His work reflects his multicultural upbringing in Amsterdam, and he has collaborated with both local and international artists, contributing to the global appeal of his music.', 'Jonna Fraser, the stage name of Jonathan Jeffrey Grando, has left an indelible mark on the Dutch music scene with his distinct fusion of hip-hop and R&B. His career boasts a series of noteworthy highlights, showcasing his talent and impact.From his early breakthrough with hit singles like \"Do or Die\" and \"Ik Kom Bij Je\", Jonna Fraser quickly gained recognition, solidifying his position as a prominent figure in Dutch music. Collaborating with both local and international artists, he expanded his reach, bringing his unique sound to a global audience.Album releases such as \"Blessed\" and \"Lion\" underscored Jonna\'s musical innovation and received positive acclaim, reflecting his growth as an artist. Awards and nominations further acknowledged his contributions, highlighting his significance within the Dutch music industry.Beyond musical accolades, Jonna Fraser\'s commitment to addressing social issues through his lyrics set him apart. His songs became a platform for personal reflection and societal commentary, showcasing not only his musical prowess but also his role as a voice for important conversations.Consistent artistic evolution characterized Jonna Fraser\'s career, with a willingness to experiment with new sounds and themes. This adaptability kept his music fresh and relevant, contributing to his enduring popularity.', 'Jonna Fraser has produced several popular tracks that have resonated with audiences in the Netherlands and beyond. Some of his most notable and well-received songs include:- \"Do or Die\" (2015): This track marked a significant breakthrough for Jonna Fraser, gaining attention for its catchy beats and impactful lyrics. It helped establish him as a rising star in the Dutch music scene.-\"Ik Kom Bij Je\" (2016): Another standout single, \"Ik Kom Bij Je,\" contributed to Jonna Fraser\'s growing popularity. Its success was attributed to the seamless blend of Jonna\'s rhythmic flow and soulful melodies.-\"Architecture\" (2017): Featured on his album \"Blessed,\" \"Architecture\" showcased Jonna Fraser\'s versatility with its dynamic production and introspective lyrics. The song resonated with fans for its emotional depth and engaging sound.', '/images/artist/jonna-fraser.png', '/images/artist/jonna-fraser-profile.png', '/images/artist/jonna-fraser-highlights.png', '/images/artist/jonna-fraser-tracks.png', 'jonna-fraser'),
                                                                                                                                                                                  (4, 'Ntjam Rosie', 'Ntjam Rosie is a Cameroonian-Dutch singer-songwriter known for her captivating blend of jazz, soul, and Afrobeat. Born in Cameroon and raised in the Netherlands, Rosie\'s music reflects her multicultural upbringing and influences.', 'Ntjam Rosie, the Cameroonian-Dutch singer-songwriter, has established herself as a prominent figure in the contemporary music scene, captivating audiences with her soulful voice and poetic lyricism. Her debut album, \"At the Back of Beyond,\" introduced listeners to her distinctive sound, marked by lush instrumentation and introspective songwriting. Subsequent releases, such as \"Breaking Cycles,\" further solidified Rosie\'s reputation as a versatile artist capable of evoking a wide range of emotions through her music. Rosie\'s live performances are celebrated for their intimate nature, with her soulful vocals and magnetic stage presence captivating audiences at venues around the globe. Beyond her musical endeavors, Rosie is also known for her activism and advocacy work, using her platform to raise awareness about social and environmental issues.', '\"Live My Life\" (2010): This infectious track from her debut album, \"At the Back of Beyond,\" embodies Rosie\'s uplifting spirit and positive energy.\r\n\"Morning Glow\" (2013): From her album \"Breaking Cycles,\" \"Morning Glow\" is a soulful ballad that showcases Rosie\'s emotive vocals and introspective songwriting.\r\n\"In Need\" (2016): Featured on her album \"Breaking Cycles,\" \"In Need\" is a poignant reflection on the universal desire for love and connection.', '/images/artist/ntjam-rosie.png', '/images/artist/ntjam-rosie-profile.png', '/images/artist/ntjam-rosie-highlights.png', '/images/artist/ntjam-rosie-tracks.png', 'ntjam-rosie'),
                                                                                                                                                                                  (5, 'Gare du Nord', 'Gare du Nord is a Dutch-Belgian jazz and pop band formed in 2001. Comprising musician and producer Ferdi Lancee and vocalist Dorona Alberti, the duo has gained recognition for their eclectic fusion of jazz, pop, and lounge music.', 'Gare du Nord, the Dutch-Belgian jazz and pop band, has garnered acclaim for their distinctive fusion of musical styles, combining elements of jazz, pop, and lounge music into a stylish and sophisticated sound. Formed in 2001 by musician and producer Ferdi Lancee and vocalist Dorona Alberti, Gare du Nord quickly gained recognition for their sultry vocals, smooth grooves, and evocative arrangements. Subsequent releases, such as \"Kind of Cool\" and \"Sex \'n\' Jazz,\" further solidified Gare du Nord\'s reputation as innovators in the realm of jazz-pop fusion. Gare du Nord\'s live performances are celebrated for their energy and charisma, with Lancee\'s dynamic instrumentals complementing Alberti\'s sultry vocals to create an electrifying stage presence. Beyond their musical endeavors, Gare du Nord is also known for their visual aesthetic, incorporating elements of film noir and vintage glamour into their album artwork and music videos.', '\"Pablo\'s Blues\" (2002): This atmospheric track from their debut album, \"Club Gare du Nord,\" is characterized by its moody instrumentation and sultry vocals.\r\n\"You\'re My Medicine\" (2007): From their album \"Sex \'n\' Jazz,\" \"You\'re My Medicine\" is a seductive blend of jazz and electronic music, featuring infectious beats and hypnotic melodies.\r\n\"Marvin & Miles\" (2011): This homage to jazz legends Marvin Gaye and Miles Davis showcases Gare du Nord\'s ability to pay tribute to musical icons while putting their own unique spin on the genre.', '/images/artist/gare-du-nord.png', '/images/artist/gare-du-nord-profile.png', '/images/artist/gare-du-nord-highlights.png', '/images/artist/gare-du-nord-tracks.png', 'gare-du-nord'),
                                                                                                                                                                                  (6, 'Han Bennink', 'Han Bennink is a Dutch jazz drummer and percussionist known for his innovative approach to rhythm and improvisation. A central figure in the European free jazz scene, Bennink has collaborated with numerous renowned musicians, including saxophonist Peter Brötzmann and pianist Misha Mengelberg.', 'Han Bennink, the pioneering Dutch jazz drummer and percussionist, has made significant contributions to the evolution of contemporary jazz with his innovative approach to rhythm and improvisation. A central figure in the European free jazz scene, Bennink\'s career spans several decades and includes collaborations with some of the most influential musicians in the genre. His work with saxophonist Peter Brötzmann and pianist Misha Mengelberg, among others, has helped shape the landscape of modern jazz, earning him a reputation as a visionary artist. Bennink\'s playing style is characterized by its dynamism, energy, and boundless creativity. His ability to seamlessly blend diverse musical influences – from traditional jazz and blues to avant-garde and experimental – sets him apart as a truly innovative force in the world of percussion. In addition to his prowess as a performer, Bennink is also an accomplished composer, with a catalog of original compositions that showcase his compositional skill and artistic vision. Throughout his career, Bennink has remained dedicated to pushing the boundaries of jazz music, exploring new sonic territories, and challenging conventional notions of rhythm and form.', '\"Machine Gun\" (1968): Recorded with saxophonist Peter Brötzmann as part of the influential album \"Machine Gun,\" this track is a prime example of Bennink\'s dynamic and energetic playing style.\r\n\"Change of Season\" (1984): From his album \"Nerve Beats,\" \"Change of Season\" showcases Bennink\'s versatility as a composer and performer.\r\n\"I Surrender Dear\" (1995): Recorded with pianist Misha Mengelberg and saxophonist Piet Noordijk, this rendition of the classic jazz standard demonstrates Bennink\'s ability to navigate traditional song forms while infusing them with his own unique voice.', '/images/artist/han-bennink.png', '/images/artist/han-bennink-profile.png', '/images/artist/han-bennink-highlights.png', '/images/artist/han-bennink-tracks.png', 'han-bennink'),
                                                                                                                                                                                  (7, 'Gumbo Kings', 'The Gumbo Kings is a New Orleans-style jazz band based in the United States. Formed in the 1990s, the band draws inspiration from the rich musical traditions of Louisiana, blending elements of jazz, blues, zydeco, and funk into a dynamic and infectious sound. Led by bandleader and trumpeter Marcus Dupree, the Gumbo Kings are known for their high-energy performances and virtuosic musicianship.', 'The Gumbo Kings, a New Orleans-style jazz band based in the United States, are renowned for their vibrant and dynamic performances that pay homage to the rich musical traditions of Louisiana. Formed in the 1990s, the band draws inspiration from a diverse array of influences, including jazz, blues, zydeco, and funk. Led by bandleader and trumpeter Marcus Dupree, the Gumbo Kings have earned acclaim for their virtuosic musicianship and infectious energy, captivating audiences with their spirited renditions of jazz standards and original compositions. At the heart of the Gumbo Kings\' sound is a deep reverence for the cultural heritage of New Orleans, reflected in their authentic interpretations of traditional jazz and blues tunes. In addition to their live performances, the Gumbo Kings have released several albums showcasing their unique blend of musical styles. With their infectious grooves and soulful melodies, the Gumbo Kings continue to delight audiences around the world, spreading the joy of New Orleans jazz wherever they go.', '\"Mardi Gras Mambo\" (1995): A lively and infectious tune that captures the festive spirit of Mardi Gras in New Orleans.\r\n\"Bayou Boogie\" (2002): This upbeat number showcases the Gumbo Kings\' signature blend of jazz, blues, and zydeco.\r\n\"Second Line Strut\" (2010): Inspired by the traditional New Orleans second line parade, this lively tune features jubilant brass fanfares and rollicking rhythms.', '/images/artist/gumbo-kings.png', '/images/artist/gumbo-kings-profile.png', '/images/artist/gumbo-kings-highlights.png', '/images/artist/gumbo-kings-tracks.png', 'gumbo-kings'),
                                                                                                                                                                                  (8, 'Uncle Sue', 'Uncle Sue is an American jazz pianist and composer known for his inventive approach to improvisation and composition. Born and raised in New Orleans, Uncle Sue\'s music reflects the vibrant cultural heritage of his hometown, blending elements of jazz, blues, and gospel into a unique and soulful sound.', 'Uncle Sue, the American jazz pianist and composer, is celebrated for his innovative approach to improvisation and composition, drawing inspiration from the rich musical traditions of his hometown, New Orleans. Born and raised in the birthplace of jazz, Uncle Sue\'s music reflects the diverse cultural influences that have shaped his identity as an artist. A consummate performer, Uncle Sue is known for his dynamic and expressive playing style, characterized by intricate harmonies, virtuosic technique, and a deep emotional resonance. In addition to his work as a performer, Uncle Sue is also an accomplished composer, with a catalog of original compositions that showcase his diverse musical influences and artistic vision. Throughout his career, Uncle Sue has remained dedicated to pushing the boundaries of jazz music and exploring new avenues of artistic expression.', '\"Crescent City Blues\" (1998): A heartfelt ballad that pays homage to Uncle Sue\'s hometown of New Orleans. Featuring soulful piano melodies and emotive vocals.\r\n\"Bayou Boogie\" (2005): An upbeat and infectious tune that showcases Uncle Sue\'s virtuosic piano playing and dynamic ensemble arrangements.\r\n\"Spiritual Suite\" (2012): A sprawling composition that explores themes of spirituality and transcendence.', '/images/artist/uncle-sue.png', '/images/artist/uncle-sue-profile.png', '/images/artist/uncle-sue-highlights.png', '/images/artist/uncle-sue-tracks.png', 'uncle-sue'),
                                                                                                                                                                                  (9, 'Soul Slx', 'Soul Slx is a British jazz vocalist known for her soulful voice and emotive performances. Born and raised in London, Soul Slx grew up immersed in the city\'s vibrant music scene, drawing inspiration from jazz, soul, and R&B.', 'Soul Slx, the British jazz vocalist, is celebrated for her soulful voice and emotive performances that showcase her deep connection to the jazz tradition. Born and raised in London, Soul Slx grew up surrounded by the city\'s rich musical heritage, drawing inspiration from a diverse array of influences, including jazz, soul, and R&B. Her performances are marked by their intimacy and emotional depth, with her soulful interpretations of jazz standards and original compositions resonating with audiences around the world. In addition to her work as a performer, Soul Slx is also an accomplished songwriter, with a catalog of original compositions that showcase her lyrical prowess and musical versatility.', '\"Soulful Serenade\" (2010): A heartfelt ballad that showcases Soul Slx\'s rich vocal tone and emotive delivery.\r\n\"Midnight Blues\" (2015): A sultry and seductive tune that highlights Soul Slx\'s versatility as a vocalist.\r\n\"Rhythm of the City\" (2018): An upbeat and infectious number that showcases Soul Slx\'s dynamic range and expressive vocal style.', '/images/artist/soul-slx.png', '/images/artist/soul-slx-profile.png', '/images/artist/soul-slx-highlights.png', '/images/artist/soul-slx-tracks.png', 'soul-slx'),
                                                                                                                                                                                  (10, 'Sjaak ', 'Sjaak is a Dutch rapper and hip-hop artist known for his energetic flow and witty lyrics. Born in Amsterdam, Sjaak rose to prominence in the Dutch music scene with his distinctive blend of streetwise swagger and playful humor.', 'Sjaak, the Dutch rapper and hip-hop artist, has made a significant impact on the Dutch music scene with his energetic flow and witty lyricism. Born and raised in Amsterdam, Sjaak rose to prominence with his distinctive blend of streetwise swagger and playful humor. His career has been marked by a string of successful albums and hit singles, including collaborations with some of the biggest names in Dutch hip-hop. In addition to his work as a recording artist, Sjaak is also known for his dynamic live performances, which are characterized by their high energy and crowd interaction. Beyond his musical endeavors, Sjaak is also active in the community, using his platform to raise awareness about social issues and give back to his hometown of Amsterdam.', '\"Wat Is Er?\" (2010): A hard-hitting track that showcases Sjaak\'s rapid-fire flow and clever wordplay.\r\n\"Maak Money\" (2013): Another standout single, \"Maak Money\" is a swaggering anthem that celebrates the hustle and grind of street life.\r\n\"Gooi Het Omhoog\" (2017): Featuring fellow Dutch rapper Jebroer, this high-energy track is a party anthem that encourages listeners to let loose and have a good time.', '/images/artist/sjaak.png', '/images/artist/sjaak-profile.png', '/images/artist/sjaak-highlights.png', '/images/artist/sjaak-tracks.png', 'sjaak'),
                                                                                                                                                                                  (11, 'The Nordanians', 'The Nordanians is a Dutch jazz ensemble known for their adventurous approach to improvisation and composition. Formed in the early 2000s, the band draws inspiration from a diverse array of musical styles, including jazz, rock, and world music.', 'The Nordanians, a Dutch jazz ensemble, are celebrated for their adventurous approach to improvisation and composition, drawing inspiration from a diverse array of musical styles. Led by saxophonist Oene van Geel and guitarist Mark Tuinstra, the Nordanians create a dynamic and genre-defying sound that blurs the lines between jazz, rock, and world music. Their repertoire features a mix of original compositions and reimagined classics, showcasing their versatility and creative vision. In addition to their work as performers, the Nordanians are also dedicated educators, sharing their knowledge and passion for music with students of all ages.', '\"Northern Lights\" (2005): An atmospheric composition that evokes the beauty and mystery of the Arctic landscape.\r\n\"Desert Song\" (2010): Inspired by the vast expanses of the desert, this evocative piece combines elements of jazz, rock, and world music to create a mesmerizing sonic tapestry.\r\n\"Urban Jungle\" (2015): A dynamic and energetic composition that reflects the chaos and excitement of city life.', '/images/artist/the-nordanians.png', '/images/artist/the-nordanians-profile.png', '/images/artist/the-nordanians-highlights.png', '/images/artist/the-nordanians-tracks.png', 'the-nordanians'),
                                                                                                                                                                                  (12, 'Rilan & The Bombardiers', 'Rilan & The Bombardiers is a Dutch band known for their eclectic blend of jazz, funk, and soul. Fronted by lead vocalist Rilan Ramhane, the band has gained recognition for their dynamic performances and infectious energy.', 'Rilan & The Bombardiers, a Dutch band led by vocalist Rilan Ramhane, draws inspiration from a diverse array of musical influences, including classic jazz, vintage funk, and contemporary soul. Known for their electrifying live performances and infectious energy, they have gained recognition for their versatile repertoire, which features original compositions and reimagined classics. Beyond their musical endeavors, Rilan & The Bombardiers are committed advocates for social justice and equality, using their platform to raise awareness about important issues and promote positive change.', '\"Electric Love\" (2014): A funky and infectious tune that showcases Rilan & The Bombardiers\' dynamic sound and energetic stage presence.\r\n\"Soul Train\" (2017): Inspired by the classic TV show of the same name, \"Soul Train\" is a high-energy funk jam that pays homage to the golden age of soul music.\r\n\"Revolution\" (2020): A powerful anthem for social change, \"Revolution\" showcases Rilan & The Bombardiers\' commitment to using their music as a force for positive change.', '/images/artist/rilan-and-the-bombardiers.png', '/images/artist/rilan-and-the-bombardiers-profile.png', '/images/artist/rilan-and-the-bombardiers-highlights.png', '/images/artist/rilan-and-the-bombardiers-tracks.png', 'rilan-and-the-bombardiers');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Events`
--

CREATE TABLE `Events` (
                          `eventId` int(11) NOT NULL,
                          `date` datetime DEFAULT current_timestamp(),
                          `historyEventId` int(11) DEFAULT NULL,
                          `restaurantEventId` int(11) DEFAULT NULL,
                          `artistEventId` int(11) DEFAULT NULL,
                          `userId` int(11) NOT NULL,
                          `paymentId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Events`
--

INSERT INTO `Events` (`eventId`, `date`, `historyEventId`, `restaurantEventId`, `artistEventId`, `userId`, `paymentId`) VALUES
                                                                                                                            (75, '2024-03-21 13:44:34', NULL, 116, NULL, 2, 85),
                                                                                                                            (76, '2024-03-21 13:44:45', NULL, 117, NULL, 2, 85),
                                                                                                                            (77, '2024-03-21 13:53:11', NULL, 118, NULL, 2, 86),
                                                                                                                            (78, '2024-03-21 13:53:19', NULL, 119, NULL, 2, 87),
                                                                                                                            (79, '2024-03-21 13:53:28', NULL, 120, NULL, 2, 87),
                                                                                                                            (89, '2024-03-27 13:54:29', NULL, 126, NULL, 5, 102),
                                                                                                                            (90, '2024-03-27 14:01:55', 5, NULL, NULL, 5, 103),
                                                                                                                            (91, '2024-03-27 14:02:03', NULL, 127, NULL, 5, 103),
                                                                                                                            (103, '2024-03-27 19:28:39', NULL, NULL, 3, 4, NULL),
                                                                                                                            (104, '2024-03-31 14:50:35', NULL, NULL, 3, 1, NULL),
                                                                                                                            (105, '2024-03-31 14:50:35', NULL, NULL, 4, 1, NULL),
                                                                                                                            (106, '2024-03-31 14:50:35', NULL, NULL, 7, 1, NULL),
                                                                                                                            (107, '2024-03-31 14:57:07', NULL, NULL, 2, 1, NULL),
                                                                                                                            (108, '2024-03-31 14:57:07', NULL, NULL, 3, 1, NULL),
                                                                                                                            (109, '2024-04-06 13:04:18', NULL, NULL, 2, 1, NULL),
                                                                                                                            (110, '2024-04-06 13:04:42', NULL, NULL, 2, 1, NULL),
                                                                                                                            (111, '2024-04-06 13:12:42', NULL, NULL, 2, 1, NULL),
                                                                                                                            (112, '2024-04-07 11:31:33', NULL, NULL, 2, 1, NULL),
                                                                                                                            (113, '2024-04-07 11:32:06', NULL, NULL, 3, 1, NULL),
                                                                                                                            (114, '2024-04-07 11:32:06', NULL, NULL, 6, 1, NULL),
                                                                                                                            (115, '2024-04-07 11:32:06', NULL, NULL, 8, 1, NULL),
                                                                                                                            (116, '2024-04-07 11:32:06', NULL, NULL, 11, 1, NULL),
                                                                                                                            (117, '2024-04-07 11:32:06', NULL, NULL, 12, 1, NULL),
                                                                                                                            (118, '2024-04-07 14:15:48', 6, NULL, NULL, 3, 105),
                                                                                                                            (119, '2024-04-07 14:28:36', NULL, NULL, 5, 3, 109),
                                                                                                                            (120, '2024-04-07 14:52:24', 7, NULL, NULL, 3, 109),
                                                                                                                            (121, '2024-04-07 14:52:34', NULL, 128, NULL, 3, 109),
                                                                                                                            (122, '2024-04-07 14:52:52', 8, NULL, NULL, 3, 109),
                                                                                                                            (123, '2024-04-07 14:53:03', NULL, 129, NULL, 3, 109),
                                                                                                                            (124, '2024-04-07 14:53:16', NULL, NULL, 4, 3, 109),
                                                                                                                            (125, '2024-04-07 15:25:53', NULL, NULL, 6, 3, 110);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `HistoryEvent`
--

CREATE TABLE `HistoryEvent` (
                                `historyEventId` int(11) NOT NULL,
                                `historyTourId` int(11) NOT NULL,
                                `participants` int(11) NOT NULL,
                                `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `HistoryEvent`
--

INSERT INTO `HistoryEvent` (`historyEventId`, `historyTourId`, `participants`, `userId`) VALUES
                                                                                             (1, 1, 1, 1),
                                                                                             (3, 1, 2, NULL),
                                                                                             (4, 1, 1, NULL),
                                                                                             (5, 7, 1, NULL),
                                                                                             (6, 5, 1, NULL),
                                                                                             (7, 5, 5, NULL),
                                                                                             (8, 1, 2, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `HistoryLocation`
--

CREATE TABLE `HistoryLocation` (
                                   `historyLocationId` int(11) NOT NULL,
                                   `name` varchar(255) NOT NULL,
                                   `imagePath` varchar(255) NOT NULL,
                                   `aboutImagePath` varchar(255) DEFAULT NULL,
                                   `historyImagePath` varchar(255) DEFAULT NULL,
                                   `about` text DEFAULT NULL,
                                   `history` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `HistoryLocation`
--

INSERT INTO `HistoryLocation` (`historyLocationId`, `name`, `imagePath`, `aboutImagePath`, `historyImagePath`, `about`, `history`) VALUES
                                                                                                                                       (1, 'Church of St. Bavo', '/app/controllers/../public/images/historyLocations/65e103bcd32cd2.30286455.png', '/app/controllers/../public/images/historyLocations/65ee15d8a86165.48737215.png', '/app/controllers/../public/images/historyLocations/65ee15d8ac6143.72585880.png', 'From far outside the city of Haarlem, the Great or St. Bavo Church is already visible. The wooden tower, covered with lead, is 78 meters high. This medieval Gothic cross church is one of the largest churches in the Netherlands.<br><br>\r\nUnique in the interior are the beautiful wooden vault, the famous Müller organ, the copper choir screen, the many stained glass windows and the 400 tombstones on the floor, including those of Frans Hals and Willem Bilderdijk.', 'The current church has had several predecessors, including both wooden and stone parish churches. In 1370, the last predecessor, a parish church built in the Romanesque style, was heavily damaged by a fire. This church was then largely restored. Additionally, a new Gothic choir was built. This choir, completed around 1400, still stands today.<br><br>\r\n\r\nThe church was originally built as a Catholic church. In 1559, the church became the cathedral of the newly established diocese of Haarlem until the church definitively became a Protestant place of worship in 1578.'),
                                                                                                                                       (2, 'Grote Markt', '/app/controllers/../public/images/historyLocations/65e208bf84f994.11658214.png', '', '', NULL, NULL),
                                                                                                                                       (3, 'De Hallen', '/app/controllers/../public/images/historyLocations/65e208e69a6b36.22096318.png', '', '', NULL, NULL),
                                                                                                                                       (4, 'Proveniershof', '/app/controllers/../public/images/historyLocations/65e208f3e99c13.54933381.png', '', '', NULL, NULL),
                                                                                                                                       (5, 'Jopenkerk', '/app/controllers/../public/images/historyLocations/65e208ff748260.81859865.png', '', '', NULL, NULL),
                                                                                                                                       (6, 'Waalse Kerk', '/app/controllers/../public/images/historyLocations/65e2090c66fcd9.86436418.png', '', '', NULL, NULL),
                                                                                                                                       (7, 'Molen de Adriaan', '/app/controllers/../public/images/historyLocations/65e209173203c7.36938685.png', '', '', NULL, NULL),
                                                                                                                                       (8, 'Amsterdamse Poort', '/app/controllers/../public/images/historyLocations/65e2092a89ab37.27433938.png', '/app/controllers/../public/images/historyLocations/65ee16c09daa77.73115645.png', '/app/controllers/../public/images/historyLocations/65ee16c0a16891.28493720.png', 'The Amsterdamse Poort, or ”Amsterdam Gate”, is a historic landmark located in the city of Haarlem. Built in the 14th century, the Amsterdamse Poort is the only remaining city gate from Haarlem\'s medieval city walls.<br><br>\r\n\r\nThe Amsterdamse Poort was once a vital part of the city\'s defenses, serving as the main entrance for travellers coming from and going to Amsterdam.', 'The Amsterdamse Poort, built in 1355, is the only one of the 12 city gates that still stands. It was constructed during the first expansion of the city when a part of it was drawn within the walls along the Spaarne River.<br><br>\r\n\r\nIn 1865, the city council planned to demolish the medieval gate to make way for a new bridge. The gate was in poor condition and obstructed the construction of the new bridge. However, due to a lack of funds at the time, the council decided to only renovate the essential parts, allowing the gate to remain standing for another 2 or 3 years.<br><br>\r\n\r\nA few years, when the Papen Tower was demolished, the ammunition stored there had to be relocated. The Amsterdamse Poort proved to have suitable space, and as a result, it was allowed to remain standing.<br><br>\r\n\r\nIn 1874, the explosive ammunition was removed from the city. Just over a century later, in 1985, the Amsterdamse Poort underwent a well-deserved renovation.'),
                                                                                                                                       (9, 'Hof van Bakenes', '/app/controllers/../public/images/historyLocations/65e2093676bf22.56764495.png', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `HistoryTour`
--

CREATE TABLE `HistoryTour` (
                               `historyTourId` int(11) NOT NULL,
                               `tourStartTime` datetime NOT NULL,
                               `tourEndTime` datetime DEFAULT NULL,
                               `languageId` int(11) NOT NULL,
                               `maxParticipants` int(11) NOT NULL,
                               `price` decimal(10,2) NOT NULL,
                               `tourGuide` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `HistoryTour`
--

INSERT INTO `HistoryTour` (`historyTourId`, `tourStartTime`, `tourEndTime`, `languageId`, `maxParticipants`, `price`, `tourGuide`) VALUES
                                                                                                                                       (1, '2024-07-28 10:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (4, '2024-07-28 13:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (5, '2024-07-28 16:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (6, '2024-07-29 10:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Annet'),
                                                                                                                                       (7, '2024-07-29 13:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Annet'),
                                                                                                                                       (8, '2024-07-29 16:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Annet'),
                                                                                                                                       (9, '2024-07-30 10:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (10, '2024-07-30 13:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (11, '2024-07-30 16:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Annet'),
                                                                                                                                       (12, '2024-07-31 10:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Annet'),
                                                                                                                                       (13, '2024-07-31 13:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Jan-Willem'),
                                                                                                                                       (14, '2024-07-31 16:00:00', '0000-00-00 00:00:00', 1, 12, 17.50, 'Lisa'),
                                                                                                                                       (15, '2024-07-28 10:00:00', '0000-00-00 00:00:00', 2, 12, 17.50, 'Frederic'),
                                                                                                                                       (16, '2024-07-28 13:00:00', '0000-00-00 00:00:00', 2, 12, 17.50, 'Frederic'),
                                                                                                                                       (17, '2024-07-28 16:00:00', '0000-00-00 00:00:00', 2, 12, 17.50, 'Frederic'),
                                                                                                                                       (19, '2024-07-29 13:00:00', '0000-00-00 00:00:00', 3, 12, 17.50, 'Kim'),
                                                                                                                                       (25, '2024-07-29 10:00:00', NULL, 2, 12, 17.50, 'Williams'),
                                                                                                                                       (26, '2024-07-29 13:00:00', NULL, 2, 12, 17.50, 'Williams'),
                                                                                                                                       (27, '2024-07-29 16:00:00', NULL, 2, 12, 17.50, 'Williams'),
                                                                                                                                       (28, '2024-07-30 10:00:00', NULL, 2, 12, 17.50, 'William'),
                                                                                                                                       (29, '2024-07-30 13:00:00', NULL, 2, 12, 17.50, 'William'),
                                                                                                                                       (30, '2024-07-30 16:00:00', NULL, 2, 12, 17.50, 'Frederic'),
                                                                                                                                       (31, '2024-07-31 10:00:00', NULL, 2, 12, 17.50, 'Frederic'),
                                                                                                                                       (32, '2024-07-31 13:00:00', NULL, 2, 12, 17.50, 'William'),
                                                                                                                                       (33, '2024-07-31 16:00:00', NULL, 2, 12, 17.50, 'Deirdre'),
                                                                                                                                       (34, '2024-07-30 13:00:00', NULL, 3, 12, 17.50, 'Kim'),
                                                                                                                                       (35, '2024-07-30 16:00:00', NULL, 3, 12, 17.50, 'Kim'),
                                                                                                                                       (36, '2024-07-31 10:00:00', NULL, 3, 12, 17.50, 'Kim'),
                                                                                                                                       (37, '2024-07-31 13:00:00', NULL, 3, 12, 17.50, 'Susan');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Language`
--

CREATE TABLE `Language` (
                            `languageId` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Language`
--

INSERT INTO `Language` (`languageId`, `name`) VALUES
                                                  (1, 'Dutch'),
                                                  (2, 'English'),
                                                  (3, 'Chinese');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `MusicStyles`
--

CREATE TABLE `MusicStyles` (
                               `musicStyleId` int(11) NOT NULL,
                               `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `MusicStyles`
--

INSERT INTO `MusicStyles` (`musicStyleId`, `name`) VALUES
                                                       (1, 'Jazz'),
                                                       (2, 'Soul'),
                                                       (3, 'Rap'),
                                                       (4, 'Funk'),
                                                       (5, 'Pop');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Orders`
--

CREATE TABLE `Orders` (
                          `orderId` int(11) NOT NULL,
                          `paymentId` int(11) NOT NULL,
                          `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Orders`
--

INSERT INTO `Orders` (`orderId`, `paymentId`, `date`) VALUES
                                                          (13, 85, '2024-03-21 13:47:45'),
                                                          (14, 86, '2024-03-21 13:47:45'),
                                                          (15, 87, '2024-03-21 13:54:28'),
                                                          (16, 102, '2024-03-27 14:01:06'),
                                                          (17, 103, '2024-03-27 14:03:34'),
                                                          (18, 105, '2024-04-07 14:16:06'),
                                                          (19, 109, '2024-04-07 15:05:42'),
                                                          (20, 110, '2024-04-07 15:26:13');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Payments`
--

CREATE TABLE `Payments` (
                            `paymentId` int(11) NOT NULL,
                            `session` varchar(999) NOT NULL,
                            `paymentStatusId` int(11) NOT NULL,
                            `totalPrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Payments`
--

INSERT INTO `Payments` (`paymentId`, `session`, `paymentStatusId`, `totalPrice`) VALUES
                                                                                     (85, 'cs_test_b1EDuyr7DqfooRw1oF8sLvsxpHVEk0lFg0T6cfzon6kWe68gxKIEO1nHZC', 1, 0),
                                                                                     (86, 'cs_test_b10nJglf2H9JWo6q9g6wua1ANjjP1R6cL93gUcogdql5rQt5bVI5aZGj6G', 2, 0),
                                                                                     (87, 'cs_test_b1AfPeYcNbNtkqCp6OW02ZZoGQKoRBVg9lSVEZYZTTFXppGxLMCA1jmYgj', 1, 0),
                                                                                     (89, 'cs_test_a1P32O88BhJESrkUiqlFEOQHDMV6upUDkeIprcHrYOaAWIHWB8cc76IroP', 2, 10),
                                                                                     (90, 'cs_test_a1eoHzOC7E0e4uSEpACmtc7dPmEAxBdMAZCd0brasvfjpVcgrvAnDkv8Tc', 2, 30),
                                                                                     (91, 'cs_test_a1wBv2qg30cHf4i9ZT0ZinsfYsWwzBayWmVgxaCBTkODZiipt4DdIYuaVg', 2, 10),
                                                                                     (92, 'cs_test_a1NN6fYGJCgr6k2LKAcLPHtUqqn7hJYQX1VahzetfLqTBfETcsnuJQ2xgZ', 2, 17.5),
                                                                                     (93, 'cs_test_b1c7h7yyxuyeLNOG4k0iaGzj0YRUBKcxEJjUSqonM62mA8dVLAgTAhwrZO', 2, 27.5),
                                                                                     (102, 'cs_test_a1eN85lj4YOv4ylP4oXssbWXMoqbB4KdjktSHttvamXXgKVNTTl09wH63s', 1, 20),
                                                                                     (103, 'cs_test_b18NYExlj2Y4ZQ8AXihxJ69bCF2b84Up10ap5Wf1FlA8sE8F972Csg9tku', 1, 57.5),
                                                                                     (104, 'cs_test_b1sm7WCrJ2F30vf9XJsKsEI1OmH2W5ht0JN0UCIxPMzOqv0V6xf2GvKPvu', 2, 70),
                                                                                     (105, 'cs_test_a1dErMVA2zKzc64RHtL18yYcN6vM2XZ2WpB94aDonBrgOFopX8uh6YCe6N', 1, 17.5),
                                                                                     (106, 'cs_test_a123GprwmSYt9hToOOBQ7sXB6lNExkkapdqZtVvEOx0e4dmrxmxqjKxaro', 2, 15),
                                                                                     (107, 'cs_test_a17GQP1wX0DjAgepaEaOcVkSBoCvLVVRNgLVRQuJGbvxhmy5sP6A3CxP6L', 2, 30),
                                                                                     (108, 'cs_test_b1bAEkQi3f85mir1cG2XuNTfFmhDaKGFttrpNVYJ1N0roxDy8t9MRtLW5q', 2, 232.5),
                                                                                     (109, 'cs_test_b1icA9EUVWCpFctIltioLqQ9LaYCpVYB5TYYMhytZgwyxoVyRztkQAet1y', 1, 272.5),
                                                                                     (110, 'cs_test_a1JsV54erGvj9B1V32yviKhT0s7Y2dfA5OSntaq1UPeXP81tje8cGkxiR2', 1, 40);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `PaymentStatus`
--

CREATE TABLE `PaymentStatus` (
                                 `paymentStatusId` int(11) NOT NULL,
                                 `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `PaymentStatus`
--

INSERT INTO `PaymentStatus` (`paymentStatusId`, `name`) VALUES
                                                            (1, 'Completed'),
                                                            (2, 'Pending'),
                                                            (3, 'Failed'),
                                                            (4, 'Refunded'),
                                                            (5, 'Cancelled');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ReservationDay`
--

CREATE TABLE `ReservationDay` (
                                  `reservationDayId` int(11) NOT NULL,
                                  `day` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ReservationDay`
--

INSERT INTO `ReservationDay` (`reservationDayId`, `day`) VALUES
                                                             (1, 'Thursday'),
                                                             (2, 'Friday'),
                                                             (3, 'Saturday'),
                                                             (4, 'Sunday');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Restaurant`
--

CREATE TABLE `Restaurant` (
                              `restaurantId` int(11) NOT NULL,
                              `specialityId` int(11) DEFAULT NULL,
                              `name` varchar(255) NOT NULL,
                              `description` text DEFAULT NULL,
                              `image` varchar(255) DEFAULT NULL,
                              `location` varchar(255) DEFAULT NULL,
                              `price` double DEFAULT NULL,
                              `places` int(11) DEFAULT NULL,
                              `rating` double DEFAULT NULL,
                              `number` varchar(20) NOT NULL,
                              `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Restaurant`
--

INSERT INTO `Restaurant` (`restaurantId`, `specialityId`, `name`, `description`, `image`, `location`, `price`, `places`, `rating`, `number`, `email`) VALUES
                                                                                                                                                          (1, 1, 'Tatsu', 'Japans cuisine', 'tatsu.png', 'Oude Groenmarkt 14-16, 2011 HL Haarlem', 45, 60, 4, '06 25145236', 'tatsu@gmail.com'),
                                                                                                                                                          (2, 3, 'Ratatouille', 'French cuisine', 'ratatouille.png', 'Spaarne 96, 2011 CL Haarlem', 45, 52, 4, '06 51478965', 'ratatouille@gmail.com'),
                                                                                                                                                          (3, 2, 'Restaurant ML', 'Dutch', 'restaurantml.png', 'Kleine Houtstraat 70, 2011 DR Haarlem', 45, 60, 4, '06 38412579', 'restaurantml@gmail.com'),
                                                                                                                                                          (4, 4, 'Specktakel', 'European', 'specktakel.png', 'Spekstraat 4, 2011 HM Haarlem', 35, 36, 3, '06 38251425', 'specktakel@gmail.com'),
                                                                                                                                                          (5, 2, 'Restaurant Fris', 'Dutch', 'restaurantfris.png', 'Twijnderslaan 7, 2012 BG Haarlem', 45, 45, 4, '06 32635698', 'restaurantfris@gmail.com'),
                                                                                                                                                          (6, 1, 'Delfino', 'Pizza', 'tatsu5.png', 'Amsterdam', 50, 50, 5, '0635263524', 'delfino@gmail.com'),
                                                                                                                                                          (8, 1, 'Burger Kingg', 'adssd', 'tatsu5.png', 'adsasd', 32, 23, 3, '06 23652635', 'delfino@gmail.com');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `RestaurantDetailPage`
--

CREATE TABLE `RestaurantDetailPage` (
                                        `restaurantDetailPageId` int(11) NOT NULL,
                                        `restaurantId` int(11) NOT NULL,
                                        `titleDescription` varchar(900) NOT NULL,
                                        `description` text NOT NULL,
                                        `reservationText` text NOT NULL,
                                        `imageDetail1` varchar(255) NOT NULL,
                                        `imageDetail2` varchar(255) NOT NULL,
                                        `imageDetail3` varchar(255) NOT NULL,
                                        `imageDetail4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `RestaurantDetailPage`
--

INSERT INTO `RestaurantDetailPage` (`restaurantDetailPageId`, `restaurantId`, `titleDescription`, `description`, `reservationText`, `imageDetail1`, `imageDetail2`, `imageDetail3`, `imageDetail4`) VALUES
                                                                                                                                                                                                        (1, 1, 'Explore modern Japanese cuisine at Tatsu Haarlem and Leidschendam! Enjoy upgraded all-you-can-eat options, including popular dishes like nigiri and maki, as well as new favorites. Visit our vibrant locations for a delightful Japanese dining experience with cocktails and sushi, Made by multiple talented chefs', 'Explore Tatsu Haarlem in the historic Oude Groenmarkt, offering an alluring setting for all-you-can-eat lunch or dinner experiences seven days a week. Our renovated restaurant presents a diverse menu of sushi and modern Japanese dishes, satisfying every palate with fresh sashimi, flavorful rolls, and more.\r\n\r\nEnjoy our relaxed and friendly service during lunch and dinner. Immerse yourself in a culinary journey where traditional and contemporary flavors seamlessly blend. We look forward to welcoming you to Tatsu Haarlem for a memorable dining experience!', 'Discover the culinary refinement of Tatsu Haarlem. Let yourself be surprised by our delicious dishes and enjoy an unforgettable experience.', 'tatsu1.png', 'tatsu2.png', 'tatsu3.png', 'tatsu4.png'),
                                                                                                                                                                                                        (2, 2, 'Taste Chef Jozua Jaring\'s mix of old French cooking and new styles. Our restaurant started in Haarlem in 2013, then moved to the Spaarne River in 2015. We make really good food that won a Michelin award and doesn’t cost a lot. Come enjoy great flavors and a nice place. Welcome to a special food adventure!', 'Chef Jozua Jaring\'s Michelin-starred restaurant in Haarlem combines French cuisine with a modern twist. Established in 2013 on Lange Veerstraat and now thriving along the Spaarne River since 2015, we offer great value in a friendly setting. Join us for lunch or dinner to explore Chef Jaring\'s culinary world, with options for private dining and weddings. Whether you discovered us in Lange Veerstraat or our current Spaarne location, savor the delicious creations of Chef Jozua Jaring and his team.', 'Treat yourself to the culinary excellence of Ratatouille. Immerse yourself in a world of flavor and sophistication with our renowned dishes. Secure your table now to embark on a gastronomic adventure you won\'t soon forget.', 'ratatouille1.png', 'ratatouille2.png', 'ratatouille3.png', 'ratatouille4.png'),
                                                                                                                                                                                                        (3, 3, 'Discover the charm of Restaurant ML in Haarlem. Since its inception in 2013, we\'ve been delighting diners with a harmonious blend of Dutch culinary heritage and modern influences. Situated along the tranquil Spaarne River since 2015, our establishment has earned acclaim, including a coveted Michelin award, all while maintaining affordability. Come and indulge in our exceptional cuisine amidst a cozy and inviting ambiance. Welcome to an unforgettable dining experience at Restaurant ML.', 'Experience culinary excellence at Restaurant ML in Haarlem. With a perfect blend of traditional French cooking and modern flair, our dishes are sure to tantalize your taste buds. Nestled along the serene Spaarne River, our cozy ambiance sets the stage for an unforgettable dining experience. Join us and discover why we\'re a favorite among food enthusiasts and critics alike.', 'Book your table now and treat yourself to an unforgettable dining experience at Restaurant ML. Discover the perfect blend of Dutch culinary tradition and modern innovation in our charming riverside setting.', 'restaurantml1.png', 'restaurantml2.png', 'restaurantml3.png', 'restaurantml4.png'),
                                                                                                                                                                                                        (4, 4, 'Indulge in a culinary spectacle at Restaurant Specktakel in the heart of Haarlem. With a focus on exquisite flavors and innovative dishes, our restaurant offers a dining experience like no other. From the vibrant atmosphere to the tantalizing menu, immerse yourself in a world of gastronomic delight. Join us for an unforgettable journey through the finest cuisine in Haarlem.', 'Dive into a world of culinary delight at Restaurant Specktakel, nestled in the vibrant city of Haarlem. Our restaurant promises a feast for the senses, where every dish is a testament to our passion for exceptional food. From the moment you step through our doors, you\'ll be greeted by an inviting atmosphere and warm hospitality. Indulge in a diverse menu showcasing the finest ingredients, expertly prepared to tantalize your taste buds. Whether you\'re seeking a romantic dinner for two or a lively gathering with friends, Restaurant Specktakel offers an unforgettable dining experience. Join us and embark on a gastronomic journey that celebrates the richness of Dutch cuisine in an elegant yet relaxed setting.', 'Secure your table now and prepare to be enchanted by the culinary magic of Restaurant Specktakel in Haarlem. Experience the perfect blend of flavors and ambiance that promises an unforgettable dining experience.', 'specktakel1.png', 'specktakel2.png', 'specktakel3.png', 'specktakel4.png'),
                                                                                                                                                                                                        (5, 5, 'Discover a culinary haven at Restaurant Fris, located in the heart of Haarlem. With a commitment to quality ingredients and innovative cuisine, our restaurant offers a dining experience that delights the senses. Immerse yourself in an ambiance of sophistication and warmth as you savor every moment of your meal. Join us and experience the essence of culinary excellence at Restaurant Fris.', 'Experience culinary excellence at Restaurant Fris in Haarlem. Indulge in a symphony of flavors crafted with precision and passion. Join us and discover why Restaurant Fris is a cherished destination for food enthusiasts seeking an extraordinary dining experience.', 'Secure your table now and prepare to indulge in the culinary delights of Restaurant Fris. Join us for an exquisite dining experience where every bite is a celebration of flavor and refinement.', 'restaurantfris1.png', 'restaurantfris2.png', 'restaurantfris3.png', 'restaurantfris4.png'),
                                                                                                                                                                                                        (10, 6, 'dffg', 'fdg', 'dgdg', 'specktakel2.png', 'ratatouille1.png', 'ratatouille4.png', 'restaurantfris4.png'),
                                                                                                                                                                                                        (12, 8, 'dsf', 'dfsdf', 'dsfdf', 'restaurantfris4.png', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `RestaurantEvent`
--

CREATE TABLE `RestaurantEvent` (
                                   `restaurantEventId` int(11) NOT NULL,
                                   `restaurantId` int(11) NOT NULL,
                                   `restaurantSessionId` int(11) NOT NULL,
                                   `reservationDayId` int(11) NOT NULL,
                                   `specificRequest` text NOT NULL,
                                   `adults` int(11) NOT NULL,
                                   `children` int(11) NOT NULL,
                                   `status` varchar(255) NOT NULL DEFAULT 'active',
                                   `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `RestaurantEvent`
--

INSERT INTO `RestaurantEvent` (`restaurantEventId`, `restaurantId`, `restaurantSessionId`, `reservationDayId`, `specificRequest`, `adults`, `children`, `status`, `userId`) VALUES
                                                                                                                                                                                (116, 1, 1, 3, '', 2, 2, 'active', 2),
                                                                                                                                                                                (117, 2, 2, 1, '', 2, 0, 'active', 2),
                                                                                                                                                                                (118, 3, 3, 3, '', 2, 0, 'active', 2),
                                                                                                                                                                                (119, 1, 2, 1, '', 2, 0, 'active', 2),
                                                                                                                                                                                (120, 5, 2, 2, '', 2, 0, 'active', 2),
                                                                                                                                                                                (125, 1, 1, 1, '', 1, 0, 'active', 5),
                                                                                                                                                                                (126, 1, 2, 4, '', 2, 0, 'active', 5),
                                                                                                                                                                                (127, 2, 1, 4, 'fd', 2, 2, 'active', 5),
                                                                                                                                                                                (128, 4, 4, 2, '', 4, 2, 'active', 3),
                                                                                                                                                                                (129, 2, 1, 4, '', 1, 1, 'active', 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `RestaurantSessions`
--

CREATE TABLE `RestaurantSessions` (
                                      `restaurantSessionId` int(100) NOT NULL,
                                      `startTime` varchar(255) NOT NULL,
                                      `endTime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `RestaurantSessions`
--

INSERT INTO `RestaurantSessions` (`restaurantSessionId`, `startTime`, `endTime`) VALUES
                                                                                     (1, '16:30', '18:00'),
                                                                                     (2, '18:00', '19:30'),
                                                                                     (3, '19:30', '21:00'),
                                                                                     (4, '21:00', '22:30'),
                                                                                     (5, '22:30', '00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Roles`
--

CREATE TABLE `Roles` (
                         `roleId` int(11) NOT NULL,
                         `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Roles`
--

INSERT INTO `Roles` (`roleId`, `name`) VALUES
                                           (1, 'Customer'),
                                           (2, 'Admin'),
                                           (3, 'Editor');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Songs`
--

CREATE TABLE `Songs` (
                         `songId` int(11) NOT NULL,
                         `artistId` int(11) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `musicPath` varchar(255) NOT NULL,
                         `imageCover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Songs`
--

INSERT INTO `Songs` (`songId`, `artistId`, `name`, `musicPath`, `imageCover`) VALUES
                                                                                  (13, 2, 'Forever Dreaming', 'Music/Jonth - Bass Face [NCS Release].mp3', '/Images/artist/myles-sanko-forever-dreaming.png'),
                                                                                  (14, 2, 'Just Being Me', 'Music/Maze - The Rocks [NCS Release].mp3', '/Images/artist/myles-sanko-just-being-me.png'),
                                                                                  (21, 2, 'satsadf', '/music/song/43b007298e381f7359dba4510d397355.mp3', '/images/song/0850e232c48f5ee9f3af6245d523f829.png'),
                                                                                  (22, 2, 'asdfsad', '/music/song/faff8bf0e8950031129b1e68577410d8.mp3', '/images/song/51e5b1e9665bae19f12de69ee140cdc2.png'),
                                                                                  (23, 2, 'asdfasdfdd', '/music/song/5546e029889292cc8d246b61f50edb06.mp3', '/images/song/00e047e968c40ce24d17018b613c0e9a.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Speciality`
--

CREATE TABLE `Speciality` (
                              `specialityId` int(11) NOT NULL,
                              `name` varchar(255) NOT NULL,
                              `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Speciality`
--

INSERT INTO `Speciality` (`specialityId`, `name`, `flag`) VALUES
                                                              (1, 'Japans', 'images/yummy/japan.png'),
                                                              (2, 'Dutch', 'images/yummy/nederland.png'),
                                                              (3, 'French', 'images/yummy/frankrijk.png'),
                                                              (4, 'European', 'images/yummy/europa.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Tickets`
--

CREATE TABLE `Tickets` (
                           `ticketId` int(11) NOT NULL,
                           `eventId` int(11) NOT NULL,
                           `paymentId` int(11) NOT NULL,
                           `token` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Tickets`
--

INSERT INTO `Tickets` (`ticketId`, `eventId`, `paymentId`, `token`) VALUES
                                                                        (1, 118, 105, '2c5c7f25a3'),
                                                                        (2, 119, 109, '2946522094'),
                                                                        (3, 120, 109, '23bafc8754'),
                                                                        (4, 120, 109, '30d686996e'),
                                                                        (5, 120, 109, '72addc53a1'),
                                                                        (6, 120, 109, 'f57e0b8ab5'),
                                                                        (7, 120, 109, '9fb09b35fc'),
                                                                        (8, 121, 109, '75ef8e9255'),
                                                                        (9, 121, 109, 'd5fc0885bb'),
                                                                        (10, 121, 109, '6ba619b12a'),
                                                                        (11, 121, 109, 'ea79181a65'),
                                                                        (12, 121, 109, 'cad834b428'),
                                                                        (13, 121, 109, 'e650f95324'),
                                                                        (14, 122, 109, 'bed2c23b8e'),
                                                                        (15, 122, 109, 'ba7c2cb4b2'),
                                                                        (16, 123, 109, '4d335cee3e'),
                                                                        (17, 123, 109, '140d0fe014'),
                                                                        (18, 124, 109, '46aab83312'),
                                                                        (19, 125, 110, '6843b8a946'),
                                                                        (20, 125, 110, 'dd95acfb34'),
                                                                        (21, 125, 110, 'b74a5f66ec'),
                                                                        (22, 125, 110, '361faa69d4');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `UserArtistEventTickets`
--

CREATE TABLE `UserArtistEventTickets` (
                                          `id` int(11) NOT NULL,
                                          `userId` int(11) NOT NULL,
                                          `artistEventId` int(11) NOT NULL,
                                          `ticketsPurchased` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `UserArtistEventTickets`
--

INSERT INTO `UserArtistEventTickets` (`id`, `userId`, `artistEventId`, `ticketsPurchased`) VALUES
                                                                                               (1, 1, 2, 2),
                                                                                               (2, 1, 3, 2),
                                                                                               (3, 1, 6, 4),
                                                                                               (4, 1, 8, 1),
                                                                                               (5, 1, 11, 2),
                                                                                               (6, 1, 12, 3),
                                                                                               (7, 3, 5, 4),
                                                                                               (8, 3, 4, 2),
                                                                                               (9, 3, 6, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Users`
--

CREATE TABLE `Users` (
                         `userId` int(11) NOT NULL,
                         `roleId` int(11) NOT NULL,
                         `username` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `firstName` varchar(255) NOT NULL,
                         `lastName` varchar(255) NOT NULL,
                         `phoneNumber` varchar(10) NOT NULL,
                         `postalCode` varchar(8) NOT NULL,
                         `address` varchar(255) NOT NULL,
                         `houseNumber` int(11) NOT NULL,
                         `registrationDate` datetime NOT NULL DEFAULT current_timestamp(),
                         `resetTokenHash` varchar(64) DEFAULT NULL,
                         `resetTokenExpiresAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `Users`
--

INSERT INTO `Users` (`userId`, `roleId`, `username`, `email`, `password`, `firstName`, `lastName`, `phoneNumber`, `postalCode`, `address`, `houseNumber`, `registrationDate`, `resetTokenHash`, `resetTokenExpiresAt`) VALUES
                                                                                                                                                                                                                           (1, 2, 'test', 'kixkgiqxkhcjfiejog@cazlp.com', '$2y$10$r7n0Uz7mimsF1.Kvu2W40OybxYYg7X4YuFj3t9o/XakCpmjA.U6EG', 'test', 'test', '0612345678', '1234ab', 'test', 0, '2024-03-07 14:54:58', NULL, NULL),
                                                                                                                                                                                                                           (2, 2, 'd.kahya', 'duha@gmail.com', '$2y$10$Bq9HiuAvWD2/s3mIHDRvBe7jOUp1s2W/cFdu2rzCCaFpq8EDH2SYu', 'Duha', 'Kahya', '0612345678', '1234ab', 'test', 0, '2024-03-17 12:25:44', NULL, NULL),
                                                                                                                                                                                                                           (3, 1, 'Lucas-Light', 'agnus@ziggo.nl', '$2y$10$qIo.7CC6yJZ8lWUZQxw8c.RY.yxo.s1NLlFoPDEgr8CxPjEJ/v24q', 'Lucas', 'van Vianen', '0612345678', '1234ab', 'test', 0, '2024-03-27 12:37:42', NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `ArtistEventLocations`
--
ALTER TABLE `ArtistEventLocations`
    ADD PRIMARY KEY (`artistEventLocationId`);

--
-- Indexen voor tabel `ArtistEvents`
--
ALTER TABLE `ArtistEvents`
    ADD PRIMARY KEY (`artistEventId`),
    ADD KEY `ArtistId` (`artistId`),
    ADD KEY `FK_ArtistEventLocation` (`artistEventLocationId`);

--
-- Indexen voor tabel `ArtistMusicStyles`
--
ALTER TABLE `ArtistMusicStyles`
    ADD PRIMARY KEY (`artistMusicStyleId`),
    ADD KEY `ArtistId` (`artistId`),
    ADD KEY `MusicStyleId` (`musicStyleId`);

--
-- Indexen voor tabel `Artists`
--
ALTER TABLE `Artists`
    ADD PRIMARY KEY (`artistId`);

--
-- Indexen voor tabel `Events`
--
ALTER TABLE `Events`
    ADD PRIMARY KEY (`eventId`),
    ADD KEY `HistoryEventId` (`historyEventId`),
    ADD KEY `RestaurantEventId` (`restaurantEventId`),
    ADD KEY `ArtistEventId` (`artistEventId`);

--
-- Indexen voor tabel `HistoryEvent`
--
ALTER TABLE `HistoryEvent`
    ADD PRIMARY KEY (`historyEventId`),
    ADD KEY `HistoryTourId` (`historyTourId`) USING BTREE;

--
-- Indexen voor tabel `HistoryLocation`
--
ALTER TABLE `HistoryLocation`
    ADD PRIMARY KEY (`historyLocationId`);

--
-- Indexen voor tabel `HistoryTour`
--
ALTER TABLE `HistoryTour`
    ADD PRIMARY KEY (`historyTourId`),
    ADD KEY `fk_Language` (`languageId`);

--
-- Indexen voor tabel `Language`
--
ALTER TABLE `Language`
    ADD PRIMARY KEY (`languageId`);

--
-- Indexen voor tabel `MusicStyles`
--
ALTER TABLE `MusicStyles`
    ADD PRIMARY KEY (`musicStyleId`);

--
-- Indexen voor tabel `Orders`
--
ALTER TABLE `Orders`
    ADD PRIMARY KEY (`orderId`),
    ADD KEY `fk_order_paymentId` (`paymentId`);

--
-- Indexen voor tabel `Payments`
--
ALTER TABLE `Payments`
    ADD PRIMARY KEY (`paymentId`);

--
-- Indexen voor tabel `PaymentStatus`
--
ALTER TABLE `PaymentStatus`
    ADD PRIMARY KEY (`paymentStatusId`);

--
-- Indexen voor tabel `ReservationDay`
--
ALTER TABLE `ReservationDay`
    ADD PRIMARY KEY (`reservationDayId`);

--
-- Indexen voor tabel `Restaurant`
--
ALTER TABLE `Restaurant`
    ADD PRIMARY KEY (`restaurantId`),
    ADD KEY `SpecialityId` (`specialityId`);

--
-- Indexen voor tabel `RestaurantDetailPage`
--
ALTER TABLE `RestaurantDetailPage`
    ADD PRIMARY KEY (`restaurantDetailPageId`),
    ADD KEY `RestaurantId` (`restaurantId`);

--
-- Indexen voor tabel `RestaurantEvent`
--
ALTER TABLE `RestaurantEvent`
    ADD PRIMARY KEY (`restaurantEventId`),
    ADD KEY `RestaurantId` (`restaurantId`),
    ADD KEY `fk_RestaurantEvent_ReservationDay` (`reservationDayId`),
    ADD KEY `fk_RestaurantEvent_RestaurantSessions` (`restaurantSessionId`);

--
-- Indexen voor tabel `RestaurantSessions`
--
ALTER TABLE `RestaurantSessions`
    ADD PRIMARY KEY (`restaurantSessionId`);

--
-- Indexen voor tabel `Roles`
--
ALTER TABLE `Roles`
    ADD PRIMARY KEY (`roleId`);

--
-- Indexen voor tabel `Songs`
--
ALTER TABLE `Songs`
    ADD PRIMARY KEY (`songId`),
    ADD KEY `ArtistId` (`artistId`);

--
-- Indexen voor tabel `Speciality`
--
ALTER TABLE `Speciality`
    ADD PRIMARY KEY (`specialityId`);

--
-- Indexen voor tabel `Tickets`
--
ALTER TABLE `Tickets`
    ADD PRIMARY KEY (`ticketId`),
    ADD KEY `EventId` (`eventId`);

--
-- Indexen voor tabel `UserArtistEventTickets`
--
ALTER TABLE `UserArtistEventTickets`
    ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `Users`
--
ALTER TABLE `Users`
    ADD PRIMARY KEY (`userId`),
    ADD KEY `RoleId` (`roleId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `ArtistEventLocations`
--
ALTER TABLE `ArtistEventLocations`
    MODIFY `artistEventLocationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `ArtistEvents`
--
ALTER TABLE `ArtistEvents`
    MODIFY `artistEventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT voor een tabel `ArtistMusicStyles`
--
ALTER TABLE `ArtistMusicStyles`
    MODIFY `artistMusicStyleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `Artists`
--
ALTER TABLE `Artists`
    MODIFY `artistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT voor een tabel `Events`
--
ALTER TABLE `Events`
    MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT voor een tabel `HistoryEvent`
--
ALTER TABLE `HistoryEvent`
    MODIFY `historyEventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `HistoryLocation`
--
ALTER TABLE `HistoryLocation`
    MODIFY `historyLocationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `HistoryTour`
--
ALTER TABLE `HistoryTour`
    MODIFY `historyTourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `Language`
--
ALTER TABLE `Language`
    MODIFY `languageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `Orders`
--
ALTER TABLE `Orders`
    MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT voor een tabel `Payments`
--
ALTER TABLE `Payments`
    MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT voor een tabel `PaymentStatus`
--
ALTER TABLE `PaymentStatus`
    MODIFY `paymentStatusId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `Restaurant`
--
ALTER TABLE `Restaurant`
    MODIFY `restaurantId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `RestaurantDetailPage`
--
ALTER TABLE `RestaurantDetailPage`
    MODIFY `restaurantDetailPageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `RestaurantEvent`
--
ALTER TABLE `RestaurantEvent`
    MODIFY `restaurantEventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT voor een tabel `RestaurantSessions`
--
ALTER TABLE `RestaurantSessions`
    MODIFY `restaurantSessionId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `Roles`
--
ALTER TABLE `Roles`
    MODIFY `roleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `Songs`
--
ALTER TABLE `Songs`
    MODIFY `songId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT voor een tabel `Speciality`
--
ALTER TABLE `Speciality`
    MODIFY `specialityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `Tickets`
--
ALTER TABLE `Tickets`
    MODIFY `ticketId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `UserArtistEventTickets`
--
ALTER TABLE `UserArtistEventTickets`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `Users`
--
ALTER TABLE `Users`
    MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `ArtistEvents`
--
ALTER TABLE `ArtistEvents`
    ADD CONSTRAINT `ArtistEvents_ibfk_1` FOREIGN KEY (`artistId`) REFERENCES `Artists` (`artistId`),
    ADD CONSTRAINT `ArtistEvents_ibfk_2` FOREIGN KEY (`artistId`) REFERENCES `Artists` (`artistId`),
    ADD CONSTRAINT `FK_ArtistEventLocation` FOREIGN KEY (`artistEventLocationId`) REFERENCES `ArtistEventLocations` (`artistEventLocationId`);

--
-- Beperkingen voor tabel `ArtistMusicStyles`
--
ALTER TABLE `ArtistMusicStyles`
    ADD CONSTRAINT `ArtistMusicStyles_ibfk_1` FOREIGN KEY (`artistId`) REFERENCES `Artists` (`artistId`),
    ADD CONSTRAINT `ArtistMusicStyles_ibfk_2` FOREIGN KEY (`musicStyleId`) REFERENCES `MusicStyles` (`musicStyleId`);

--
-- Beperkingen voor tabel `Events`
--
ALTER TABLE `Events`
    ADD CONSTRAINT `Events_ibfk_1` FOREIGN KEY (`historyEventId`) REFERENCES `HistoryEvent` (`historyEventId`),
    ADD CONSTRAINT `Events_ibfk_2` FOREIGN KEY (`historyEventId`) REFERENCES `HistoryEvent` (`historyEventId`),
    ADD CONSTRAINT `Events_ibfk_3` FOREIGN KEY (`restaurantEventId`) REFERENCES `RestaurantEvent` (`restaurantEventId`),
    ADD CONSTRAINT `Events_ibfk_4` FOREIGN KEY (`artistEventId`) REFERENCES `ArtistEvents` (`artistEventId`);

--
-- Beperkingen voor tabel `HistoryEvent`
--
ALTER TABLE `HistoryEvent`
    ADD CONSTRAINT `fk_HistoryTourId` FOREIGN KEY (`historyTourId`) REFERENCES `HistoryTour` (`historyTourId`);

--
-- Beperkingen voor tabel `HistoryTour`
--
ALTER TABLE `HistoryTour`
    ADD CONSTRAINT `fk_Language` FOREIGN KEY (`languageId`) REFERENCES `Language` (`languageId`);

--
-- Beperkingen voor tabel `Orders`
--
ALTER TABLE `Orders`
    ADD CONSTRAINT `fk_order_paymentId` FOREIGN KEY (`paymentId`) REFERENCES `Payments` (`paymentId`);

--
-- Beperkingen voor tabel `Restaurant`
--
ALTER TABLE `Restaurant`
    ADD CONSTRAINT `Restaurant_ibfk_1` FOREIGN KEY (`specialityId`) REFERENCES `Speciality` (`specialityId`),
    ADD CONSTRAINT `Restaurant_ibfk_2` FOREIGN KEY (`specialityId`) REFERENCES `Speciality` (`specialityId`),
    ADD CONSTRAINT `Restaurant_ibfk_3` FOREIGN KEY (`specialityId`) REFERENCES `Speciality` (`specialityId`);

--
-- Beperkingen voor tabel `RestaurantDetailPage`
--
ALTER TABLE `RestaurantDetailPage`
    ADD CONSTRAINT `RestaurantDetailPage_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `Restaurant` (`restaurantId`);

--
-- Beperkingen voor tabel `RestaurantEvent`
--
ALTER TABLE `RestaurantEvent`
    ADD CONSTRAINT `RestaurantEvent_ibfk_1` FOREIGN KEY (`restaurantId`) REFERENCES `Restaurant` (`restaurantId`),
    ADD CONSTRAINT `RestaurantEvent_ibfk_2` FOREIGN KEY (`restaurantId`) REFERENCES `Restaurant` (`restaurantId`),
    ADD CONSTRAINT `fk_RestaurantEvent_ReservationDay` FOREIGN KEY (`reservationDayId`) REFERENCES `ReservationDay` (`reservationDayId`),
    ADD CONSTRAINT `fk_RestaurantEvent_RestaurantSessions` FOREIGN KEY (`restaurantSessionId`) REFERENCES `RestaurantSessions` (`restaurantSessionId`);

--
-- Beperkingen voor tabel `Songs`
--
ALTER TABLE `Songs`
    ADD CONSTRAINT `Songs_ibfk_1` FOREIGN KEY (`artistId`) REFERENCES `Artists` (`artistId`);

--
-- Beperkingen voor tabel `Tickets`
--
ALTER TABLE `Tickets`
    ADD CONSTRAINT `Tickets_ibfk_1` FOREIGN KEY (`eventId`) REFERENCES `Events` (`eventId`);

--
-- Beperkingen voor tabel `Users`
--
ALTER TABLE `Users`
    ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `Roles` (`roleId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
