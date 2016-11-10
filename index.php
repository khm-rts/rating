<?php
// Inkludér fil der etablerer forbindelse til databasen (i variablen $link)
require 'db_config.php';
// Inkluder fil med funktioner til at vise ratings og bedømme film
// require 'functions.php';

session_start();

// Hvis URL parametret bruger-id er defineret i adresselinjen, gemmes bruger id'et herfra i en session af samme navn
if ( isset($_GET['bruger-id']) ) $_SESSION['bruger_id'] = $_GET['bruger-id'];

// Hvis URL parametret log-af er defineret i adresselinken, slettes bruger_id fra session for at logge brugeren af
if ( isset($_GET['log-af']) ) unset($_SESSION['bruger_id']);

// Hvis URL parametrene id og rate, samt bruger_id er defineret i session, køres funktion for at bedømme film
if ( isset($_GET['id'], $_GET['rate'], $_SESSION['bruger_id']) )
{
	// Funktionen rate(), kan også bruges til at bedømme filmen
	// rate($_GET['rate'], $_GET['id'], $_SESSION['bruger_id']);

	// Brug intval til at sikre værdien fra URL parametrene rate og id samt bruger_id fra session kun indeholder tal, inden variabler bliver brugt i SQL-sætning for at sikre imod injections
	$rating		= intval($_GET['rate']);
	$film_id	= intval($_GET['id']);
	$bruger_id	= intval($_SESSION['bruger_id']);

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
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- CSS til Font Awesome ikoner -->
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- CSS til Star Ratings der bruger Font Awesome -->
	<link rel="stylesheet" type="text/css" href="star-ratings/css/star-ratings-fa.css">

	<title>Rating af film</title>
</head>
<body>

	<h1>Eksempel på rating af film</h1>

	<?php
	// Hvis ikke man er "logget ind", vises liste over brugernavne man kan klikke på for at logge ind
	if ( !isset($_SESSION['bruger_id']) )
	{
		?>
		<h2>Login cheat <small>Klik på et brugernavn for at logge ind</small></h2>

		<ul>
		<?php

		// Forespørgsel til at hente brugere fra databasen
		$query =
			"SELECT
				bruger_id, bruger_navn
			FROM
				brugere
			ORDER BY
				bruger_navn";

		// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
		$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);

		// mysqli_fetch_assoc() returner data fra forespørgslen som et assoc array og vi gemmer data i variablen $row. Brug while til at løbe igennem alle rækker fra databasen
		while( $row = mysqli_fetch_assoc($result) )
		{
			?>
			<li>
				<a href="index.php?bruger-id=<?php echo $row['bruger_id'] ?>">
					<?php echo $row['bruger_navn'] ?>
				</a>
			</li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	// Hvis man er "logget ind", vises link til log ud
	else
	{
		?>
		<a href="index.php?log-af">Log af</a>
		<?php
	}

	// Forespørgsel til at hente alle film fra databasen gemmes i variablen $query
	// Film sorteres efter højeste rating først og dernæst alfabetisk, hvis der er flere film med samme rating
	$query =
		"SELECT
			*
		FROM
			film
		ORDER BY
			film_rating DESC, film_titel";

	// Send forespørgsel til databasen med mysqli_query(). Hvis der er fejl heri, stoppes videre indlæsning og fejlbesked vises
	$result = mysqli_query($link, $query) or die( mysqli_error($link) . '<pre>' . $query . '</pre>' . 'Fejl i forespørgsel på linje: ' . __LINE__ . ' i fil: ' . __FILE__);

	// mysqli_fetch_assoc() returner data fra forespørgslen som et assoc array og vi gemmer data i variablen $row. Brug while til at løbe igennem alle rækker fra databasen
	while( $row = mysqli_fetch_assoc($result) )
	{
		?>
		<hr>
		<h3><?php echo $row['film_titel'] ?> (<?php echo $row['film_prod_aar'] ?>)</h3>
		Varenr. <?php echo $row['film_premiere'] ?>
		<br><?php echo substr( strip_tags($row['film_beskrivelse']), 0, 100 ) . '...' // Brug substr() til kun at vise de første 100 karakterer af filmens beskrivelse og strip_tags() for at sikre vi ikke mangler at slutte et tag når vi mangler noget af beskrivelsen ?>
		<br>
		<?php
		// Hvis en bruger er logget ind vises stjerner til at rate
		if ( isset($_SESSION['bruger_id']) )
		{
			// Funktionen vis_rating() kan også bruges til at vise stjerner
			// vis_rating(5, $row['film_rating'], 'current-rating', true, 'index.php?id=' . $row['film_id']);
			?>
			<!-- Eksempel med visning af noget jeg har rated og mulighed for at rate -->
			<span class="rating">
			<?php
			// Løkke der generer 5 stjerner, vi kører fra 5 og nedaf da rating har omvendt tekstretning
			for ($i = 5; $i > 0; $i--)
			{
				// Hvis den aktuelle rating på filmen, er større eller lig med den nummer stjerne vi er ved at vise, tilføjes klassen current-rating, som er en gul stjerne, til variablen $active
				if ($i <= $row['film_rating'])
				{
					$active = ' current-rating';
				}
				else
				{
					$active = '';
				}
				// Ovenstående tjek, kan også skrives shorthand hvis det foretrækkes:
				// $active = $i <= 1 ? ' active' : '';

				// Udskriv stjerner som links
				?>
				<a href="index.php?id=<?php echo $row['film_id'] ?>&rate=<?php echo $i ?>" class="star<?php echo $active ?>"></a>
				<?php
			}
			?>
			</span>
			<?php
		}
		// Ellers vises stjerner med aktuel rating
		else
		{
			// Funktionen vis_rating() kan også bruges til at vise stjerner
			// vis_rating(5, $row['film_rating'], 'current-rating');
			?>
			<!-- Eksempel med visning af aktuel rating -->
			<span class="rating">
			<?php
			// Løkke der generer 5 stjerner, vi kører fra 5 og nedaf da rating har omvendt tekstretning
			for ($i = 5; $i > 0; $i--)
			{
				// Hvis den aktuelle rating på filmen, er større eller lig med den nummer stjerne vi er ved at vise, tilføjes klassen current-rating, som er en gul stjerne, til variablen $active
				if ($i <= $row['film_rating'])
				{
					$active = ' current-rating';
				}
				else
				{
					$active = '';
				}
				// Ovenstående tjek, kan også skrives shorthand hvis det foretrækkes:
				// $active = $i <= $row['film_rating'] ? ' current-rating' : '';

				// Udskriv stjerner som span hvis der ikke skal kunne rates
				?>
				<span class="star<?php echo $active ?>"></span>
				<?php
			}
			?>
			</span>
			<?php
		}
		?>

		<?php
	} // Luk af while-løkken
	?>
</body>
</html>