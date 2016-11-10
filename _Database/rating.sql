-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 10. 11 2016 kl. 15:06:23
-- Serverversion: 10.1.10-MariaDB
-- PHP-version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rating`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `brugere`
--

CREATE TABLE `brugere` (
  `bruger_id` mediumint(8) UNSIGNED NOT NULL,
  `bruger_navn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `brugere`
--

INSERT INTO `brugere` (`bruger_id`, `bruger_navn`) VALUES
(1, 'Elliot Alderson'),
(2, 'Felicity Smoak'),
(3, 'John Connor'),
(4, 'Thomas A. Anderson');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `film`
--

CREATE TABLE `film` (
  `film_id` mediumint(8) UNSIGNED NOT NULL,
  `film_titel` varchar(90) NOT NULL,
  `film_prod_aar` year(4) NOT NULL,
  `film_beskrivelse` text NOT NULL,
  `film_premiere` date NOT NULL,
  `film_rating` decimal(2,1) UNSIGNED NOT NULL,
  `film_antal_ratings` mediumint(8) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `film`
--

INSERT INTO `film` (`film_id`, `film_titel`, `film_prod_aar`, `film_beskrivelse`, `film_premiere`, `film_rating`, `film_antal_ratings`) VALUES
(1, 'Warcraft: The Beginning - 3D', 2016, '<p>Det fredelige rige Azeroth er p&aring; randen af krig, for frygtl&oslash;se, invaderende ork-krigere, der er p&aring; flugt fra deres d&oslash;dende verden, leder efter nyt land at kolonisere.<br />\n<br />\nDa en portal &aring;bner sig og forbinder de to verdner, st&aring;r en h&aelig;r over for sin undergang og den anden over for udslettelse. To helte, fra hver deres &aelig;t, vil st&aring; over for hinanden, n&aring;r sk&aelig;bnen time falder i slag for deres familier, folkeslag og hjem.</p>\n\n<p>Trailer:</p>\n\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="480" src="//www.youtube.com/embed/-ogw1cSZO0I" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\n\n<p>&nbsp;</p>\n', '2016-05-26', '0.0', 0),
(2, 'Alice Through the Looking Glass - 3D', 2016, '<p>Alice Kingsleigh har v&aelig;ret ude at sejle i tre &aring;r. Da hun vender tilbage til London, falder hun over et magisk spejl og vender tilbage til den fantastiske verden i Underland.<br />\n<br />\nAlice genforenes med sine venner kaninen, k&aring;lormen Absolem, den hvide dronning og filurkatten og skal nu redde den gale hattemager og hele Underland, f&oslash;r tiden l&oslash;ber ud.</p>\n\n<p>Trailer:</p>\n\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/I3PTtSsnHpI?rel=0&amp;start=11" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\n\n<p>&nbsp;</p>\n', '2016-05-26', '0.0', 0),
(3, 'X-Men: Apocalypse - 3D', 2016, '<p>Siden tidernes morgen blev han tilbedt som en gud &ndash; Apocalypse er den f&oslash;rste og mest magtfulde mutant fra Marvel&rsquo;s X-Men univers. Han akkumulerer kr&aelig;fter fra andre mutanter og er b&aring;de ud&oslash;delig og uovervindelig.<br />\r\n<br />\r\nDa han v&aring;gner efter tusinde af &aring;r, er han skuffet over den verden, han oplever, og rekrutterer et hold af st&aelig;rke mutanter, deriblandt den modl&oslash;se Magneto, for at udrydde menneskeheden og skabe en ny verdensorden, som han kan regere.<br />\r\n<br />\r\nVerdens sk&aelig;bne h&aelig;nger i en tynd tr&aring;d, og Raven m&aring; i samarbejde med Professor X lede en gruppe af unge X-Men for at stoppe deres v&aelig;rste fjende og redde mennesket fra udslettelse.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/Jer8XjMrUB4?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-05-19', '0.0', 0),
(4, 'Captain America: Civil War - 2D', 2016, '<p>I Marvels &ldquo;Captain America: Civil War&rdquo; st&aring;r Steve Rogers i spidsen for det nye Avengers-team, som forts&aelig;tter kampen for at beskytte menneskeheden. Da Avengers er involveret i endnu en episode med civile tab til f&oslash;lge, presser politikerne p&aring; for at f&aring; indf&oslash;rt et system med en bestyrelse, som kan f&oslash;re tilsyn med teamet, lede dem og stille dem til ansvar.<br />\r\n<br />\r\nDen nye konstruktion betyder, at Avengers bliver delt i to lejre. Den ene anf&oslash;res af Steve Rogers, der helst ser, at Avengers skal kunne forsvare menneskeheden uden myndighedernes indblanding.<br />\r\n<br />\r\nI spidsen for den anden lejr st&aring;r Tony Stark, der overraskende nok gerne vil v&aelig;re under opsyn og kunne stilles til ansvar.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/dKrVegVI0Us?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-04-28', '0.0', 0),
(5, 'Bad Neighbours 2', 2016, '<p>Seth Rogen, Zac Efron og Rose Byrne vender alle tilbage i Bad Neighbours 2 og denne gang f&oslash;r de f&oslash;lgeskab af Chlo&euml; Grace Moretz.<br />\r\n<br />\r\nNicholas Stoller st&aring;r igen for instruktionen.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/EIe7nR0lvk4?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-05-12', '2.7', 3),
(6, 'Ice Age: Collision Course - 3D', 2016, '<p>Scrats evige jagt p&aring; den undvigende n&oslash;d sender ham ud i universet, hvor han ved et uheld starter en r&aelig;kke af kosmiske h&aelig;ndelser, der forandrer og truer Ice Age verdenen.<br />\r\n<br />\r\nSid, Manfred, Diego og resten af flokken m&aring; for at redde verden forlade deres hjem og tage p&aring; en vild rejse, hvor de oplever eksotiske, nye steder og m&oslash;der nye, farverige karakterer.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/yPmm1JhygIo?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-07-07', '4.0', 1),
(7, 'Independence Day: Resurgence', 2016, '<p>Vi vidste, at de ville komme tilbage. Efter INDEPENDENCE DAY redefinerede genren, leverer dette n&aelig;ste kapitel en global katastrofe af utrolige dimensioner.<br />\r\n<br />\r\nVed brug af rumv&aelig;senernes egen teknologi har alle klodens nationer samarbejdet om et enormt forsvarsprogram for at beskytte jorden.<br />\r\n<br />\r\nIntet kan dog forberede os p&aring; rumv&aelig;senernes avancerede og hidtil usete styrke, og kun opfindsomhed og snilde kan redde os fra udryddelsens rand.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/LbduDRH2m2M?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-06-23', '0.0', 0),
(8, 'The Conjuring 2', 2016, '<p>I en af deres mest r&aelig;dselsv&aelig;kkende paranormale efterforskninger nogensinde rejser d&aelig;monj&aelig;gerparret, Ed og Lorraine Warren til det nordlige London for at hj&aelig;lpe en enlig mor, som bor alene med sine fire b&oslash;rn i et gammelt hus, der tilsyneladende hjems&oslash;ges af uforklarlige, angstfremkaldende og ekstremt ondartede d&aelig;moner; velkommen til 2. kapitel af det, der af mange anses som filmhistoriens mest uhyggelige gyserserie.</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/KyA9AtUOqRM?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-06-09', '0.0', 0),
(9, 'Me Before You', 2016, '<p>Nogle gange finder man k&aelig;rligheden, hvor - og n&aring;r - man mindst venter det og nogle gange tager den &eacute;n til steder, man aldrig havde troet, man ville finde&hellip;<br />\r\n<br />\r\n26-&aring;rige Louisa &ldquo;Lou&rdquo; Clark bor i en pittoresk landsby i et landligt omr&aring;de af England. Hendes liv er blottet for kurs eller plan og den lettere excentriske, kreative pige glider fra det ene ligegyldige job til det n&aelig;ste, for at hj&aelig;lpe familien med at f&aring; &oslash;konomien til at h&aelig;nge sammen. Hendes normalt glade og...</p>\r\n\r\n<p>Trailer:</p>\r\n\r\n<div style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden;"><iframe allowfullscreen="" frameborder="0" height="360" src="//www.youtube.com/embed/Eh993__rOxA?rel=0" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" width="640"></iframe></div>\r\n\r\n<p>&nbsp;</p>\r\n', '2016-06-02', '0.0', 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `ratings`
--

CREATE TABLE `ratings` (
  `fk_film_id` mediumint(8) UNSIGNED NOT NULL,
  `fk_bruger_id` mediumint(8) UNSIGNED NOT NULL,
  `rating` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Data dump for tabellen `ratings`
--

INSERT INTO `ratings` (`fk_film_id`, `fk_bruger_id`, `rating`) VALUES
(5, 1, 2),
(5, 2, 5),
(5, 4, 1),
(6, 1, 4);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `brugere`
--
ALTER TABLE `brugere`
  ADD PRIMARY KEY (`bruger_id`);

--
-- Indeks for tabel `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`film_id`);

--
-- Indeks for tabel `ratings`
--
ALTER TABLE `ratings`
  ADD KEY `fk_film_id` (`fk_film_id`),
  ADD KEY `fk_bruger_id` (`fk_bruger_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `brugere`
--
ALTER TABLE `brugere`
  MODIFY `bruger_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tilføj AUTO_INCREMENT i tabel `film`
--
ALTER TABLE `film`
  MODIFY `film_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`fk_film_id`) REFERENCES `film` (`film_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`fk_bruger_id`) REFERENCES `brugere` (`bruger_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
