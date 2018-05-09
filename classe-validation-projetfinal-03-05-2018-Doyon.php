<?php
require_once "librairies-communes-2018-05-04-Doyon.php";

class validation {

    public static function valid_nomUtilisateur($strNomUtil, $strNomCompet) {
        $booValide = false;
        
        if (genereNomUtilisateur($strNomCompet) === $strNomUtil) {
            $booValide = true;
        }
        
        return $booValide;
    }

    public static function valid_MDP($strDonnee) {
        $booValide = false;
        $strRegMDP = "/^[\w]{3,15}$/mu";

        if (preg_match($strRegMDP, $strDonnee)) {
            $booValide = true;
        }

        return $booValide;
    }

    public static function valid_NomComplet($strDonnee) {
        $booValide = false;
        $tabPrenomNom = explode(",", $strDonnee);
        $strNom = $tabPrenomNom[0];
        $strPrenom = trim($tabPrenomNom[1]);
        $strRegPrenomNom = "/^[\p{Lu}](([\'\- ][\p{Ll}])|[\p{Ll}])+$/mu"; //echo iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $string); http://stackoverflow.com/questions/10152894/php-replacing-special-characters-like-a-a-e-e?answertab=votes#tab-top

        if (preg_match($strRegPrenomNom, $strNom) && preg_match($strRegPrenomNom, $strPrenom) && preg_match("/, /", $strDonnee) && preg_match("/^.{5,30}$/m", $strDonnee)) {
            $booValide = true;
        }

        return $booValide;
    }

    public static function valid_Courriel($strDonnee) {
        $booValide = false;

        if (filter_var($strDonnee, FILTER_VALIDATE_EMAIL)) {
            $booValide = true;
        }

        return $booValide;
    }

}
