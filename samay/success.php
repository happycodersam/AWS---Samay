<?php require_once 'includes/bootstrap.php';if(!current_user()){header('Location: login.php');exit;}header('Location: account.php');exit;
