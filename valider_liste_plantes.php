<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enregistrement des plantes</title>
<link href="styleLSP.css" rel="stylesheet" type="text/css" />
</head>		

<body>	
		
<h2>Validation de la liste des plantes</h2>

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
	
	for ($i = 0; $i <= $nbplantes-1 ; $i++) 
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
	  echo '<p>'.$message_envoye.'</p>'."\n";
	}
	else
	{
	  echo '<p>'.$message_non_envoye.'</p>'."\n";
	};
}
?>

<?php

session_start();

# Début de la validation des champs envoyés par le formulaire
$erreur = False;
$message_formulaire_invalide = "Erreur dans le formulaire";

# Valider le nom
$nom = htmlspecialchars($_POST['nom']);
if (empty($nom))
{ echo("<font color=red><b>*** Entrez votre nom! ***</b></font><br>"); 
  $erreur = True;
}
else 
{ echo "<b>$nom</b><br>"; 
  $_SESSION['nom'] = $nom;
}

# Valider le courriel
$email = htmlspecialchars($_POST['email']);

if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
    { echo "<font color=red><b>*** Votre adresse courriel est invalide ***</b> ***</b></font><br>";
	  $erreur = True; }
else 
{ echo "<b>$email</b><br>"; 
  $_SESSION['email'] = $nom;
}

# Valider: #membre ou Société, mais pas les deux. Mais un des deux
$membre = htmlspecialchars($_POST['membre']);
$societe = htmlspecialchars($_POST['societe']);
if (empty($membre) and empty($societe))
{echo ("<font color=red><b>*** Entrez le numéro de membre ou le nom de la société orchidophile ***</b></font><br>"); 
 $erreur = True;
}
elseif (empty($membre) == FALSE and empty($societe) == FALSE)
{echo ("<font color=red><b>*** Entrez le numéro de membre ou le nom de la société orchidophile, mais pas les deux! ***</b></font><br>"); 
 $erreur = True;
}
else
{ if (empty($membre))
   { echo "<b>$societe</b><br>"; 
     $_SESSION['membre'] = null;
     $_SESSION['societe'] = $societe;
   }
  else
   { echo "<b>$membre</b><br>"; 
     $_SESSION['membre'] = $membre;
     $_SESSION['societe'] = null;;
   }
}
?> 

<p></p>

<?php
# remplir tableaux avec les noms et les catégories de plantes
$nomp = array("");
$catp = array("");
$pas_aos = array("");
$maxp = 10;

if (isset($_POST['plantes'])) 
{
    $nbplantes = 0;
	foreach (htmlspecialchars($_POST['plantes']) as $plante) 
	{	if (strlen($plante['nomp']) > 0) 
		{   $nomp[$nbplantes] = $plante['nomp'];
			$catp[$nbplantes] = $plante['catp'];
			if (isset($plante['pas_aos'])) 
			{ $pas_aos[$nbplantes] = $plante['pas_aos']; }
            else { $pas_aos[$nbplantes] = ""; }
            $nbplantes++;
		}
	}
}

$_SESSION['nbplantes'] = $nbplantes;
$_SESSION['nomp'] = $nomp;
$_SESSION['catp'] = $catp;
$_SESSION['pas_aos'] = $pas_aos;

if ($nbplantes == 0)
{ echo "<font color=red><b>*** Vous n'avez entré aucune plante ***</b></font><br>";
  $erreur = True;
}
else
{  $str_plantes = "plante";
   if ($nbplantes > 1) { $str_plantes = $str_plantes . "s"; }
   echo "Nombre de $str_plantes: $nbplantes <br>"; 
}




# Afficher les plantes entrées 

echo "<table cols=4 width=700>";
echo "<tr><b>";
echo "<td width=10 align=center>No</td>";
echo "<td width=100 align=center>Catégorie</td>";
echo "<td width=500 align=left>Nom</td>";
echo "<td width=50 align=center>Pas AOS</td>";
echo "</b></tr>";
for ($i = 0; $i <= $nbplantes-1; $i++)
 {
     echo "<tr>";
	 $noplante = $i + 1;
     echo "<td align=center>$noplante</td>";
     echo "<td align=center>"; 
	 $lennom = strlen($nomp[$i]);
	 $lencat = strlen($catp[$i]);
     if (($lennom > 0) and ($lencat = 0) )
		 { $erreur = True; echo("Erreur");}
  	 else echo("$catp[$i]"); 
     echo "<td align=left>$nomp[$i]<td>";
     echo "<td align=center>$pas_aos[$i]<td>";
	 echo "</td></tr>";
}
echo "</table>";
?>


<?php
# Si erreur, bouton pour retourner au formulaire
if ($erreur)
{
#  echo "<font color=red><b>*** $message_formulaire_invalide ***</b></font><br>";
#  echo "<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
#   echo "<br>";
  echo "<button onclick='history.go(-1);'>Revenir au formulaire</button> ";
}
else
{
	# bouton pour envoyer le mail	
	echo "<p></p>";
#   echo "<form>";
#   echo "<input type=submit value='Envoyer la liste' onclick=envoyer_liste()>";
#   echo "</form>";
	echo "<form name='boutons'>";
    echo "<center><input type=button name='Envoyer' value='Envoyer la liste' onClick='envoyer_liste()' /><center>";
    echo "</form>";
    echo "<div align=center>ou</div>";
    echo "<center><button onclick='history.go('./enreg.php');'>Revenir au formulaire</button></center> ";

}

session_write_close();	
?>
		 
</body>
</html>
