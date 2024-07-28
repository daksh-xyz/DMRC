<?php
session_start();
unset($_SESSION['AdminId']);
header("Location: ../index.php");