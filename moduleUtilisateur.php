<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];
$strModeTransmission = "post";
require_once "en-tete.php";
?>
<script language="JavaScript">
   function triTable(n) {
  var table, rangees, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tableDocs");
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
<section class="sComprime12 sCentre">
    <header>
        <h1>Menu utilisateur</h1>
    </header>
    <article class="sCompact">
        <label for="ddlCours">Sélectionner un cours pour voir sa documentation</label>
    <select id="ddlCours" name="ddlCours" >
        <option value="420-6P6">420-4P6</option>
        <option value="420-2W4">420-2W4</option>
    </select>
        <p>
            <span>Sigle: 420-4P6</span>
            <span>Titre du cours: Programmation objet</span>
            <span>Session: H-2018</span>
            <span>Nom du professeur(e): Alain Loyer</span>
        </p>
    
    
    <table id="tableDocs">
        <tr>
            <th>
                Numéro du document
            </th>
            <th onclick="triTable(1)">
                Date du cours
            </th>
            <th>
                Numéro de séquence du document
            </th>
            <th  onclick="triTable(3)">
                Catégorie du document
            </th>
            <th onclick="triTable(4)">
                Titre du document
            </th>
            <th>
                Description du document
            </th>
            <th>
                Nombre de pages du document
            </th>
            <th>
                Date de dernière mise à jour
            </th>
            <th>
                Nombre de jours restants
            </th>
        </tr>
        <tr>
            <td>
                1
            </td>
            <td>
                01-01-2018 
            </td>
            <td>
                1
            </td>
            <td>
                Divers
            </td>
            <td>
                
                <a href="#">P</a>

            </td>
            <td>
               <a href="#">Fichiers à copier sur le lecteur P</a> 
            </td>
            <td>
                5
            </td>
            <td>
               03-01-2018 
            </td>
            <td>
              5  
            </td>    
        </tr>
         <tr>
            <td>
                2
            </td>
            <td>
                03-01-2018
            </td>
            <td>
                1
            </td>
            <td>
                Derp
            </td>
            <td>
                <a href="#">R</a>

            </td>
            <td>
               <a href="#">Fichiers à copier sur le lecteur R</a> 
            </td>
            <td>
                5
            </td>
            <td>
               05-01-2018
            </td>
            <td>
              5  
            </td>    
        </tr>
         <tr>
            <td>
                3
            </td>
            <td>
                27-01-2018 
            </td>
            <td>
                1
            </td>
            <td>
                Derp
            </td>
            <td>
                <a href="#">R</a>

            </td>
            <td>
               <a href="#">Fichiers à copier sur le lecteur R</a> 
            </td>
            <td>
                5
            </td>
            <td>
               01-02-2018 
            </td>
            <td>
              5  
            </td>    
        </tr>
    </table>
    </article>
    <footer>
        
    </footer>
        
</section>





<?php
require_once "pied-page.php";

