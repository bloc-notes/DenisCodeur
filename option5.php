<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";
require_once "classe-mysql-2018-03-30-Doyon.php";
require_once "librairies-communes-2018-03-20-Doyon.php";
require_once "classe-fichier-08-05-2018-Doyon.php";
$intDocsEffaces=0;
$strNomBD = "pjf_microvox";
$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
$BD = new mysql($strNomBD, $strInfosSensibles);
$strBtnRetour = "btnRetour";
$strBtnSuppr = "btnSupprimer";
$binSuppression = false;



if(isset($_POST['Action'])){
    if($_POST['Action']=='Supprimer'){
        if(isset($_POST['case'])){
        $binSuppression=true;
        
        
        }
    }
    elseif ($_POST['Action']=='Annuler') {
         header("Location: menuAdmin.php");
         exit();
    }
    elseif ($_POST['Action']=='Retour') {
         header("Location: menuAdmin.php");
         exit();
    }
}
?>
<script language="JavaScript">
function cochetout(source) {
  cases = document.getElementsByName('case');
  for(var i=0, n=cases.length;i<n;i++) {
    cases[i].checked = source.checked;
  }
}
function supprimer() {
  cases = document.getElementsByName('case');
  for(var i=0, n=cases.length;i<n;i++) {
    if(cases[i].checked){
	document.getElementById('etatDoc'+(i+1)).textContent="Supprimé";
	}
  }

}

