<!DOCTYPE html>
<html>
<head>
    <title>Microvox</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css" />
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
        
        function soumettrePageElementInactif() {
            document.querySelectorAll('select').forEach(i => i.disabled = false);
            document.getElementById('frmSaisie').submit();
        }
        
        //https://stackoverflow.com/questions/14226803/javascript-wait-5-seconds-before-executing-next-line
        const attendre = (ms) => {
            return new Promise((tente) => {
                setTimeout(tente, ms);
            });
        };

        async function erreur() {
            await attendre(1000);
            alert('Action dans la Base de donnée impossible!');
        }
    </script>
</head>
<body class="sBeigeFont">
    <form id="frmSaisie" method="post" action="">
        <header id="divEntete" class="sEntete">
            <p class="sTitreApplication sBeigePolice">
                Microvox
                <span class="sContenuDroite sPolice15">
                    <label style="margin-right: 10px;"><?php echo ($strNomUtilisateur!="Non connecté") ? "Bienvenue ".$strNomUtilisateur : $strNomUtilisateur;?></label>
                    <a id="aDeco" href="connexion.php">Déconnexion</a>
                </span>  
            </p>
        </header>