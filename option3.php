<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";

$strBtnRetour = "btnRetour";

if (isset($_POST[$strBtnRetour])) {
    header("Location: menuAdmin.php");
    exit();
}
?>

<section id="PrivilegeProf" class="sCentre sComprime35">
    <header>
        <h1>Assigner les privilèges d'accès au professeur</h1>
    </header>
    <article class="sCompact">
        <table>
        <tr>
        <th>Nom d'utilisateur /Cours session</th>
        <th>A-2017</th>
        <th>H-2018</th>
        <th>A-2018</th>
        </tr>
        <tr>
        <td class="sTextGauche">Lussier, Marc-Antoine</td>
        <td><input type="checkbox" name="cb1_1" value="cb1_1"></td>
        <td><input type="checkbox" name="cb1_2" value="cb1_2"></td>
        <td><input type="checkbox" name="cb1_3" value="cb1_3"></td>
        </tr>
        <tr>
        <td class="sTextGauche">Hassan Guelleh, Mohamed</td>
        <td><input type="checkbox" name="cb2_1" value="cb2_1"></td>
        <td><input type="checkbox" name="cb2_2" value="cb2_2"></td>
        <td><input type="checkbox" name="cb2_3" value="cb2_3"></td>
        </tr>
        <tr>
        <td class="sTextGauche">Doyon, Philippe</td>
        <td><input type="checkbox" name="cb3_1" value="cb3_1"></td>
        <td><input type="checkbox" name="cb3_2" value="cb3_2"></td>
        <td><input type="checkbox" name="cb3_3" value="cb3_3"></td>
        </tr>
        </table>
    </article>
    <footer>
        <button type="submit" value="Enregistrement">Enregistrement</button>
        <button id="<?php echo $strBtnRetour; ?>" type="submit" name="<?php echo $strBtnRetour; ?>">Retour</button>
    </footer>
</section>

<?php
require_once "pied-page.php";