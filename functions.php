<?php
/**
 * Funktion til at vise stjerner til rating. Kræver CSS til Font Awesome og Star-Ratings inkluderet på siden hvor den bruges
 * @param int $antal_stjerner_i_alt:	Antallet af stjerner i alt
 * @param int $aktuel_rating:			Antallet af stjerner med klassen fra $aktiv_css_klasse
 * @param string $aktiv_css_klasse:		Navn på css-klasse til stjerner indenfor værdi fra $aktuel_rating. my-rating eller current-rating er  tilgængelig i Star Ratings fra assets/ og farver kan rettes efter behov, eller du kan lave dine egne klasser.
 * @param bool $rate:					Sæt til true hvis man skal kunne rate. Som standard er det slået fra
 * @param string $url_til_rate:			Hvis der skal rates via link kan værdi angives her
 * @param mixed $id:					Hvis der er behov for id til element, f.eks. ved jQuery/ajax, så kan det angives her
 */
function vis_rating($antal_stjerner_i_alt, $aktuel_rating, $aktiv_css_klasse, $rate = false, $url_til_rate = NULL, $id = NULL)
{
	// Start container til stjerner og hvis id er angivet tilføjes det
	echo '<span class="rating"' . ( isset($id) ?  'id="' . $id . '"' : '' ) . '>';

	// Kør løkke der generer x antal stjerner, gemt i $antal_stjerner_i_alt. Vi kører fra dette antal og ned til 1, da klassen rating har omvendt tekstretning
	for ($i = $antal_stjerner_i_alt; $i > 0; $i--)
	{
		// Hvis den aktuelle stjerne er mindre eller lig den aktuelle rating gemmes css-klassen fra variablen $aktiv_css_klasse i $aktiv. Ellers indeholder $aktiv ingen klasse. Vi bruger round for at sikre aktuel_rating er et helt nummer.
		$aktiv = $i <= round($aktuel_rating) ? $aktiv_css_klasse : '';

		// Hvis værdi af rate er true, skal hver stjerne være et link man kan trykke på for at rate
		if ( $rate == true )
		{
			// Udskriv hver stjerne i link og hvis $url_til_rate er defineret udskrives den i href
			echo '<a href="' . ( isset($url_til_rate) ? $url_til_rate.'&rating=' . $i : '' ) . '" data-rating="' . $i . '" class="star ' . $aktiv . '"></a>';
		}
		// Ellers bruges span hvis man kun ønsker at vise aktuel rating
		else
		{
			echo '<span class="star '.$aktiv.'"></span>';
		}
	}

	// Luk container til stjerner
	echo '</span>';
}

/**
 * Funktion til at bedømme film og beregne gennemsnit heraf og tilføje filmen
 * @param int $rating:		Antal stjerner filmen skal bedømmes med
 * @param int $film_id:		ID'et til filmen der skal bedømmes
 * @param int $bruger_id:	ID'er til brugeren der bedømmer filmen
 */
function rate($rating, $film_id, $bruger_id)
{
	global $link;

	// Brug intval til at sikre $ratingm, film_id og $bruger_id kun indeholder tal, inden variabler bliver brugt i SQL-sætning for at sikre imod injections
	$rating		= intval($rating);
	$film_id	= intval($film_id);
	$bruger_id	= intval($bruger_id);

	// Forespørgsel til at slette evt. eksisterende indlæg
	$query =
		"DELETE FROM 
			ratings 
		WHERE 
			fk_film_id = $film_id AND fk_bruger_id = $bruger_id";

	// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
	$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);

	// Forespørgsel til at indsætte ny rating
	$query =
		"INSERT INTO 
			ratings (fk_film_id, fk_bruger_id, rating)
		VALUES 
			($film_id, $bruger_id, $rating)";

	// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
	$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);

	// Forespørgsel til at tælle hvor mange ratings der er til den aktuelle film og hvad summen af dem er
	$query =
		"SELECT
			COUNT(*) AS ratings_antal, SUM(rating) AS ratings_sum
		FROM
			ratings
		WHERE
			fk_film_id = $film_id";

	// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
	$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);

	// mysqli_fetch_assoc() returner data fra forespørgslen som et assoc array og vi gemmer data i variablen $row.
	$row = mysqli_fetch_assoc($result);

	// Beregn gennemsnit ved at dividere sum med antal og rund op/ned til tal med 1 decimal
	$rating_gns = round( ($row['ratings_sum'] / $row['ratings_antal']), 1 );

	// Forespørgsl til at opdatere filmen med nyt beregnet gennemsnit
	$query =
		"UPDATE
			film
		SET
			film_rating = $rating_gns, film_antal_ratings = $row[ratings_antal]
		WHERE
			film_id = $film_id";

	// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
	$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);
}