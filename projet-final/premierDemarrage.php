<?php
    require_once "librairies-communes-2018-03-16.php";
    
    session_start();
    if (!isset($_SESSION["blnConnexionPremiereFois"])) {
        $_SESSION["blnConnexionPremiereFois"] = true; 
    }
    
    $strIdNomUtil = "nomUtil";
    $strIdPass = "pass";
    $strClassNomUtil = "";
    $strClassPass = "";
    
    $strFichierTxt = "donnees/secret.txt";
    
    //$strCookie = "cookie";
    $strErreur = "";
    
    // maybe try this http://unbouncepages.com/already-submitted/# 
    // or https://stackoverflow.com/questions/1126350/open-a-new-html-page-through-php
    
    //if (isset($_COOKIE[$strCookie])) { // pour savoir si qqchose a ete envoye pour la 1ere fois
        if (post($strIdNomUtil) && post($strIdPass)) { // la pers a ecrit qqchose dans les deux inputs
            $fpSecret = fopen($strFichierTxt, "r");
            list($nomUtilTxt, $passTxt) = explode(";", str_replace("\n", "", str_replace("\r", "", fgets($fpSecret))));
            
            if ($_SESSION["blnConnexionPremiereFois"] && post($strIdNomUtil)==$nomUtilTxt && post($strIdPass)==$passTxt) { // connexion 1ere fois et match
                header("Location: identificationAdmin.php");
                exit();
            }
            else if (!$_SESSION["blnConnexionPremiereFois"] && post($strIdNomUtil)==$nomUtilTxt && post($strIdPass)==$passTxt) { // pas la 1ere connexion et match
                $strErreur = "Menu principal de l'administrateur";
            }
            else { // erreur, pas de match pour le nomUtil ou le pass
                $strErreur = "Nom d'utilisateur ou mot de passe invalide!";
            }
        }
        
        /*if (post("nomUtil")) { // la pers a ecrit qqchose dans la balise input nomUtil
            $strErreur = "Veillez entrer votre mot de passe!";
        }
        else if (post("pass")) { // la pers a ecrit qqchose dans la balise input pass
            $strErreur = "Veillez entrer votre nom d'utilisateur!";
        }
        else { // la pers n'a rien ecrit
            $strErreur = "Veillez entrer votre nom d'utilisateur et votre mot de passe!";
        }
    }
    else { // marche but meh
        setcookie($strCookie, "123", time() + (60*60*24*30*12)); // cookie pour 1 an
    }*/
?>

<html>
    <head>
        <title>Premier Démarrage</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <a id="premierDemarrage"></a>
        <form id="frmSaisie" method="post" action="">
            <table style="width:18.75%">
                <tr>
                    <td>
                        Nom utilisateur:
                    </td>
                    <td>
                        <input id="<?php echo $strIdNomUtil; ?>" name="<?php echo $strIdNomUtil; ?>" class="<?php echo $strClassNomUtil; ?>" type="text" maxlength="8" value="<?php echo post($strIdNomUtil); ?>"/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Mot de passe:
                    </td>
                    <td>
                        <input id="<?php echo $strIdPass; ?>" name="<?php echo $strIdPass; ?>" class="<?php echo $strClassPass; ?>" type="password" maxlength="8" value=""/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td> 
                        <input id ="btnSoumettre" name="btnSoumettre" type="submit" class="" value="Connexion"/><br/><br/>
                    </td>
                </tr>
            </table>
            
            <?php 
                //echo (($_SESSION["blnConnexionPremiereFois"]) ? "true" : "false")."<br/>";
                echo $strErreur;
            ?>
        </form> 
    </body>
</html>