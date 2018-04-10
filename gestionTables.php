<?php

require_once 'classe-mysql-2018-03-16.php';
require_once 'librairies-communes-2018-03-20-Doyon.php';

$strMonIP = "";
$strIPServeur = "";
$strNomServeur = "";
$strInfosSensibles = "";
detecteServeur($strMonIP, $strIPServeur, $strNomServeur, $strInfosSensibles);

/* --- Initialisation des variables de travail --- */
$strNomBD="pjf_microvox";
$strLocalHost = "localhost";

/* --- Création de l'instance, connexion avec mySQL et sélection de la base de données --- */
$BDProjetFinal = new mysql($strNomBD, $strInfosSensibles);

/* --- Création de la structure des tables --- */
$strTableUtilisateur = "Utilisateur";
$strTableCours = "Cours";
$strTableCategorie = "Categorie";
$strTableDocument = "Document";
$strTableSession = "Session";
$strTableCoursSession = "CoursSession";

//suppression des toutes les tables si elles existent
$BDProjetFinal->supprimeTable($strTableUtilisateur, $strTableCours, $strTableCategorie, $strTableDocument, $strTableSession, $strTableCoursSession);

//table Utilisateur
$strContenuUtilisateur = "nomUtil varchar(25), " //PK_nomUtil
        . "motPasse varchar(15) not null, "
        . "statutAdmin bit not null, "
        . "nomComplet varchar(30) not null, "
        . "courriel varchar(50) not null";
$strClefsUtilisateur = "constraint PK_nomUtil primary key(nomUtil)";
$BDProjetFinal->creeTableNormale($strTableUtilisateur, $strContenuUtilisateur, $strClefsUtilisateur);

//table Cours
$strContenuCours = "sigleCours varchar(7), " //PK_sigleCours
        . "titre varchar(50) not null, "
        . "nomUtilCours varchar(50) not null"; //FK_nomUtilCours
$strClefsCours = "constraint PK_sigleCours primary key(sigleCours), "
        . "constraint FK_nomUtilCours foreign key(nomUtilCours) references Utilisateur(nomUtil)";
$BDProjetFinal->creeTableNormale($strTableCours, $strContenuCours, $strClefsCours);

//table Categorie
$strContenuCategorie = "categorie varchar(15)";
$strClefsCategorie = "constraint PK_categorie primary key(categorie)";
$BDProjetFinal->creeTableNormale($strTableCategorie, $strContenuCategorie, $strClefsCategorie);

//table Document
$strContenuDocument = "sessionDoc varchar(6) not null, "
        . "sigleCoursDoc varchar(7) not null, " //FK_sigleCoursDoc
        . "dateCours date not null, "
        . "noSequence int not null, "
        . "dateAccesDebut date not null, "
        . "dateAccesFin date not null, "
        . "titre varchar(100) not null, "
        . "description varchar(255) not null, "
        . "nbPages int not null, "
        . "categorie varchar(15) not null, " //FK_categorieDoc
        . "noVersion int not null, "
        . "dateVersion date not null, "
        . "hyperLien varchar(255) not null, "
        . "ajoutePar varchar(25) not null, " //FK_nomUtilDoc
        . "suppressionFinale int not null";
$strClefsDocument = "constraint FK_sigleCoursDoc foreign key(sigleCoursDoc) references Cours(sigleCours), "
        . "constraint FK_categorieDoc foreign key(categorie) references Categorie(categorie), "
        . "constraint FK_nomUtilDoc foreign key(ajoutePar) references Utilisateur(nomUtil)";
$BDProjetFinal->creeTableNormale($strTableDocument, $strContenuDocument, $strClefsDocument);

//table Session
$strContenuSession = "session varchar(6), " //PK_session
        . "dateDebut date not null, "
        . "dateFin date not null";
$strClefsSession = "constraint PK_session primary key(session)";
$BDProjetFinal->creeTableNormale($strTableSession, $strContenuSession, $strClefsSession);

//table CoursSession
$strContenuCoursSession = "sessionCoursSession varchar(6) not null, " //FK_sessionCoursSession
        . "sigleCoursCoursSession varchar(7) not null, " //FK_sigleCoursCoursSession
        . "nomUtilCoursSession varchar(25) not null"; //FK_nomUtilCoursSession
$strClefsCoursSession = "constraint FK_sessionCoursSession foreign key(sessionCoursSession) references Session(session), "
        . "constraint FK_sigleCoursCoursSession foreign key(sigleCoursCoursSession) references Cours(sigleCours), "
        . "constraint FK_nomUtilCoursSession foreign key(nomUtilCoursSession) references Utilisateur(nomUtil)";
$BDProjetFinal->creeTableNormale($strTableCoursSession, $strContenuCoursSession, $strClefsCoursSession);

$strValuesNomUtil = "'admin', 'admin', 1, 'adminAdmin', 'admin@cgodin.qc.ca'";
$BDProjetFinal->insereDonnees($strTableUtilisateur, $strValuesNomUtil); //insertion initiale

/*$strRequeteUtilisateur = "nomUtil='admin'";
$BDProjetFinal->supprimeDonnees($strTableUtilisateur);*/

$BDProjetFinal->deconnexion(); //deconnexion de la BD