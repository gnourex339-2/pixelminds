<?php
session_start();
session_destroy();
header('Location: ../ins_con/connexion.php');
exit();
?>