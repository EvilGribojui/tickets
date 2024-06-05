<?php
$dsn= "pgsql:host=localhost;dbname=tickets";

try 
{
    $pdo =new PDO ($dsn, "postgres","");
    echo "Ну здорово, отец!"."\n";
}
catch(PDOException $e) 
{
    die("Подключение не удалось :-(."."\n".$e->getMessage());
}
?>