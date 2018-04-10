<?php
require_once "librairies-communes-2018-03-20-Doyon.php";
require_once "classe-mysql-2018-03-30-Doyon.php";

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

$strNomTableSession = "session";
$strNomTableCours = "cours";

$BDProjetMicrovox = new mysql($strNomBD, $strInfosSensibles);



$strTitreApplication = "Microvox";
$strNomFichierCSS = "index.css";
$strModeTransmission = "post";

$strNomUtilisateur = "Louis-Marie Brousseau";

require_once "en-tete.php";
$intEtat = post("hidEtat");

if ($intEtat == null) {
    echo "testttttttttttttttttttttt";
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
                
                //$BDProjetMicrovox->metAJourEnregistrements($strNomTable, $strListeChangements)
                
                break;
            case 21:
                $intTypeCours = post("rdTypeCours");
                $strSigle = ($intTypeCours == 1) ? post("tbSigleCourDebut") . "-" . post("tbSigleCourFin") : "ADM-" . post("ddlSigleAdm");
                $strNomCours = post("tbNomCour");
                
                $BDProjetMicrovox->insereEnregistrement($strNomTableCours, $strSigle, $strNomCours);
                
                $intEtat = $_SESSION = gauche($intEtat, 1);
                break;
            default :
                break;
        }
    }
}
else {
    $_SESSION["etat"] = $intEtat;
}

echo $intEtat;
 
$strTypeAction = droite($intEtat, 1) == "1" ? "Ajouter" : (droite($intEtat, 1) == "2" ? "Modifier" : "Retirer");

