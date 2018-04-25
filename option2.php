<?php
require_once "librairies-communes-2018-03-20-Doyon.php";
require_once "classe-mysql-2018-03-30-Doyon.php";
session_start();

//BD
/* Détermination du fichier "InfosSensibles" à utiliser */
$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

/* --- Initialisation des variables de travail --- */
$strNomBD = "pjf_microvox";
$strLocalHost = "localhost";

$strNomTableSession = "pf_session";
$strNomTableCours = "cours";
$strNomTableCoursSession = "courssession";
$strNomTableCategorie = "categorie";
$strNomTableDocument = "document";
$strNomTableUtilisateur = "utilisateur";

$BDProjetMicrovox = new mysql($strNomBD, $strInfosSensibles);

$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";
$intEtat = post("hidEtat");

if ($intEtat == null) {
    $intEtat = $_SESSION["etat"];
    if ($intEtat > 10) {
        
        switch ($intEtat) {
            case 11:
                $strCodeSession = post("ddlPeriodeAnnee") . "-" . gauche(post("ddlAnnee"),4);
                $strDebutSession = post("dtDebut");
                $strFinSession = post("dtFin");

                $BDProjetMicrovox->insereEnregistrement($strNomTableSession, $strCodeSession, $strDebutSession, $strFinSession);
                $intEtat = $_SESSION["etat"] = gauche($intEtat,1);
                break;
            case 12:
                $strCodeSession = post("ddlPeriodeAnnee") . "-" . gauche(post("ddlAnnee"),4);
                $strDebutSession = post("dtDebut");
                $strFinSession = post("dtFin");
                $BDProjetMicrovox->metAJourEnregistrements($strNomTableSession, "dateDebut='$strDebutSession', dateFin='$strFinSession'", "$strNomTableSession.session='$strCodeSession'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat,1);
                break;
            case 13:
                $strCodeSession = post("ddlPeriodeAnnee") . "-" . gauche(post("ddlAnnee"),4);
                
                $BDProjetMicrovox->supprimeEnregistrements($strNomTableSession, "$strNomTableSession.session='$strCodeSession'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
            case 21:
                $intTypeCours = post("rdTypeCours");
                $strSigle = ($intTypeCours == 1) ? post("tbSigleCourDebut") . "-" . post("tbSigleCourFin") : "ADM-" . post("ddlSigleAdm");
                $strNomCours = post("tbNomCour");
                
                $BDProjetMicrovox->insereEnregistrement($strNomTableCours, $strSigle, $strNomCours);
                
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 22:
                $strSigle = (post("tbSigleCourDebut") != "") ? post("tbSigleCourDebut") . "-" . post("tbSigleCourFin") : "ADM-" . post("ddlSigleAdm");
                $strNomCours = post("tbNomCour");
                
                $BDProjetMicrovox->metAJourEnregistrements($strNomTableCours, "titre='$strNomCours'","$strNomTableCours.sigleCours='$strSigle'");
                
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 23:
                $strSigle = (post("tbSigleCourDebut") != "") ? post("tbSigleCourDebut") . "-" . post("tbSigleCourFin") : "ADM-" . post("ddlSigleAdm");
                $BDProjetMicrovox->supprimeEnregistrements($strNomTableCours, "$strNomTableCours.sigleCours='$strSigle'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 31:
                $strSession = post("ddlSession");
                $strSigleCours = post("ddlCours");
                $strNomProf = post("ddlNomProf");
                
                $BDProjetMicrovox->insereEnregistrement($strNomTableCoursSession, $strSession, $strSigleCours, $strNomProf);
                
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 33:
                $strSession = post("ddlSession");
                $strSigleCours = post("ddlCours");
                
                $BDProjetMicrovox->supprimeEnregistrements($strNomTableCoursSession,"$strNomTableCoursSession.sessionCoursSession='$strSession' AND $strNomTableCoursSession.sigleCoursCoursSession='$strSigleCours'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 41:
                $strNomCategorie = post("tbCategorie");
                
                $BDProjetMicrovox->insereEnregistrement($strNomTableCategorie , $strNomCategorie);
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 42:
                $strNomCategorie = post("tbCategorie");
                $strNomCategorieAvant = post('hidCatAvant');
                $BDProjetMicrovox->metAJourEnregistrements($strNomTableCategorie, "$strNomTableCategorie.cat_nomCategorie='$strNomCategorie'", "$strNomTableCategorie.cat_nomCategorie='$strNomCategorieAvant'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 43:
                $strNomCategorie = post("tbCategorie");
                
                $BDProjetMicrovox->supprimeEnregistrements($strNomTableCategorie, "$strNomTableCategorie.cat_nomCategorie='$strNomCategorie'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 51:
                $strNomUtil = post("tbNomUtil");
                $strMDP = post("tbMDP");
                $byteStatut = post("rbStatut");
                $strNomComplet = post("tbNomComplet");
                $strAdresseCourriel = post("tbCourriel");
                
                $BDProjetMicrovox->insereEnregistrement($strNomTableUtilisateur, $strNomUtil, $strMDP, $byteStatut, $strNomComplet, $strAdresseCourriel);
                
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 52:
                $strNomUtil = post("tbNomUtil");
                $strMDP = post("tbMDP");
                $byteStatut = post("rbStatut");
                $strNomComplet = post("tbNomComplet");
                $strAdresseCouriell = post("tbCourriel");
                
                $BDProjetMicrovox->metAJourEnregistrements($strNomTableUtilisateur, "pass='$strMDP', statutAdmin=b'$byteStatut', nomComplet='$strNomComplet', courriel='$strAdresseCouriell'", "$strNomTableUtilisateur.nomUtil='$strNomUtil'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            case 53:
                $strNomUtil = post("tbNomUtil");
                
                $BDProjetMicrovox->supprimeEnregistrements($strNomTableUtilisateur, "nomUtil='$strNomUtil'");
                $intEtat = $_SESSION["etat"] = gauche($intEtat, 1);
                break;
            default :
                break;
        }

        if ($BDProjetMicrovox->OK != 1) {
            echo "<script type=\"text/javascript\">erreur();</script>";
        }
    }
}
else {
    $_SESSION["etat"] = $intEtat;
}
 
$strTypeAction = droite($intEtat, 1) == "1" ? "Ajouter" : (droite($intEtat, 1) == "2" ? "Modifier" : "Retirer");

switch ($intEtat) {
    case 0:
?>

<div class="sCentre">
    <h1>
        Mettre à jour les tables de références
    </h1>
    <ul class="sMenu">
        <li class="sOption">
            <a  onclick="soumettrePageEtat(1,'option2.php');">
                Gestion des sessions d'étude
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(2,'option2.php');">
                Gestion des cours
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(3,'option2.php');">
                Gestion des cours-sessions
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(4,'option2.php');">
                Gestion des catégories de document
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(5,'option2.php');">
                Gestion des utilisateurs
            </a>
        </li>
    </ul>
</div>

<?php
        break;
    case 1:
?>
<section class="sCentre sComprime35">
    <header>
        <h2>
            Gestion des sessions d'étude
        </h2>
    </header>
    <article>
        <h3>
            Liste des sessions
        </h3>
<?php
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
        $intNbElement = $BDProjetMicrovox->nbEnregistrements;
        
        if ($intNbElement == 0) {
?>
        <h4 style="color: red">Aucune session dans le système</h4>
<?php
        }
        else {
?>
        <table id='table'>
            <tr>
                <th>
                    Session d'étude
                </th>
                <th>
                    Date de début
                </th>
                <th>
                    Date de fin
                </th>
            </tr>
<?php       
            $tabEnregistrement = $BDProjetMicrovox->listeEnregistrements;
            while($listeEnregistrement = $tabEnregistrement->fetch_row()) {
?>
            <tr onclick="selectionDansTableau(this.rowIndex);">
                
<?php
                for ($i = 0; $i < count($listeEnregistrement); $i++) {
                             
?>
                <td>
                    <?php echo $listeEnregistrement[$i];?>
                </td>
<?php
                }
?>
            </tr>           
<?php
            }
?>
        </table>
<?php
        }
?>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(11,'option2.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(12,'option2.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(13,'option2.php');">Retirer</button>
    </footer>
</section>

<?php
        break;
    case 2:
?>
<section class="sCentre sComprime35">
    <header>
        <h2>
            Gestion des cours
        </h2>
    </header>
    <article>
        <h3>
            Liste des cours
        </h3>
<?php
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableCours);
        $intNbElement = $BDProjetMicrovox->nbEnregistrements;
        
        if ($intNbElement == 0) {
?>
        <h4 style="color: red">Aucune cours dans le système</h4>
<?php
        }
        else {
?>  
        <table id='table'>
            <tr>
                <th>
                    Sigle du cours
                </th>
                <th>
                    Titre du cours
                </th>
            </tr>
<?php       
            $tabEnregistrement = $BDProjetMicrovox->listeEnregistrements;
            while($listeEnregistrement = $tabEnregistrement->fetch_row()) {
?>
            <tr onclick="selectionDansTableau(this.rowIndex);">
                
<?php
                for ($i = 0; $i < count($listeEnregistrement); $i++) {
                             
?>
                <td>
                    <?php echo $listeEnregistrement[$i];?>
                </td>
<?php
                }
?>
            </tr>           
<?php
            }
?>
        </table>
<?php
        }    
?>        
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(21,'option2.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(22,'option2.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(23,'option2.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 3:
        ?>
<section class="sCentre sComprime35">
    <header>
        <h2>
            Gestion des cours-sessions
        </h2>
    </header>
    <article>
        <h3>
            Liste des cours-sessions
        </h3>
<?php
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableCoursSession);
        $intNbElement = $BDProjetMicrovox->nbEnregistrements;
        
        if ($intNbElement == 0) {
?>
        <h4 style="color: red">Aucune cours-session dans le système</h4>
<?php
        }
        else {
?>  
        <table id='table'>
            <tr>
                <th>
                    Session
                </th>
                <th>
                    Sigle du cours
                </th>
                <th>
                    Nom du professeur
                </th>
            </tr>
<?php       
            $tabEnregistrement = $BDProjetMicrovox->listeEnregistrements;
            while($listeEnregistrement = $tabEnregistrement->fetch_row()) {
?>
            <tr onclick="selectionDansTableau(this.rowIndex);">
                
<?php
                for ($i = 0; $i < count($listeEnregistrement); $i++) {
                             
?>
                <td>
                    <?php echo $listeEnregistrement[$i];?>
                </td>
<?php
                }
?>
            </tr>           
<?php
            }
?>
        </table>
<?php
        }    
?> 
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(31,'option2.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(33,'option2.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 4:
        ?>
<section class="sCentre">
    <header>
        <h2>
            Gestion des catégories de document
        </h2>
    </header>
    <article>
        <h3>
            Liste des catégories de document
        </h3>
<?php
        
        $intNbElement = $BDProjetMicrovox->selectionneEnregistrements($strNomTableCategorie);
        
        if ($intNbElement == 0) {
?>
        <h4 style="color: red">Aucune cours-session dans le système</h4>
<?php
        }
        else {
?>  
        <table id='table'>
            <tr>
                <th>
                    Nom des catégories
                </th>
            </tr>
            <?php       
            $tabEnregistrement = $BDProjetMicrovox->listeEnregistrements;
            while($listeEnregistrement = $tabEnregistrement->fetch_row()) {
?>
            <tr onclick="selectionDansTableau(this.rowIndex);">
                
<?php
                for ($i = 0; $i < count($listeEnregistrement); $i++) {
                             
?>
                <td>
                    <?php echo $listeEnregistrement[$i];?>
                </td>
<?php
                }
?>
            </tr>           
<?php
            }
?>
        </table>
<?php
        }    
?> 
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(41,'option2.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(42,'option2.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(43,'option2.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 5:
        ?>
<section class="sCentre sComprime30">
    <header>
        <h2>
            Gestion des utilisateurs
        </h2>
    </header>
    <article>
        <h3>
            Liste des utillisateurs
        </h3>
<?php
        
        $intNbElement = $BDProjetMicrovox->selectionneEnregistrements($strNomTableUtilisateur);
        
        if ($intNbElement == 0) {
?>
        <h4 style="color: red">Aucune utilisateur dans le système</h4>
<?php
        }
        else {
?>  
        <table id='table'>
            <tr>
                <th>
                    Nom d'utilisateur
                </th>
                <th>
                    Mot de passe
                </th>
                <th>
                    Statut
                </th>
                <th>
                    Nom complet
                </th>
                <th>
                    Adresse de courriel
                </th>
            </tr>
            <?php       
            $tabEnregistrement = $BDProjetMicrovox->listeEnregistrements;
            while($listeEnregistrement = $tabEnregistrement->fetch_row()) {
?>
            <tr onclick="selectionDansTableau(this.rowIndex);">
                
<?php
                for ($i = 0; $i < count($listeEnregistrement); $i++) {
                             
?>
                <td>
                    <?php echo $listeEnregistrement[$i];?>
                </td>
<?php
                }
?>
            </tr>           
<?php
            }
?>
        </table>
<?php
        }    
?> 
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(51,'option2.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(52,'option2.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(53,'option2.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 11:
    case 12:
    case 13:
        $strPeriode = "A";
        $strAnnee = 2018;
        $strDebutSession = "2018-01-01";
        $strFinSession = "2018-01-02";
        if ($intEtat != 11) {
            $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
            $strCodeSession = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1);
            $strDebutSession = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 1);
            $strFinSession = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1 , 2);
            
            $strPeriode = gauche($strCodeSession, 1);
            $strAnnee = droite($strCodeSession, 4);
        }
?>        
<section class="sCentre sComprime35">
    <header>
        <h3>Gestion des sessions d'étude (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <h4>
        Session d'étude
        </h4>
        <p class="sTextGauche">
            <label for='ddlPeriodeAnnee'>Période dans l'année</label>
            <select id="ddlPeriodeAnnee" name="ddlPeriodeAnnee">
                <option value="A">Automne</option>
                <option value="E">Été</option>
                <option value="H">Hiver</option>
            </select>
        </p>
        <p class="sTextGauche">
            <label for='ddlAnnee'>Année de la session</label>
            <select id="ddlAnnee" name="ddlAnnee" onchange="debutFinSession();">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
            </select>
        </p>
        <p class="sTextGauche">
            <label for="dtDebut">Date de début de la session</label>
            <input id="dtDebut" name="dtDebut" type="date" min="<?php echo $strAnnee;?>-01-01" max="<?php echo $strAnnee;?>-12-31" value="<?php echo $strDebutSession;?>"/>
        </p>
        <p class="sTextGauche">
            <label for="dtFin">Date de fin de la session</label>
            <input id="dtFin" name="dtFin" type="date" min="<?php echo $strAnnee;?>-01-01" max="<?php echo $strAnnee;?>-12-31" value="<?php echo $strFinSession;?>"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageElementInactif();"><?php echo $intEtat != 13 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(1,'option2.php');">Annuler</button>
    </footer>
</section>
<script type="text/javascript">
    document.getElementById('ddlPeriodeAnnee').value ='<?php echo $strPeriode;?>';
    document.getElementById('ddlAnnee').value = '<?php echo $strAnnee;?>';
<?php
        if ($intEtat > 11) {
?>
    document.getElementById('ddlPeriodeAnnee').disabled = true;
    document.getElementById('ddlAnnee').disabled = true;
<?php
        }
        
        if ($intEtat > 12) {
?>
    document.getElementById('dtDebut').disabled = true;
    document.getElementById('dtFin').disabled = true;
<?php  
        }
?>
</script>
<?php
        break;
    case 21:
    case 22:
    case 23:
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
        $tabSession = $BDProjetMicrovox->listeEnregistrements;
        $intNbSession = $BDProjetMicrovox->nbEnregistrements;
        
        $strSigleCours1 = "";
        $strSigleCours2 = "";
        $strSigleCoursADM = "";
        $strTitreCours = "";
        $booTypeCours = true;
        if ($intEtat != 21) {
            $BDProjetMicrovox->selectionneEnregistrements($strNomTableCours);
            $strSigleCours = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1);
            $strTitreCours = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 1);
            
            if (gauche($strSigleCours,3) == "ADM") {
                $booTypeCours = FALSE;
                $strSigleCoursADM = droite($strSigleCours, 3);
            }
            else {
                $strSigleCours1 = gauche($strSigleCours, 3);
                $strSigleCours2 = droite($strSigleCours, 3);
            }
        }
?>
<section class="sCentre sComprime30">
    <header>
        <h3>Gestion des cours (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <h4>
        Sigle du cours
        </h4>
        <p class="sTextGauche">
            <label for="rdTypeCoursStan">Cours standard</label>
            <input id="rdTypeCoursStan" name="rdTypeCours" type="radio" checked onchange="typeCours();" value="1"/>
            <input id="tbSigleCourDebut" name="tbSigleCourDebut" type="text" pattern=".{3,3}" title="3 à 3 charactères" style="width: 40px;" value="<?php echo $strSigleCours1;?>"/>
            <label for='tbSigleCourDebut'>-</label>
            <input id="tbSigleCourFin" name="tbSigleCourFin" type="text" pattern=".{3,3}" title="3 à 3 charactères" style="width: 40px;" value="<?php echo $strSigleCours2;?>"/>
        </p>
        <p class="sTextGauche">
            <label for="rdTypeCoursAdm">Cours administration</label>
            <input id="rdTypeCoursAdm" name="rdTypeCours" type="radio" onchange="typeCours();" value="2"/>
            <label for="ddlSigleAdm">ADM-</label>
            <select id="ddlSigleAdm" name="ddlSigleAdm">
<?php
        for ($i =0; $i < $intNbSession; $i++) {
            $strSession = $BDProjetMicrovox->mysqli_result($tabSession, $i, 0);
            $strCodeSession = gauche($strSession,1) . droite($strSession, 2);
            echo "<option value=\"" . $strCodeSession . "\">" . $strCodeSession . "</option>";
        }
?>
            </select>
        </p>
        <h4>
            Titre du cours
        </h4>
        <p class="sTextGauche">
            <label for="tbNomCour">Nom du cours</label>
            <input id="tbNomCour" name="tbNomCour" type="text" pattern=".{3,50}" title="3 à 50 charactères" style="width: 300px;" value="<?php echo $strTitreCours;?>"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageElementInactif();"><?php echo $intEtat != 23 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(2,'option2.php');">Annuler</button>
    </footer>
</section>
<script type="text/javascript">
    document.getElementById('ddlSigleAdm').value = '<?php echo $strSigleCoursADM;?>';
<?php
        if ($intEtat > 21) {
?>
    document.getElementById('rdTypeCoursAdm').checked = (document.getElementById('tbSigleCourDebut').value == '');
    document.getElementById('tbSigleCourDebut').readOnly = true;
    document.getElementById('tbSigleCourFin').readOnly = true;
    document.getElementById('ddlSigleAdm').disabled = true;
    document.getElementById('rdTypeCoursStan').disabled = true;
    document.getElementById('rdTypeCoursAdm').disabled = true;     
<?php
        }
        
        if ($intEtat > 22) {
?>
    document.getElementById('tbNomCour').readOnly = true;
<?php  
        }
?>
</script>
<?php
        break;
    case 31:
    case 33:
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
        $tabSession = $BDProjetMicrovox->listeEnregistrements;
        $intNbSession = $BDProjetMicrovox->nbEnregistrements;
        
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableCours);
        $tabCours = $BDProjetMicrovox->listeEnregistrements;
        $intNbCours = $BDProjetMicrovox->nbEnregistrements;
        
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableUtilisateur, "C=$strNomTableUtilisateur.statutAdmin='1'");
        $tabUtilisateurProf = $BDProjetMicrovox->listeEnregistrements;
        $intNbProf = $BDProjetMicrovox->nbEnregistrements;
        
        $strSession = "";
        $strCours = "";
        $strNomUtilisateur = "";
        if ($intEtat > 31) {
            $BDProjetMicrovox->selectionneEnregistrements($strNomTableCoursSession);
            $strSession = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1);
            $strCours = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 1);
            $strNomUtilisateur = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 2);
           
        }
?>
<section class="sCentre sComprime35">
    <header>
        <h3>Gestion des cours-session (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Session</span>
            <select id="ddlSession" name="ddlSession">
<?php
        for ($i =0; $i < $intNbSession; $i++) {
            $strCodeSession = $BDProjetMicrovox->mysqli_result($tabSession, $i, 0);
            echo "<option value=\"" . $strCodeSession . "\">" . $strCodeSession . "</option>";
        }
?>
            </select>
        </p>
        <p class="sTextGauche">
            <span>Cours (Sigle)</span>
            <select id="ddlCours" name="ddlCours">
<?php
        for ($i =0; $i < $intNbCours; $i++) {
            $strSigleCours = $BDProjetMicrovox->mysqli_result($tabCours, $i, 0);
            echo "<option value=\"" . $strSigleCours . "\">" . $strSigleCours . "</option>";
        }
?>
            </select>
        </p>
        <p class="sTextGauche">
            <span>Nom professeur(e)</span>
            <select id="ddlNomProf" name="ddlNomProf">
<?php
        for ($i =0; $i < $intNbProf; $i++) {
            $strNomProf = $BDProjetMicrovox->mysqli_result($tabUtilisateurProf, $i, 0);
            echo "<option value=\"" . $strNomProf . "\">" . $strNomProf . "</option>";
        }
?>
            </select>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageElementInactif();"><?php echo $intEtat != 33 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(3,'option2.php');">Annuler</button>
    </footer>   
</section>
<script type="text/javascript">
    document.getElementById('ddlSession').value = '<?php echo $strSession;?>';
    document.getElementById('ddlCours').value = '<?php echo $strCours;?>';
    document.getElementById('ddlNomProf').value = '<?php echo $strNomUtilisateur;?>';
    
<?php
        if ($intEtat == 33) {
?>
    document.getElementById('ddlSession').disabled = true;
    document.getElementById('ddlCours').disabled = true;
    document.getElementById('ddlNomProf').disabled = true;
<?php
        }
?>  
</script>
<?php
        break;
    case 41;
    case 42:
    case 43:
        $strCategorie="";
        if ($intEtat > 41) {
            $BDProjetMicrovox->selectionneEnregistrements($strNomTableCategorie);
            $strCategorie = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1);
        }
        
        //ValidityState.tooShort
?>
<section class="sCentre sComprime35">
    <header>
        <h3>Gestion des catégories de document (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Nom de la catégorie</span>
            <input id="tbCategorie" name="tbCategorie" type="text" pattern=".{3,15}" title="3 à 15 charactères" value="<?php echo $strCategorie;?>"/> 
            <input id="hidCatAvant" name="hidCatAvant" type="hidden" value="<?php echo $strCategorie;?>"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageElementInactif();"><?php echo $intEtat != 43 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(4,'option2.php');">Annuler</button>
    </footer>
</section>
<?php
        break;
    case 51:
    case 52:
    case 53:
        $strNomUtil = "";
        $strMDP = "";
        $byteStatut = 1;
        $strNomComplet = "";
        $strCourriel = "";
        if ($intEtat > 51) {
            $BDProjetMicrovox->selectionneEnregistrements($strNomTableUtilisateur);
            $strNomUtil = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1);
            $strMDP = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 1);
            $byteStatut = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 2);
            $strNomComplet = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 3);
            $strCourriel = $BDProjetMicrovox->mysqli_result($BDProjetMicrovox->listeEnregistrements, post("hidIdElement") - 1, 4);
        }
?>
<section class="sCentre sComprime30">
    <header>
        <h3>Gestion des utilisateurs (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Nom d'utilisateur</span>
            <input id="tbNomUtil" name="tbNomUtil" type="text" max="25" value="<?php echo $strNomUtil;?>"/>
        </p>
        <p class="sTextGauche">
            <span>Mot de passe</span>
            <input id="tbMDP" name="tbMDP" type="password" max="15" value="<?php echo $strMDP;?>"/>
            <input id="cbAffMDP" name="cbAffMDP" type="checkbox" onchange="voirMDP();"/>
            <label for="cbAffMDP">Affiche le mot de passe</label>
        </p>
        <p class="sTextGauche">
            <span>Statut</span>
            <input id="rbStatutUtilli" name="rbStatut" type="radio" value='0'/>
            <label for="rbStatutUtilli">Utilisateur</label>
            <input id="rbStatutAdmin" name="rbStatut" type="radio" checked value="1"/>
            <label for="rbStatutAdmin">Administrateur</label>
        </p>
        <p class="sTextGauche">
            <span>Nom complet</span>
            <input id="tbNomComplet" name="tbNomComplet" type="text" max="30" value="<?php echo $strNomComplet;?>"/>
        </p>
        <p class="sTextGauche">
            <span>Adresse de courriel</span>
            <input id="tbCourriel" name="tbCourriel" type="email" max="50" value="<?php echo $strCourriel;?>"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageElementInactif();"><?php echo $intEtat != 53 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(5,'option2.php');">Annuler</button>
    </footer>
</section>
<script type="text/javascript">    
<?php
        if ($intEtat > 51) {
?>
    document.getElementById('tbNomUtil').readOnly = true;
    document.getElementById('rbStatutUtilli').checked = (<?php echo $byteStatut;?> === 0);
<?php
        }
        
        if ($intEtat > 52) {
?>
    document.getElementById('tbMDP').readOnly = true;
    document.getElementById('tbNomComplet').readOnly = true;
    document.getElementById('tbCourriel').readOnly = true;
<?php
        }
?>  
</script>
<?php
        break;
}

require_once "pied-page.php";

?>
<script type="text/javascript">
    if (document.getElementById('table') != null) {
        selectionDansTableau(intAncienneColonneSelectionne);
    }
    
    function typeCours() {
        if (document.getElementById('rdTypeCoursStan').checked) {
            document.getElementById('tbSigleCourDebut').disabled = false;
            document.getElementById('tbSigleCourFin').disabled = false;
            document.getElementById('ddlSigleAdm').disabled = true;
        }
        else {
            document.getElementById('tbSigleCourDebut').disabled = true;
            document.getElementById('tbSigleCourFin').disabled = true;
            document.getElementById('ddlSigleAdm').disabled = false;
        }
    }
    
    function debutFinSession() {
        var intAnnee = document.getElementById('ddlAnnee').value;
        var dtCommencement = document.getElementById('dtDebut');
        var dtFinal = document.getElementById('dtFin');       
        
        dtCommencement.min = intAnnee + '-01-01';
        dtCommencement.max = intAnnee + '-12-30';
        dtCommencement.value = intAnnee + dtCommencement.value.substring(4);
         
        dtFinal.min = intAnnee + '-01-02';
        dtFinal.max = intAnnee + '-12-31';
        dtFinal.value = intAnnee + dtFinal.value.substring(4);
    }
    
    function selectionDansTableau(intLigne) {
        document.getElementById('table').rows[intAncienneColonneSelectionne].style = "background-color : #f1f1e7";
        document.getElementById('table').rows[intLigne].style = "background-color : white";
        
        intAncienneColonneSelectionne = intLigne;
    }
    
    function voirMDP() {
        if (document.getElementById('cbAffMDP').checked) {
            document.getElementById('tbMDP').type = "text";
        }
        else {
            document.getElementById('tbMDP').type = "password";
        }
    }
    
    
    
</script>
