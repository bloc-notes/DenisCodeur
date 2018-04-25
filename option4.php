<?php
session_start();
$strNomUtilisateur = $_SESSION["nomComplet"];

require_once "en-tete.php";

?>

<section class="sCentre sComprime12">
    <header>
        <h1>Assigner un groupe d'utilisateurs à un cours-session</h1>
    </header>
    <article class="sCompact">
        <p>
            <label for="tbFichierCSV">Nom du fichier CSV</label>
            <input id="tbFichierCSV" name="tbFichierCSV" type="text" />
            <button id="btnEnvoyeCSV" name="btnEnvoyeCSV" type="button"  onclick="fichierRecu();">Envoyer</button>
        </p>
        <table id="tabCacher" class="sCacher">
            <tr>
                <th>
                    Nom d'utilisateur
                </th>
                <th>
                    Mot de passe
                </th>
                <th>
                    Nom complet
                </th>
                <th>
                    Courriel
                </th>
                <th>
                    Sigle 1
                </th>
                <th>
                    Sigle 2
                </th>
                <th>
                    Sigle 3
                </th>
                <th>
                    Sigle 4
                </th>
                <th>
                    Sigle 5
                </th>
                <th>
                    Verdict
                </th>
            </tr>
            <tr>
                <td>
                    n,laliberte
                </td>
                <td>
                    Secret12345
                </td>
                <td>
                    Laliberté, Nicole
                </td>
                <td>
                    nico.laliberte@gmail.com
                </td>
                <td>
                    420-4w5
                </td>
                <td>
                    ADM-H18
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    OK
                </td>
            </tr>
            <tr>
                <td>
                    p.légende
                </td>
                <td>
                    12345
                </td>
                <td>
                    Légende, Paul
                </td>
                <td>

                </td>
                <td>
                    ADM-H18
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    OK
                </td>
            </tr>
            <tr>
                <td>
                    k.bonneau
                </td>
                <td>
                    Secret123
                </td>
                <td>
                    Bonneau, Karine
                </td>
                <td>
                    k.bonneau@hotmail.com
                </td>
                <td>
                    ADM-H18
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    OK
                </td>
            </tr>
            <tr>
                <td>
                    a.caron
                </td>
                <td>
                    SecretIZE
                </td>
                <td>
                    Caron, André
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>
                    OK
                </td>
            </tr>
            <tr id='ligneErreur1'>
                <td class="sErreurTableau">
                    pfafard
                </td>
                <td class="sErreurTableau">
                    12
                </td>
                <td class="sErreurTableau">
                    Fafard,Pierre
                </td>
                <td class="sErreurTableau">
                    a@a
                </td>
                <td class="sErreurTableau">
                    ABS-BAG
                </td>
                <td class="sErreurTableau">
                    WD-40
                </td>
                <td class="sErreurTableau">
                    420-5W6
                </td>
                <td class="sErreurTableau">
                    420-5W6
                </td>
                <td>
                    420-6B6
                </td>
                <td>
                    Pas OK
                </td>
            </tr>
            <tr id='ligneErreur2' class="sCacher">
                <td>
                    p.fafard
                </td>
                <td>
                    Secret12
                </td>
                <td>
                    Fafard, Pierre
                </td>
                <td>
                    p.fafard@gamil.com
                </td>
                <td id="tdErreurSession">
                    420-6B6
                </td>
                <td id="tdDeplace">
                    420-4W5
                </td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td id="tdVerdict">
                    Pas OK
                </td>
            </tr>
        </table>
        <p id="pListeSession" class="sCacher">
            <label for="ddlSession">Liste des sessions</label>
            <select id="ddlSession" name="ddlSession" onchange="listeSessionEvenement();">
                <option value="H-2018">H-2018</option>
                <option value="H-2019">H-2019</option>
            </select>
        </p>
        
        <p id="pConfirmation" class="sCacher">
            <span>Voulez-vous vraiment assigner les privilèges?</span>
            <button id="btnConfirmation" name="btnConfirmation" type="button" onclick="confirmer();">Confirmer</button>
        </p> 
    </article>
    <footer id="piedPageCacher" class="sCacher">
        <button id="btnTriche1" name="btnTriche1" type="button" onclick="triche1();">Triche1</button>
        <button id="btnTriche2" name="btnTriche2" type="button" onclick='triche2();'>Triche2</button>
    </footer>
</section>
<script type="text/javascript">
    function triche1() {
        document.getElementById('ligneErreur1').classList.add('sCacher');
        document.getElementById('ligneErreur2').classList.remove('sCacher');
        document.getElementById('pListeSession').classList.remove('sCacher');
        
        document.getElementById('ddlSession').value = "";
    }
    
    function triche2() {
        document.getElementById('tdErreurSession').classList.remove('sErreurTableau');
        document.getElementById('tdErreurSession').value = "420-5W5";
        document.getElementById('tdDeplace').value = "";
        document.getElementById('tdVerdict').value = "OK";
        
        document.getElementById('pConfirmation').classList.remove('sCacher');
    }
    
    function fichierRecu() {
        document.getElementById('tabCacher').classList.remove('sCacher');
        document.getElementById('piedPageCacher').classList.remove('sCacher');
        
        erreur2();
    }
    
    function listeSessionEvenement() {
        document.getElementById('tdErreurSession').classList.add('sErreurTableau');
        
        erreur2();
    }
    
    //https://stackoverflow.com/questions/14226803/javascript-wait-5-seconds-before-executing-next-line
    const attendre2 = (ms) => {
        return new Promise((tente) => {
            setTimeout(tente, ms);
        });
    };
    
    function confirmer() {
        alert('Les privilèges ont été apliqués.');
        window.location.href = "option3.php";
    }
    
    async function erreur2() {
        await attendre2(1000);
        alert('Une erreur est détecté. Vous pouvez [1] corriger les données dans le fichier excel, [2] saisir une nouvelle session et/ou [3] définir un nouveau cours-session.');
    }
</script>


<?php
require_once "pied-page.php";

