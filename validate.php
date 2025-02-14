<?php
  session_start();
  if (!$_SESSION['signed_in']) {
    $_SESSION['error'] = "Sign in to continue";
    header("Location: ../index.php");
    exit; 
  }
?>
