<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enregistrement des plantes</title>
</head>		
<body>

<!-- Définition style pour bouton liste des classes -->
<!-- 
  background-image: -webkit-linear-gradient(top, #F6F6F6, #DDDDDD);
  background-image: -moz-linear-gradient(top, #F6F6F6, #DDDDDD);
  background-image: -ms-linear-gradient(top, #F6F6F6, #DDDDDD);
  background-image: -o-linear-gradient(top, #F6F6F6, #DDDDDD);
  background-image: linear-gradient(to bottom, #F6F6F6, #DDDDDD);    
  -webkit-border-radius: 1px;
  -moz-border-radius: 1px;
  background: #F6F6F6;
-->
<style type="text/css">
a.stylebouton {
  border-radius: 3px;
  border: solid thin #1C1C1C;
  text-shadow: none;
  background: #A9D0F5;
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

<h1>Enregistrement des plantes</h1>
<h2>1. Saisie du nom des plantes</h2>
    <form id="enregistrement" method="post" action="valider_liste_plantes.php">
    	<fieldset style='border:solid 2px #777777;'><legend><b>Vos coordonnées</b></legend>
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
# Lire fichier des classes de plantes
$ligne_liste = array("");
$fichier=file('./categories_plantes.txt');
$i=0;
$nb=count($fichier);
$first = true;
$il = 0;
$ligne_liste[$il] = "<option value='message_categorie'>Choisissez une classe...</option>";
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
?>

<?php
# fonction pour afficher la liste à partir du tableau ligne-liste
function afficher_liste_categories($ligne_liste)
{ $nbl=count($ligne_liste);
  $il = 0;
  while($il<$nbl)
  { echo $ligne_liste[$il];
    $il++;
  }
}
?>

<!-- Tableau du formulaire -->

<fieldset  style='border:solid 2px #777777;'><legend><b>Vos plantes</b></legend>
<?php
 echo "<table cols=4 width=700>";
 # En-tête du tableau
 echo "<tr>";
 echo "<td width=10></td>";
 echo "<td width=80 align=center><b>Classe</b></td>";
 echo "<td width=500><b>Nom</b></td>";
 echo "<td width=50 align=center><b>Pas AOS</b></td>";
 echo "</tr>";
 # Lignes du tableau
 $maxp = 15;
 $tabnum = 4;
 for ($i = 1; $i <= $maxp; $i++) 
 { echo "<tr>";
   echo "<td align=center>$i</td>";
   # Liste déroulante des classes
   echo "<td>";
   $tabnum++;
   echo  "<select name='plantes[$i][catp]' style='width:300px' tabindex=$tabnum>";
   afficher_liste_categories($ligne_liste);
   echo "</td>";
   #echo "<td align=center><input type=text name='plantes[$i][catp]' size=4 tabindex=$tabnum /></td>";
   # Nom de la plante
   $tabnum++;
   echo "<td align=left><input type=text name='plantes[$i][nomp]' size=70 width=600 tabindex=$tabnum /></td>";
   # Case à cocher si pas jugement AOS
   $tabnum++;
   echo "<td align=center><input type=checkbox name='plantes[$i][pas_aos]' value='X' tabindex=$tabnum /></td>";
   echo "</tr>";
 }
 $tabnum++;
 echo "</table>";
?>
</fieldset>
<p></p>
        
<!-- Les boutons en bas de la page -->
<?php 
 echo "<table cols=3>";
 echo "<tr>";
 echo "<td width=300><center><a class='stylebouton' href='./liste_classes.pdf' target='_blank'>Consulter la liste des classes</a></center></td>";
 echo "<td width=300><center><input type=submit name=Valider value=Valider style='background-color:#01DF01;color:black;border-radius:3px;border:solid thin #1C1C1C;' tabindex=$tabnum /></center></td>";
 $tabnum++;
 echo "<td width=300><center><input type=reset value='Réinitialiser le formulaire' style='background-color:#F7D358;color:black;border-radius:3px;border:solid thin #1C1C1C;' tabindex=$tabnum /></center></td>";
 echo "</tr>";
 echo "</table>";
?>

</form>

</body>
</html>
