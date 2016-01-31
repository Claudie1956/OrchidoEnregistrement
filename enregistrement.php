<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enregistrement des plantes</title>
</head>		
<body>

<h2>Enregistrement des plantes</h2>
    <form id="enregistrement" method="post" action="valider_liste_plantes.php">
    	<fieldset><legend><b>Vos coordonnées</b></legend>
            <table cols="2" width="700">
            <tr>
            <td width="150" align=left>Nom:</td>
            <td width="500" ><input type="text" id="nom" name="nom" size="60" tabindex="1" /></td>
            </tr>
            <tr>
            <td align="left">Courriel:</td>
            <td><input type="text" id="email" name="email" size="60" tabindex="2"></td>
            </tr>
            <tr>
            <td align=left><label for="membre"># membre: </label><input type="text" id="membre" name="membre" size="4" tabindex="3" /></td>
            <td ><label for="societe">ou Société: </label><input type="text" id="societe" name="societe" size="50" tabindex="4" /></td>
            </tr>
            </table>
    	</fieldset>

<?php
# Lire fichier des catégories de plantes
$ligne_liste = array("");
$fichier=file('./categories_plantes.txt');
$i=0;
$nb=count($fichier);
$first = true;
$il = 0;
$ligne_liste[$il] = "<option value='message_categorie'>Choisissez une catégorie...</option>";
while($i<$nb)
{ $type = substr($fichier[$i],0,1);
  #echo $fichier[$i];
  #echo "Type $type";
  if ($type != "C")
   { $r=explode(';',$fichier[$i],2);
     #echo "$r[0] $r[1]<br>";
     #echo "Groupe $r[1]<br>"; 
     if ($first == false) 
	   { $il++; 
	     $ligne_liste[$il]="</optgroup>"; 
	   }
	 $il++; $ligne_liste[$il]="<optgroup label='$r[1]'>";
  	 $first = false;
	}
  else
   { $r=explode(';',$fichier[$i],3);
     #echo "Catégorie $r[1] - $r[2]<br>"; 
	 $il++; 
	 $ligne_liste[$il]="<option value=$r[1]>$r[1] - $r[2]</option>";
   }
$i++;
}
$il++; $ligne_liste[$il]="</optgroup>";
$il++; $ligne_liste[$il]="</select>";

# afficher la liste à partir du tableau ligne-liste
function afficher_liste_categories($ligne_liste)
{ $nbl=count($ligne_liste);
  $il = 0;
  while($il<$nbl)
  { echo $ligne_liste[$il];
    $il++;
  }
}

#afficher_liste_categories($ligne_liste);

?>

    	<fieldset><legend><b>Vos plantes</b></legend>
            <?php
            echo "<table cols=4 width=700>";
			# En-tête du tableau
			echo "<tr>";
			echo "<td width=10></td>";
			echo "<td width=80 align=center>Catégorie</td>";
			echo "<td width=500>Nom</td>";
			echo "<td width=50 align=center>Pas AOS</td>";
			echo "</tr>";
			$maxp = 10;
			$tabnum = 4;
			for ($i = 1; $i <= $maxp; $i++) 
            { echo "<tr>";
              echo "<td align=center>$i</td>";
			  echo "<td>";
			  $tabnum++;
			  echo  "<select name='plantes[$i][catp]' tabindex=$tabnum>";
			  afficher_liste_categories($ligne_liste);
              echo "</td>";
    		  #echo "<td align=center><input type=text name='plantes[$i][catp]' size=4 tabindex=$tabnum /></td>";
			  $tabnum++;
    		  echo "<td align=left><input type=text name='plantes[$i][nomp]' size=70 tabindex=$tabnum /></td>";
			  $tabnum++;
    		  echo "<td align=center><input type=checkbox name='plantes[$i][pas_aos]' value='X' tabindex=$tabnum /></td>";
              echo "</tr>";
			}
			$tabnum++;
            echo "</table>";
		?>
    	</fieldset>
        <p></p>
        <?php 
    	 echo "<div align=center><input type=submit name=Valider value=Valider tabindex=$tabnum /></div>";
         echo "<div align=center>ou</div>";
		 $tabnum++;
         echo "<div align=center><input type=reset value='Réinitialiser le formulaire' tabindex=$tabnum /> </div>";
		?>
    </form>

</body>
</html>
