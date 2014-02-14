<?php

session_start();
session_destroy();

header('Location: ../index-build.php') ;

?>