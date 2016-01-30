<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
# Fonction pour envoyer courriel, utilisée à la fin
function envoyer_liste()
{
	$destinataire = "lafittemarchi.claudie@gmail.com";
	$objet = "Enregistrement des plantes de " . $_SESSION['nom'];
	$message = "Plantes de " . $_SESSION['nom'] . "\n";
	$message = $message . $_SESSION['email'] . "\n";
    if (empty($_SESSION['membre']))
    { $message = $message . $_SESSION['societe'] . "\n"; }
    else
    { $message = $message . "Membre# " . $_SESSION['membre'] . "\n\n"; }
	
	for ($i = 0; $i <= $_SESSION['nbplantes']-1 ; $i++) 
	{ $message = $message . $_SESSION['catp'][$i] . "  " . $_SESSION['nomp'][$i] . $_SESSION['pas_aos'][$i] ."\n"; }
	echo "<p></p>";
	print "Contenu du message envoyé\r\n";
	print "$message";
	# Structure courriel
	$message_envoye = "Votre message a été envoyé !";
    $message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'From:'.$_SESSION['nom'].' <'.$_SESSION['email'].'>' . "\r\n" .
				'Reply-To:'.$_SESSION['email']. "\r\n" .
				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
				'Content-Disposition: inline'. "\r\n" .
				'Content-Transfer-Encoding: 7bit'." \r\n" .
				'X-Mailer:PHP/'.phpversion();
    if (mail($destinataire, $objet, $message, $headers))
	{
	  echo '<p><center>'.$message_envoye.'</center></p>'."\n";
	}
	else
	{
	  echo '<p><center>'.$message_non_envoye.'</center></p>'."\n";
	};
}
?>

<?php

if (isset($_POST['envoyer']))
{ envoyer_liste();
}

?>

<!-- Retour à la page d'enregistrement -->

<center><a href="./enregistrement.php">Retour à la page d'enregistrement</a></center>


</body>
</html>