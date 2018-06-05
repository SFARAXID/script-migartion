<?php

fwrite($fp, " DROP TABLE IF EXISTS `" . $newTable . "`;\n");

$stmt = Connexion::query("SHOW CREATE TABLE " . $table);
$create = $stmt->fetch(PDO::FETCH_ASSOC);

fwrite($fp, str_replace(OLD_PREFIX, NEW_PREFIX, "{$create['Create Table']};\n\n"));