<?php 
    require_once "librairies-communes-2018-03-16.php";
    
    session_start();
    
    $strIdNomUtilModifie = "nomUtilModifie";
    $strIdPassModifie = "passModifie";
    $strClassNomUtilModifie = "";
    $strClassPassModifie = "";
    
    $strFichierTxt = "donnees/secret.txt";
    
    if (post($strIdNomUtilModifie) && post($strIdPassModifie)) { // qqchose a ete ecris dans les deux inputs
        $fpPost = fopen($strFichierTxt, "w");
        fwrite($fpPost, post($strIdNomUtilModifie).";".post($strIdPassModifie));
        
        $_SESSION["blnConnexionPremiereFois"] = false;
        header("Location: premierDemarrage.php");
        exit();
    }
?>

<html>
    <head>
        <title>Identification Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <a id="identificationAdmin"></a>
        <form id="frmSaisie" method="post" action="">
            <table style="width:18.75%">
                <tr>
                    <td>
                        Nouveau nom utilisateur:
                    </td>
                    <td>
                        <input id="<?php echo $strIdNomUtilModifie; ?>" name="<?php echo $strIdNomUtilModifie; ?>" class="<?php echo $strClassNomUtilModifie; ?>" type="text" maxlength="8" value="<?php echo post($strIdNomUtilModifie); ?>"/><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        Nouveau mot de passe:
                    </td>
                    <td>
                        <!--https://www.w3schools.com/howto/howto_js_toggle_password.asp-->
                        <input id="<?php echo $strIdPassModifie; ?>" name="<?php echo $strIdPassModifie; ?>" class="<?php echo $strClassPassModifie; ?>" type="password" maxlength="8" value=""/><br/><br/>
                    </td>
                    <td>
                        <input type="checkbox" onclick="myFunction()"/>Voir le mot de passe
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td> 
                        <input id ="btnSoumettre" name="btnSoumettre" type="submit" class="" value="Connexion"/><br/><br/>
                    </td>
                </tr>
            </table>
        </form> 
        
        <script type="text/javascript">
            function myFunction() {
                var x = document.getElementById(<?php echo json_encode($strIdPassModifie); ?>);
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
    </body>
</html>
