<?php
error_reporting(-1);
ini_set('display_errors','On');
?>
<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<style type="text/css">
a.stylebouton {
  border-radius: 3px;
  border: solid thin #1C1C1C;
  text-shadow: none;
  background: #01DF01;
  color: buttontext;
  padding: 3px 8px;
  margin: 2px;
  text-decoration: none;
  font-family: Arial;
  font-size: 13px;
}
a.stylebouton:hover {
 background-image: -webkit-linear-gradient(top, #DDDDDD, #F6F6F6);
  background-image: -moz-linear-gradient(top, #DDDDDD, #F6F6F6);
  background-image: -ms-linear-gradient(top, #DDDDDD, #F6F6F6);
  background-image: -o-linear-gradient(top, #DDDDDD, #F6F6F6, #DDDDDD);
  background-image: linear-gradient(to bottom, #DDDDDD, #F6F6F6);    
}
</style>

<?php
# Fonction pour envoyer courriel, utilisée à la fin
function envoyer_liste()
{
	$destinataire = "lafittemarchi.claudie@gmail.com";
	$objet = "Enregistrement des plantes de " . $_SESSION['nom'];
	$message = "Plantes de " . $_SESSION['nom'] . "\n";
	$message = $message . $_SESSION['email'] . "\n";
    if (empty($_SESSION['membre']))
    { $message = $message . $_SESSION['societe'] . "\n\n"; }
    else
    { $message = $message . "Membre# " . $_SESSION['membre'] . "\n\n"; }
	
	foreach ($_SESSION['plantes'] as $plante)
	{ $str_pas_aos = $plante['pas_aos'] ? "X" : "";
	  $str_parfum = $plante['parfum'] ? "Parfum" : "";
	  $message = $message . $plante['catp'] . "  " . $plante['nomp'] . " " . $str_pas_aos . " " . $str_parfum ."\n"; 
	}
    echo "<center><font size='+2'><b>$objet</b></font></center>";
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
#	echo "Destinataire $destinataire<br>";
#	echo "Objet $objet<br>";
#	echo "Message <br>";
#	echo "$message<br>";
#	echo "Header <br>";
#	echo "$headers<br>";
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


<center><a class='stylebouton' href='./enregistrement.php'>Retour à la page d'enregistrement</a></center>";


</body>
</html>