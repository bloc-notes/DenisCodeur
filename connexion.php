<?php

$strModeTransmission = "post";
$strNomUtilisateur = "Non connecté"; //doit etre une variable de session
require_once "en-tete.php"; 

require_once './gestionTables.php';

$strIdNomUtil = "nomUtil";
$strIdPass = "pass";

if (post($strIdNomUtil) && post($strIdPass)) { // la pers a ecrit qqchose dans les deux inputs
    //ouverture de la BD
    $strMonIP = "";
    $strIPServeur = "";
    $strNomServeur = "";
    $strInfosSensibles = "";
    detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

    /* --- Initialisation des variables de travail --- */
    $strNomBD="pjf_microvox";
    $strLocalHost = "localhost";

    /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
    debug_to_console("TEST0");
    $BDProjetFinal = new mysql($strNomBD, $strInfosSensibles);
    debug_to_console("TEST1");
    $BDProjetFinal->connexion();
    debug_to_console("TEST2");
    
    $strTableUtilisateur = "Utilisateur";
    $strRequete = "nomUtil, pass";
    list($strBDUser, $strBDPass) = explode(",", $BDProjetFinal->retourneSelect($strTableUtilisateur, $strRequete));
    $BDProjetFinal->deconnexion();
    
    if (post($strIdNomUtil)==$strBDUser && post($strIdPass)==$strBDPass) {
        header("Location: identificationAdmin.php");
        exit();
    }
}
?>

<!--https://codepen.io/10tribu/pen/FzGdK-->
<div id="warp">
    <div class="admin">
      <div class="rota">
          <h1 class="h1Connexion">MICRO</h1>
          <input class="inputConnexion" id="<?php echo $strIdNomUtil; ?>" type="text" name="<?php echo $strIdNomUtil; ?>" maxlength="8" value="<?php echo post($strIdNomUtil); ?>" placeholder="Nom utilisateur" /><br />
        <input class="inputConnexion" id="<?php echo $strIdPass; ?>" type="password" name="<?php echo $strIdPass; ?>" maxlength="8" value="" placeholder="Mot de passe" />
      </div>
    </div>
    <div class="cms">
      <div class="roti">
        <h1 class="h1Connexion">VOX</h1>
        <button class="btnConnexion" id="connexion" type="submit" name="connexion">Connexion</button><br />
      </div>
    </div>
</div>

<?php
require_once "pied-page.php";
