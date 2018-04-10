<!DOCTYPE html>
<html>
<head>
    <title>Microvox</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css" />
    <link rel="stylesheet" type="text/javascript" href="index.js" />
    <script type="text/javascript">
        function soumettrePage(strNomPage, strNomForm) {
            var frm;
            frm = document.getElementById(strFormulaire);
            frm.action = strNomPageAction;
            frm.submit();
        }
        
        function soumettrePageEtat(intEtat,strNomPageDestination) {
            document.getElementById('hidEtat').value = intEtat;
            var frm;
            frm = document.getElementById('frmEtat');
            frm.action = strNomPageDestination;
            frm.submit();
        }
    </script>
</head>
<body class="sBeigeFont bodyConnexion">
    <form id="frmSaisie" method="<?php echo $strModeTransmission;?>" action="">
        <header id="divEntete" class="sEntete">
            <p class="sTitreApplication sBeigePolice">
                Microvox
                <span class="sContenuDroite sPolice15">
                    <label style="margin-right: 10px;"><?php echo $strNomUtilisateur;?></label>
                    <a id="aDeco" href="connexion.php">Déconnexion</a>
                </span>  
            </p>
        </header>
<?php
session_start();

require_once 'classe-mysql-2018-03-16.php';
require_once 'librairies-communes-2018-03-16.php';