function triTable(n) {
  var table, rangees, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tableDocPossiblementEffaces");
  switching = true;
  //Met la direction en ascendant
  dir = "asc"; 
  /*Crée une loop qui continue jusqu'à ce que aucun tri n'est fait:*/
  while (switching) {
    //commence en disant qu'aucun tri n'est fait:
    switching = false;
    rangees = table.getElementsByTagName("TR");
    /*Loop À travers toutes les rangées sauf les premières:*/
    for (i = 1; i < (rangees.length - 1); i++) {
      //commence en disant qu'il ne doit pas avoir de tri:
      shouldSwitch = false;
      /*Reçoit les 2 éléments à comparer :
       * Un de la première rangée, l'autre de la seconde*/
      x = rangees[i].getElementsByTagName("TD")[n];
      y = rangees[i + 1].getElementsByTagName("TD")[n];
      /*vérifie si les 2 colonnes doivent s'échanger de place:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //si oui
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //si oui:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rangees[i].parentNode.insertBefore(rangees[i + 1], rangees[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

</script>
<div id="Option 5" class="sComprime30 sCentre">
    <header>
        <h1>Arborescence des Documents</h1>
    </header>
<?php if($BD->selectionneEnregistrements("document","C=affichage=0")>0){
    if($binSuppression==false){?>
<div id="arboDocASupprimer">
    <form id="frmSaisie" method="post" action="">
    <table id="tableDocPossiblementEffaces">
        <tr>
        <th onclick="triTable(0)">#</th>
        <th onclick="triTable(1)">Session</th>
        <th>Sigle</th>
        <th onclick="triTable(3)">Professeur</th>
        <th>Date du cours</th>
        <th onclick="triTable(5)">Titre du document</th>
        <th><input type="checkbox" onClick="cochetout(this)" /></th>
        </tr>
        
        <?php
        $arrayUtilisateurs = [];
        for($i=0;$i<$BD->selectionneEnregistrements("utilisateur","C=statutAdmin=1");$i++){
            array_push($arrayUtilisateurs,$BD->contenuChamp($i, "nomUtil"));
        }        
        for($i=0;$i<$BD->selectionneEnregistrements("document","C=affichage=0","T=\"sessionDoc\", \"sigleCoursDoc\", \"titre\"");$i++){
        ?>
        <tr>
            <td><?php echo $i+1; ?></td>
            <td><?php echo $BD->contenuChamp($i, "sessionDoc"); ?></td>
            <td><?php echo $BD->contenuChamp($i, "sigleCoursDoc"); ?></td>
            <td><?php echo $BD->contenuChamp($i,"ajoutePar"); ?></td>
            <td><?php echo $BD->contenuChamp($i, "sigleCoursDoc"); ?></td>
            <td><?php echo $BD->contenuChamp($i, "titre"); ?></td>
            <td><input type="checkbox" name="case" value="<?php echo ($i+1); ?>"></td>
        </tr>
        <?php } ?>
    </table>
    <br/>
    <button id="Action" name="Action" type="submit" value="Supprimer" onclick='supprimer();'>Supprimer</button>
    <button id="Action" name="Action" type="button" value="Annuler" >Annuler</button>
</form>
    
</div>
<?php } else {
    var_dump($_POST);
    $intDocsEffaces = count($_POST['case']);
        
    
    ?>
<div id="docsEtatApresSuppression">
<table id="tableDocsApresTraitement">


        <tr>
        <th>#</th>
        <th>Session</th>
        <th>Sigle</th>
        <th>Professeur</th>
        <th>Date du cours</th>
        <th>Titre du document</th>
        <th>Verdict</th>
        </tr>
        <?php for($i=0;$i<$BD->selectionneEnregistrements("document","C=affichage=0","T=\"sessionDoc\", \"sigleCoursDoc\", \"titre\"");$i++){
        ?>
        <tr>
            <td><?php echo $i+1 ?></td>
            <td><?php echo $BD->contenuChamp($i, "sessionDoc") ?></td>
            <td><?php echo $BD->contenuChamp($i, "sigleCoursDoc"); ?></td>
            <td><?php echo $BD->contenuChamp($i,"ajoutePar"); ?></td>
            <td><?php echo $BD->contenuChamp($i, "sigleCoursDoc"); ?></td>
            <td><?php echo $BD->contenuChamp($i, "titre"); ?></td>
            
            <td><span id="<?php echo "etatDoc".($i+1) ?>"></span></td>
        </tr>
        <?php
        
        
        
        }
        $intDocsPreserves = $BD->selectionneEnregistrements("document","C=affichage=0","T=\"sessionDoc\", \"sigleCoursDoc\", \"titre\"");
        for($i=0;$i<count($_POST['case']);$i++){
            
            for($j=0;$j<$BD->selectionneEnregistrements("document","C=affichage=0","T=\"sessionDoc\", \"sigleCoursDoc\", \"titre\"");$j++){
            if($_POST['case'][$i] == $j+1){
               echo "<script> document.getElementById('etatDoc". ($j+1). "').textContent='Supprimé'; </script>";
               $BD->supprimeEnregistrements("document","titre='".$BD->contenuChamp($j, "titre").
                       "' AND sigleCoursDoc='".$BD->contenuChamp($j, "sigleCoursDoc").
                       "' AND sessionDoc='". $BD->contenuChamp($j, "sessionDoc")."'");
            }
            }
        }
        ?>
        
    </table>
</div>
<div id="Resultats">
    
    
    
    
    
    <table id="tableResultats">
          <?php
    //Effacer les documents orphelins
     
      
      
      $arDocs = array_slice(scandir('donnees/documents/'),2);
      
      
      $compteDocsAvant = count($arDocs);
      //Array docs dans sql
      $arrayDocSQL = [];
      $docsSupprimes = 0;
        for($i=0;$i<$BD->selectionneEnregistrements("document","T=\"hyperLien\"");$i++){
          array_push($arrayDocSQL,$BD->contenuChamp($i, "hyperLien"));
        }   
      
      
      ?>
     <th>No</th> 
     <th>Nom</th> 
     <th>Verdict</th>
     <?php for($i=0;$i<$compteDocsAvant;$i++){
         $fic = new fichier('donnees/documents/'.$arDocs[$i]);
         
         ?>
     <tr>
     <td><?php echo $i+1 ?></td>
     <td><?php echo $arDocs[$i]; ?></td>
     <td><?php if(!in_array($arDocs[$i],$arrayDocSQL)){ ?>
     Supprimé
     <?php
     $fic->supprime();
     $docsSupprimes++;
     } else{} ?>
     </td>
     
     </tr>
      <?php
     }
    //Effacer les documents orphelins ?>
    </table>
    Documents effacés:<?php echo $docsSupprimes ?>
    <br/>
    Documents conservés:<?php echo $compteDocsAvant - $docsSupprimes ?>
</div>
<?php } ?>
    
    <form method="post">
    <button id="Action" name="Action" type="submit" value="Retour" >Retour</button>
    </form> 
    
</div>

    <?php } else{ ?>
<h1>Il n'y a pas de documents à effacer</h1>
<?php } 

require_once "pied-page.php";

