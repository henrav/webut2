<?php
// logga ut
session_start();
session_destroy();
header("Location: ../index.php");