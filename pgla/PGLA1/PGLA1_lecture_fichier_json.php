<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>la liste des MIAGE</title>
  <style>
    td{
      border-top:1px solid black;
      padding-top:5px;
    }
  </style>
</head>
  <body>
<?php
  echo "<br><h3>MIAGE</h3>\n";
  $jsonString = file_get_contents('MIAGE.json');
  $data = json_decode($jsonString, true);
  echo "<table>";
  echo "<tr><th>Nom</th><th> Formulaire</th></tr>";
  foreach($data as $i => $etu){
    $name = strtoupper($data[$i]['lastname']);
    $firstname = $data[$i]['firstname'];
    $email = $data[$i]['email'];
    echo "<tr>\n";
    echo "  <td> $name </td>";
    echo "  <td> <form method='GET' action='page2.php'>";
    echo "    <input type=\"hidden\" name=\"prenom\" value=\"".$firstname."\">";
    echo "    <input type=\"hidden\" name=\"nom\" value=\"".$name."\">";
    echo "    <input type=\"hidden\" name=\"email\" value=\"".$email."\">";
    echo "    <input type=\"hidden\" name=\"filiere\" value=\"MIAGE\">";
    echo "    <input type=\"submit\" value=\"Groupe Web\"></form>\n";
    echo "  </td>\n";
    echo "</tr>\n";
  }
  echo "</table>";
?>
  </body>
</html>
