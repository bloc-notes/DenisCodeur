<!DOCTYPE html>
<html>
<head>
    <title><?php echo $strTitreApplication; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo $strNomFichierCSS; ?>" />
    <script type="text/javascript">
        var intAncienneColonneSelectionne = 1;
        function soumettrePage(strNomPage, strNomForm) {
            var frm;
            frm = document.getElementById(strFormulaire);
            frm.action = strNomPageAction;
            frm.submit();
        }
        
        function soumettrePageEtat(intEtat,strNomPageDestination) {
            document.getElementById('hidEtat').value = intEtat;
            document.getElementById('hidIdElement').value = intAncienneColonneSelectionne;
            var frm;
            frm = document.getElementById('frmEtat');
            frm.action = strNomPageDestination;
            frm.submit();
        }
        
        
    </script>
</head>
<body class="sBeigeFont">
    <form id="frmSaisie" method="<?php echo $strModeTransmission;?>" action="">
        <header id="divEntete" class="sEntete">
            <p class="sTitreApplication sBeigePolice">
                <?php echo "$strTitreApplication\n"; ?>
                <span class="sContenuDroite sPolice15">
                    <label style="margin-right: 10px;">Bienvenue <?php echo $strNomUtilisateur;?></label>
                    <a id="aDeco" href="menu.php">Déconnexion</a>
                </span>  
            </p>
        </header>
<?php
session_start();