<?php
$base = __DIR__;
 require_once("$base/model/autor.class.php");
 $autor=new Autor();
 $res=$autor->get(6554);
 /*Buscar un ID*/
 if ($res->correcta) {
    echo "<fieldset>";
    echo "<center><b>Buscar por ID</b></center>";
    foreach ($res->dades as $row){
        echo $row['id_aut']."-".$row['nom_aut']."-".$row["fk_nacionalitat"]."<br>"; 
    }
    echo "</fieldset>";
 } else {
     echo $res->missatge;
 }
 echo"<br>";
 /*Actualizar un Nombre de Autor dando el nuevo nombre y su ID*/
 $editar=$autor->update("Nuevo",6554);
 if ($editar->correcta) {
    echo "<fieldset>";
    echo "<center><b>Editar un Autor</b></center>";
    echo "Se ha realizado Correctamente";
    echo "</fieldset>";
 } else {
     echo $editar->missatge;
 }

echo "<br>";
 /*Mostrar todos*/
 $res=$autor->getAll();
 if ($res->correcta) {
echo "<table border=1><tr><td><b>ID Autor</b></td><td><b>Nom Autor</b></td><td><b>Nacionalitat</b></td> </tr>";
    foreach ($res->dades as $row){
        echo "<tr><td>".$row['id_aut']."</td><td>".$row['nom_aut']." </td><td> ".$row["fk_nacionalitat"]."</td></tr>";
    }
    echo "</table>";
 } else {
     echo $res->missatge;
 }

 $autor->insert(array("nom_aut"=>"Tomeu Campaner","fk_nacionalitat"=>"MURERA"));   //produira un error
 if (!$res->correcta) {
    echo "Error insertant";  // Error per l'usuari
    error_log($res->missatge,3,"$base/log/errors.log");  // Error per noltros
 }   




