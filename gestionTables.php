<?php

require_once './librairies-communes-2018-03-20-Doyon.php';
require_once './classe-mysql-2018-03-16.php';

function requeteExecutee($strMessage, $strRequeteExecutee, $strVerdict, $binLigne=false) {
      GLOBAL $sBleu, $sGras, $sRouge;
      echo "<p><span class=$sGras><span class=$sRouge>$strMessage</span><br />$strRequeteExecutee</span><br />=> <span class=$sBleu>$strVerdict</span></p>";
      echo $binLigne ? "<hr />" : "";
   }

$strMonIP = "";
   $strIPServeur = "";
   $strNomServeur = "";
   $strInfosSensibles = "";
   detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);
   //echo "$strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles";
   /* --- Initialisation des variables de travail --- */
   $strNomBD="pjf_microvox";
   $strLocalHost = "localhost";

   requeteExecutee("0. Récupération des informations sur le serveur", "$strMonIP => $strIPServeur ($strNomServeur)", "Nom du fichier 'infos-sensibles.php' : <span class=\"sGras\">$strInfosSensibles</span>");

   /* --- Création de l'instance, connexion avec mySQL et sélection de la base de données (RÉUSSITE) --- */
   $BDProjetFinal = new mysql($strNomBD, $strInfosSensibles);
   $strVerdict = $BDProjetFinal->cBD->stat;
   requeteExecutee("0. instanciation, connexion() et selectionneBD()", "mysqli_connect(\"localhost\", \$strNomAdmin, \$strMotPasseAdmin)", $strVerdict);
   
   /* --- Sélection de la base de données (RÉUSSITE) --- */
   /*$BDProjetFinal->selectionneBD();
   $strVerdict = "Sélection de la base de données <span class=\"sGras\">'$BDProjetFinal->nomBD'</span> " . ($BDProjetFinal->OK ? "confirmée" : "impossible");
   requeteExecutee("2. selectionneBD()", "mysqli_select_db(\$cBD, $BDProjetFinal->nomBD)", $strVerdict);
   poursuiteTraitement($BDProjetFinal->OK);*/
   
   /* --- Aux fins de la démonstration seulement, suppression des tables existantes */
   /*mysqli_query($BDProjetFinal->cBD, "DROP TABLE $strNomTable1");
   mysqli_query($BDProjetFinal->cBD, "DROP TABLE $strNomTable2");*/
   
   /* --- Création de la structure de la 1re table (RÉUSSITE) --- */
   for ($i=1; $i<7; $i++) {
       $strTable = "";
       
       switch ($i) {
           case 1: //table Utilisateur
               $strTable = "Utilisateur";
               $strContenu = "nomUtil varchar(25), "
                       . "motPasse varchar(15), "
                       . "satatuAdmin bit, "
                       . "nomComplet varchar(30), "
                       . "courriel varchar(50)";
               $strClefs = "constraint PK_nomUtil primary key(nomUtil)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
           case 2: //table Cours
               $strTable = "Cours";
               $strContenu = "sigleCours varchar(7), "
                       . "titre varchar(50), "
                       . "nomUtilCours varchar(50)";
               $strClefs = "constraint PK_sigleCours primary key(sigleCours), "
                       . "constraint FK_nomUtilCours foreign key(nomUtilCours) references Utilisateur(nomUtil)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
           case 3: //table Categorie
               $strTable = "Categorie";
               $strContenu = "categorie varchar(15)";
               $strClefs = "constraint PK_cat primary key(categorie)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
           case 4: //table Document
               $strTable = "Document";
               $strContenu = "sessionDoc varchar(6), "
                       . "sigleCoursDoc varchar(7), "
                       . "dateCours date, "
                       . "noSequence int, "
                       . "dateAccesDebut date, "
                       . "dateAccesFin date, "
                       . "titre varchar(100), "
                       . "description varchar(255), "
                       . "nbPages int, "
                       . "categorie varchar(15), "
                       . "noVersion int, "
                       . "dateVersion date, "
                       . "hyperLien varchar(255), "
                       . "ajoutePar varchar(25), "
                       . "suppressionFinale int";
               $strClefs = "constraint FK_sigleCoursDoc foreign key(sigleCoursDoc) references Cours(sigleCours), "
                       . "constraint FK_categorieDoc foreign key(categorie) references Categorie(categorie), "
                       . "constraint FK_nomUtilDoc foreign key(ajoutePar) references Utilisateur(nomUtil)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
           case 5: //table Session
               $strTable = "Session";
               $strContenu = "session varchar(6), "
                       . "dateDebut date, "
                       . "dateFin date";
               $strClefs = "constraint PK_session primary key(session)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
           case 6: //table CoursSession
               $strTable = "CoursSession";
               $strContenu = "sessionCoursSession varchar(6), "
                       . "sigleCoursCoursSession varchar(7), "
                       . "nomUtilCoursSession varchar(25)";
               $strClefs = "constraint FK_sessionCoursSession foreign key(sessionCoursSession) references Session(session), "
                       . "constraint FK_sigleCoursCoursSession foreign key(sigleCoursCoursSession) references Cours(sigleCours), "
                       . "constraint FK_nomUtilCoursSession foreign key(nomUtilCoursSession) references Utilisateur(nomUtil)";
               $BDProjetFinal->creeTableNormale($strTable, $strContenu, $strClefs);
               break;
       }
       
       $strVerdict = "Création de la table <span class=\"sGras\">'".$strTable."'</span> " . ($BDProjetFinal->OK ? "confirmée" : "impossible");
       requeteExecutee($i." creeTableNormale()", $BDProjetFinal->requete, $strVerdict);
       //echo '<br/>';
   }
   
   /*$strDefinitions = "V15,description";
                    /*"NbPieces". "DECIMAL(3,1)".
                    "Signature". "DATE".
                    "TypeBail". "CHAR(1)".
                    "Loyer". "DECIMAL(7,2)".
                    "Meuble". "BOOL".
                    "NoStationnement". "INT".
                    "NomLocataire". "VARCHAR(40)".
                    "PRIMARY KEY()"
   $strCles = "description";
   $BDProjetFinal->creeTableGenerique("Categorie", $strDefinitions, $strCles);
   $strVerdict = "Création de la table <span class=\"sGras\">'Categorie'</span> " . ($BDProjetFinal->OK ? "confirmée" : "impossible");
   requeteExecutee("6. creeTableGenerique()", $BDProjetFinal->requete, $strVerdict);*/
   
   

function poursuiteTraitement($binOK) {
      GLOBAL $sGrasRouge;
      if (!$binOK) {
         echo "<p class=$sGrasRouge>Le traitement ne peut se poursuivre...</p>";
?>
            </div>
      <div id="divPiedPage">
         <p class="sDroits">
            &copy; Département d'informatique G.-G.
         </p>
      </div>
</body>
</html>
<?php
         die();
      }
   }