switch ($intEtat) {
    case 0:
?>

<div class="sCentre">
    <h1>
        Option disponible pour les tables de références
    </h1>
    <ul class="sMenu">
        <li class="sOption">
            <a  onclick="soumettrePageEtat(1,'majTableReference.php');">
                Gestion des sessions d'étude
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(2,'majTableReference.php');">
                Gestion des cours
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(3,'majTableReference.php');">
                Gestion des cours-sessions
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(4,'majTableReference.php');">
                Gestion des catégories de document
            </a>
        </li>
        <li class="sOption">
            <a onclick="soumettrePageEtat(5,'majTableReference.php');">
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
        <button type="button" onclick="soumettrePageEtat(11,'majTableReference.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(12,'majTableReference.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(13,'majTableReference.php');">Retirer</button>
    </footer>
</section>

<?php
        break;
    case 2:
?>
<section class="sCentre">
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
        <button type="button" onclick="soumettrePageEtat(21,'majTableReference.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(22,'majTableReference.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(23,'majTableReference.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 3:
        ?>
<section class="sCentre">
    <header>
        <h2>
            Gestion des cours-sessions
        </h2>
    </header>
    <article>
        <h3>
            Liste des cours-sessions
        </h3>
        
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(31,'majTableReference.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(32,'majTableReference.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(33,'majTableReference.php');">Retirer</button>
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
        
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(41,'majTableReference.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(42,'majTableReference.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(43,'majTableReference.php');">Retirer</button>
    </footer>
</section>
<?php
        break;
    case 5:
        ?>
<section class="sCentre">
    <header>
        <h2>
            Gestion des utilisateurs
        </h2>
    </header>
    <article>
        <h3>
            Liste des utillisateurs
        </h3>
        
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(51,'majTableReference.php');">Ajouter</button>
        <button type="button" onclick="soumettrePageEtat(52,'majTableReference.php');">Modifier</button>
        <button type="button" onclick="soumettrePageEtat(53,'majTableReference.php');">Retirer</button>
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
            <input id="dtDebut" name="dtDebut" type="date" min="2018-01-01" max="2018-12-31" value="<?php echo $strDebutSession;?>"/>
        </p>
        <p class="sTextGauche">
            <label for="dtFin">Date de fin de la session</label>
            <input id="dtFin" name="dtFin" type="date" min="2018-01-01" max="2018-12-31" value="<?php echo $strFinSession;?>"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="document.getElementById('frmSaisie').submit();"><?php echo $intEtat != 13 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(1,'majTableReference.php');">Annuler</button>
    </footer>
</section>
<script type="text/javascript">
    document.getElementById('ddlPeriodeAnnee').value ='<?php echo $strPeriode;?>';
    document.getElementById('ddlAnnee').value = '<?php echo $strAnnee;?>';
</script>
<?php
        break;
    case 21:
    case 22:
    case 23:
        $BDProjetMicrovox->selectionneEnregistrements($strNomTableSession);
        $tabSession = $BDProjetMicrovox->listeEnregistrements;
        $intNbSession = $BDProjetMicrovox->nbEnregistrements;
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
            <input id="tbSigleCourDebut" name="tbSigleCourDebut" type="text" maxlength="3" style="width: 40px;"/>
            <label for='tbSigleCourDebut'>-</label>
            <input id="tbSigleCourFin" name="tbSigleCourFin" type="text" maxlength="3" style="width: 40px;"/>
        </p>
        <p class="sTextGauche">
            <label for="rdTypeCoursAdm">Cours administration</label>
            <input id="rdTypeCoursAdm" name="rdTypeCours" type="radio" onchange="typeCours();" value="2"/>
            <label for="ddlSigleAdm">ADM-</label>
            <select id="ddlSigleAdm" name="ddlSigleAdm">
<?php
        for ($i =0; $i < $intNbSession; $i++) {
            $strSession = $BDProjetMicrovox->mysqli_result($tabSession, $i, 0);
            $strCodeSession = gauche($strSession,2) . droite($strSession, 2);
            echo "<option value=\"" . $strCodeSession . "\">" . $strCodeSession . "</option>";
        }
?>
                <option value="H40">H40</option>
            </select>
        </p>
        <h4>
            Titre du cours
        </h4>
        <p class="sTextGauche">
            <label for="tbNomCour">Nom du cours</label>
            <input id="tbNomCour" name="tbNomCour" type="text" maxlength="50" style="width: 300px;"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="document.getElementById('frmSaisie').submit();"><?php echo $intEtat != 23 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(2,'majTableReference.php');">Annuler</button>
    </footer>
</section>
<?php
        break;
    case 31:
    case 32:
    case 33:
?>
<section class="sCentre sComprime35">
    <header>
        <h3>Gestion des cours-session (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Session</span>
            <select id="ddlSession" name="ddlSession">
                <option value="H-2018">H-2018</option>
            </select>
        </p>
        <p class="sTextGauche">
            <span>Cours (Sigle)</span>
            <select id="ddlCours" name="ddlCours">
                <option value="420-4W5">420-4W5</option>
            </select>
        </p>
        <p class="sTextGauche">
            <span>Nom professeur(e)</span>
            <select id="ddlNomProf" name="ddlNomProf">
                <option value="Brousseau Louis-Marie">Brousseau Louis-Marie</option>
            </select>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(3,'majTableReference.php');"><?php echo $intEtat != 33 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(3,'majTableReference.php');">Annuler</button>
    </footer>   
</section>
<?php
        break;
    case 41;
    case 42:
    case 43:
?>
<section class="sCentre sComprime35">
    <header>
        <h3>Gestion des catégories de document (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Nom de la catégorie</span>
            <input id="tbCategorie" name="tbCategorie" type="text" max="15"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(4,'majTableReference.php');"><?php echo $intEtat != 43 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(4,'majTableReference.php');">Annuler</button>
    </footer>
</section>
<?php
        break;
    case 51:
    case 52:
    case 53:
?>
<section class="sCentre sComprime30">
    <header>
        <h3>Gestion des utilisateurs (<?php echo $strTypeAction;?>)</h3>
    </header>
    <article class="sCompact">
        <p class="sTextGauche">
            <span>Nom d'utilisateur</span>
            <input id="tbNomUtil" name="tbNomUtil" type="text" max="25"/>
        </p>
        <p class="sTextGauche">
            <span>Mot de passe</span>
            <input id="tbMDP" name="tbMDP" type="text" max="15"/>
            <input id="cbAffMDP" name="cbAffMDP" type="checkbox"/>
            <label for="cbAffMDP">Affiche le mot de passe</label>
        </p>
        <p class="sTextGauche">
            <span>Statut</span>
            <input id="rbStatutUtilli" name="rbStatut" type="radio"/>
            <label for="rbStatutUtilli">Utilisateur</label>
            <input id="rbStatutAdmin" name="rbStatut" type="radio" checked/>
            <label for="rbStatutAdmin">Administrateur</label>
        </p>
        <p class="sTextGauche">
            <span>Nom complet</span>
            <input id="tbNomComplet" name="tbNomComplet" type="text" max="30"/>
        </p>
        <p class="sTextGauche">
            <span>Adresse de courriel</span>
            <input id="tbCourriel" name="tbCourriel" type="text" max="50"/>
        </p>
    </article>
    <footer>
        <button type="button" onclick="soumettrePageEtat(5,'majTableReference.php');"><?php echo $intEtat != 53 ? "Soumettre" : "Retirer";?></button>
        <button type="button" onclick="soumettrePageEtat(5,'majTableReference.php');">Annuler</button>
    </footer>
</section>
<?php
        break;
}

require_once "pied-page.php";

?>
<script type="text/javascript">
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
        console.log(intLigne);
        
        document.getElementById('table').rows[intAncienneColonneSelectionne].style = "background-color : #f1f1e7";
        document.getElementById('table').rows[intLigne].style = "background-color : white";
        
        intAncienneColonneSelectionne = intLigne;
    }
    
    
</script>
