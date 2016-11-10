<?php
$id = 1; // ID til element (f.eks. film) der skal rates på - bliver defineret via $_GET
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rating Demo med PHP</title>
    <link rel="stylesheet" type="text/css" href="css/star-ratings.css">
</head>

<body>
	<h1>Rating - Demo med PHP</h1>
	<h2>Visning af aktuel bedømmelse uden mulighed for at bedømme</h2>
	<!-- Eksempel med visning af aktuel rating -->
	<span class="rating">
	<?php
    // Løkke der generer 5 stjerner, vi kører fra 5 og nedaf da rating har omvendt tekstretning
    for ($i = 5; $i > 0; $i--)
	{
        // Vi lader som om element er ratet med 3 stjerner nu, så hvis $i er mindre eller lig med 3, skal vi tilføje class active
        if ($i <= 3)
		{
            $active = ' active';
        }
		else
		{
            $active = '';
        }
		// Ovenstående tjek, kan også skrives shorthand hvis det foretrækkes:
		// $active = $i <= 3 ? ' active' : '';
		
		// Udskriv stjerner som span hvis der ikke skal kunne rates
        ?>
		<span class="star<?php echo $active ?>"></span>
		<?php
    }
	?>
    </span>
    
    <hr>

	<h2>Visning af egen bedømmelse med mulighed for at rate</h2>
    <!-- Eksempel med visning af noget jeg har rated -->
    <span class="rating">
    <?php
    // Løkke der generer 5 stjerner, vi kører fra 5 og nedaf da rating har omvendt tekstretning
    for ($i = 5; $i > 0; $i--)
	{
        // Vi lader som den aktuelle bruger har ratet elementet med 1 stjerne nu, så hvis $i er mindre eller lig med 1, skal vi tilføje class active
        if ($i <= 1)
		{
            $active = ' active';
        }
		else
		{
            $active = '';
        }
		// Ovenstående tjek, kan også skrives shorthand hvis det foretrækkes:
		// $active = $i <= 1 ? ' active' : '';
		
		// Udskriv stjerner som links
		?>
        <a href="rating.php?id=<?php echo $id ?>&rate=<?php echo $i ?>" class="star<?php echo $active ?>"></a>
		<?php
    }
	?>
	</span>
</body>
</html>