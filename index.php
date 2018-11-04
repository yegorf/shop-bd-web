<?php header('Content-Type: text/html; charset=utf-8');

include("DbHandler.php");

$dbHandler = new DbHandler();

echo "Выберете таблицу:</br>";
$dbHandler->showAllTables();
$dbHandler->addForm();
echo "</br>";
?>

</body>
</html>