<?php
require_once "librairies-communes-2018-03-20-Doyon.php";

$strTitreApplication = "Microvox";
$strNomFichierCSS = "index.css";
$strModeTransmission = "post";

$strNomUtilisateur = "Louis-Marie Brousseau";

require_once "en-tete.php";
$intEtat = post("hidEtat");
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
<section class="sCentre">
    <header>
        <h2>
            Gestion des sessions d'étude
        </h2>
    </header>
    <article>
        <h3>
            Liste des sessions
        </h3>
        
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
?>        
<div class="sCentre">
    <p>
        Session d'étude
    </p>
    <p>
        Période dans l'année
    </p>
    <select id="ddlPeriodeAnnee" name="ddlPeriodeAnnee">
        <option value="A">Automne</option>
        <option value="E">Été</option>
        <option value="H">Hiver</option>
    </select>
    <p>
        Année de la session
    </p>
    <select id="ddlAnnee" name="ddlAnnee">
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
    </select>
    <label for="dtDebut">Date de début de la session</label>
    <input id="dtDebut" name="dtDebut" type="date" min="2018-01-01" max="2021-12-31"/>
    <label for="dtFin">Date de fin de la session</label>
    <input id="dtFin" name="dtfin" type="date" min="2018-01-01" max="2021-12-31"/>
    <button type="button" onclick="soumettrePageEtat(1,'majTableReference.php');"><?php echo $intEtat != 13 ? "Soumettre" : "Retirer";?></button>
    <button type="button" onclick="soumettrePageEtat(1,'majTableReference.php');">Annuler</button>
</div>    
<?php
        break;
    case 21:
    case 22:
    case 23:
?>
<div class="sCentre">
    <h3>
        Gestion des cours
    </h3>
    <h4>
        Sigle du cours
    </h4>
    <label for="rdTypeCoursStan">Cours standars</label>
    <input id="rdTypeCoursStan" name="rdTypeCours" type="radio" checked/>
    <label for="rdTypeCoursAdm">Cours administration</label>
    <input id="rdTypeCoursAdm" name="rdTypeCours" type="radio"/>
    <input id="tbSigleCourDebut" name="tbSigleCourDebut" type="text" max="3"/>
    <label for='tbSigleCourDebut'>-</label>
    <input id="tbSigleCourFin" name="tbSigleCourFin" type="text" max="3"/>
    <label for="ddlSigleAdm">ADM-</label>
    <select id="ddlSigleAdm" name="ddlSigleAdm">
        <option value="H18">H18</option>
    </select>
    <h4>
        Titre du cours
    </h4>
    <label for="tbNomCour">Nom du cours</label>
    <input id="tbNomCour" name="tbNomCour" type="text" max="50"/>
    <button type="button" onclick="soumettrePageEtat(2,'majTableReference.php');"><?php echo $intEtat != 23 ? "Soumettre" : "Retirer";?></button>
    <button type="button" onclick="soumettrePageEtat(2,'majTableReference.php');">Annuler</button>
</div>
<?php
        break;
    case 31:
    case 32:
    case 33:
?>
<div class="sCentre">
    <h3>
        Gestion des cours-session (<?php echo $strTypeAction;?>) 
    </h3>
    <h4>
        Session
    </h4>
    <select id="ddlSession" name="ddlSession">
        <option value="H-2018">H-2018</option>
    </select>
    <h4>
        Cours (Sigle)
    </h4>
    <select id="ddlCours" name="ddlCours">
        <option value="420-4W5">420-4W5</option>
    </select>
    <h4>
        Nom professeur(e)
    </h4>
    <select id="ddlNomProf" name="ddlNomProf">
        <option value="Brousseau Louis-Marie">Brousseau Louis-Marie</option>
    </select>
    <button type="button" onclick="soumettrePageEtat(3,'majTableReference.php');"><?php echo $intEtat != 33 ? "Soumettre" : "Retirer";?></button>
    <button type="button" onclick="soumettrePageEtat(3,'majTableReference.php');">Annuler</button>
    
</div>
<?php
        break;
    case 41;
    case 42:
    case 43:
?>
<div class="sCentre">
    <p>
        Nom de la catégorie
    </p>
    <input id="tbCategorie" name="tbCategorie" type="text" max="15"/>
    <button type="button" onclick="soumettrePageEtat(4,'majTableReference.php');"><?php echo $intEtat != 43 ? "Soumettre" : "Retirer";?></button>
    <button type="button" onclick="soumettrePageEtat(4,'majTableReference.php');">Annuler</button>
</div>
<?php
        break;
    case 51:
    case 52:
    case 53:
?>
<div class="sCentre">
    <p>
        Nom d'utilisateur
    </p>
    <input id="tbNomUtil" name="tbNomUtil" type="text" max="25"/>
    <p>
        Mot de passe
    </p>
    <input id="tbMDP" name="tbMDP" type="text" max="15"/>
    <input id="cbAffMDP" name="cbAffMDP" type="checkbox"/>
    <label for="cbAffMDP">Affiche le mot de passe</label>
    <input id="rbStatutUtilli" name="rbStatut" type="radio"/>
    <label for="rbStatutUtilli">Utilisateur</label>
    <input id="rbStatutAdmin" name="rbStatut" type="radio" checked/>
    <label for="rbStatutAdmin">Administrateur</label>
    <p>
        Nom complet
    </p>
    <input id="tbNomComplet" name="tbNomComplet" type="text" max="30"/>
    <p>
        Adresse de courriel
    </p>
    <input id="tbCourriel" name="tbCourriel" type="text" max="50"/>
    <button type="button" onclick="soumettrePageEtat(5,'majTableReference.php');"><?php echo $intEtat != 53 ? "Soumettre" : "Retirer";?></button>
    <button type="button" onclick="soumettrePageEtat(5,'majTableReference.php');">Annuler</button>
</div>
<?php
        break;
}

require_once "pied-page.php";
