<?php$denomination = null;$tvaIntracommunautaire = null;$trancheEffectif = null;$dateCreation = null;if (isset($_POST['submitSiret'])) {    $url = 'https://www.manageo.fr/entreprises/'. $_POST['siret'] . '.html';    $response = file_get_contents($url);    $dom = new DOMDocument();    libxml_use_internal_errors(true);    $dom->loadHTML($response);    $elementsTR = $dom->getElementsByTagName('tr');    $tableauTR = array();    foreach ($elementsTR as $elementTR) {        $tableauTR[] = $dom->saveHTML($elementTR);    }    function filtrerElementsParMot($tableau, $mot) {        $elementsFiltres = array_filter($tableau, function($element) use ($mot) {            return stripos($element, $mot) !== false;        });        return $elementsFiltres;    }    $denomination = str_replace('Dénomination','', filtrerElementsParMot($tableauTR, 'Dénomination'));    $tvaIntracommunautaire = str_replace('TVA intracommunautaire','', filtrerElementsParMot($tableauTR, 'TVA intracommunautaire'));    $trancheEffectif = str_replace('Tranche d\'effectif de l\'établissement','', filtrerElementsParMot($tableauTR, 'Tranche d\'effectif'));    $dateCreation = str_replace('Date de création de l\'établissement','', filtrerElementsParMot($tableauTR, 'Date de création de l\'établissement'));}?><!doctype html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport"          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">    <meta http-equiv="X-UA-Compatible" content="ie=edge">    <title>Vegea</title>    <style>        table {            border-collapse: collapse;            width: 100%;        }        td, th {            border: 1px solid #ddd;            text-align: left;            padding: 8px;        }    </style></head><body>    <form method="post">        <label for="siret">Siret number</label>        <input type="text" name="siret" placeholder="Enter the siret number">        <input type="submit" value="send" name="submitSiret">    </form>    <?php        if (isset($denomination) && isset($tvaIntracommunautaire) && isset($trancheEffectif) && isset($dateCreation)) {    ?>        <table>            <tr>                <th>Name</th>                <th>Value</th>            </tr>            <tr>                <td>Denomination</td>                <td><?= end($denomination) ?></td>            </tr>            <tr>                <td>TVA Intracommunautaire</td>                <td><?= end($tvaIntracommunautaire) ?></td>            </tr>            <tr>                <td>Tranche D'effectif</td>                <td><?= end($trancheEffectif) ?></td>            </tr>            <tr>                <td>Date de Creation</td>                <td><?= end($dateCreation) ?></td>            </tr>        </table>    <?php        }    ?></body></html>