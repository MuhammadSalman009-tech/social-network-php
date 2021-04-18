<?php
session_start();
session_unset($_SESSION["userID"]);
session_unset($_SESSION["userName"]);
session_destroy();

header("Location:login.php");
?>