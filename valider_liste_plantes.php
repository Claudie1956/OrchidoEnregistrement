<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enregistrement des plantes</title>
</head>		

<body>	
		
<h2>Validation de la liste des plantes</h2>



<?php

# Début de la validation des champs envoyés par le formulaire
$erreur = False;
$message_formulaire_invalide = "Erreur dans le formulaire";

# Valider le nom
if (!isset($_POST['nom']) || empty($_POST['nom'])) 
{
	echo("<font color=red><b>*** Entrez votre nom! ***</b></font><br>"); 
	$erreur = true;
}
else
{ $nom = htmlspecialchars($_POST['nom']);
  echo "<b>$nom</b><br>"; 
  $_SESSION['nom'] = $nom;
}

# Valider le courriel

if (!isset($_POST['email']) || filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == FALSE)
   { echo "<font color=red><b>*** Votre adresse courriel est invalide ***</b> ***</b></font><br>";
	 $erreur = true; 
   }
else 
{ $email = htmlspecialchars($_POST['email']);
  echo "<b>$email</b><br>"; 
  $_SESSION['email'] = $email;
}

# Valider: #membre ou Société, mais pas les deux. Mais un des deux
$membre = htmlspecialchars($_POST['membre']);
$societe = htmlspecialchars($_POST['societe']);
if (isset($_POST['membre']) && !empty($_POST['membre'])) 
{
	$membre = htmlspecialchars($_POST['membre']);
}
else
{
	$membre = "";
}

if (isset($_POST['societe']) && !empty($_POST['societe'])) 
{
	$societe = htmlspecialchars($_POST['societe']);
}
else
{
	$societe = "";
}

if (strlen($membre) == 0 && strlen($societe) == 0)
{  echo ("<font color=red><b>*** Entrez le numéro de membre ou le nom de la société orchidophile ***</b></font><br>"); 
   $erreur = true;
}
else if (strlen($membre) > 0 && strlen($societe) > 0)
  {
	echo ("<font color=red><b>*** Entrez le numéro de membre ou le nom de la société orchidophile, mais pas les deux! ***</b></font><br>"); 
	$erreur = true;
   }
else
   { $_SESSION['membre'] = $membre;
     $_SESSION['societe'] = $societe;
   }

?> 

<p></p>

<?php
# remplir tableaux avec les noms et les catégories de plantes
$nomp = array();
$catp = array();
$pas_aos = array();
$maxp = 10;

$plantes = array();

if (isset($_POST['plantes'])) 
{
	foreach ($_POST['plantes'] as $plante) 
	{	if (strlen($plante['nomp']) > 0) 
		{
			$nouvelle_plante = array();
			$nouvelle_plante['nomp'] = $plante['nomp'];
			if (empty($plante['catp']) or ($plante['catp'] == "message_categorie"))
			{ 	$nom_plante =  $nouvelle_plante['nomp'];
			    echo "<font color=red><b>*** Catégorie manquante pour $nom_plante ***</b></font><br>"; 
			    $nouvelle_plante['catp'] = "";
             	$erreur = true;
			}
			else 
			{ $nouvelle_plante['catp'] = $plante['catp'];
            }
			$nouvelle_plante['pas_aos'] = isset($plante['pas_aos']);
			$plantes[] = $nouvelle_plante;
		}
	}
}
else
{
	echo ("Paramètres non définis<br>");
	$erreur = true;
}

$nbplantes = count($plantes);

$_SESSION['nbplantes'] = $nbplantes;
$_SESSION['plantes'] = $plantes;


if (count($plantes) == 0)
{ echo "<font color=red><b>*** Vous n'avez entré aucune plante ***</b></font><br>";
  $erreur = true;
}
else
{  $str_plantes = "plante";
   if (count($plantes) > 1) { $str_plantes .= "s"; }
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
foreach ($plantes as $index=>$plante)
 {
     echo "<tr>";
	 $noplante = $index + 1;
     echo "<td align=center>$noplante</td>";
     echo "<td align=center>"; 
	 $lennom = strlen($plante['nomp']);
	 if (empty ($plante['catp']))
		 { $erreur = true; 
		   echo("Erreur");
		 }
  	 else echo($plante['catp']); 
     echo "<td align=left>{$plante['nomp']}<td>";
	 if ($plante['pas_aos'])
	 { $str_pas_aos = "X"; }
	 else 
	 { $str_pas_aos = ""; }
     echo "<td align=center>$str_pas_aos<td>";
	 echo "</td></tr>";
}
echo "</table>\n";
?>


<?php
# Si erreur, bouton pour retourner au formulaire
$tabnum=1;
if (! $erreur)
{ 
	echo "<p></p>";
    echo "<form id='bouton_valider' method='post' action='liste_plantes_confirmee.php'>";
	echo "<center><input type=submit name=envoyer value='Envoyer la liste' tabindex=$tabnum /></center>";
    echo "</form>\n";
    echo "<center>ou</center>";
	$tabnum++;
}
echo "<center><button onclick='history.go(-1);'>Revenir au formulaire</button></center>\n";

session_write_close();	
?>
		 
</body>
</html>
