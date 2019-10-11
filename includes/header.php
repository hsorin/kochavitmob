<?php ob_start(); ?>
<?php if(!isset($_SESSION)){
    session_start(); }?>
<?php include "db.php"; ?>
<?php include ('functions.php'); ?>

<!DOCTYPE html>
<html lang="he">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="description" content="Extension for Kochavit">
    <meta name="author" content="Sorin">

        <!-- jQuery -->
<!--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--    <script src="/kochavitmob/js/myjquery.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!--
    <script src="/kochavitmob/js/jquery-ui/external/jquery/jquery.js"></script>
    <script src="/kochavitmob/js/jquery-ui/jquery-ui.min.js"></script>
-->
    <script src="/kochavitmob/js/jquery-ui/datepicker-he.js"></script>
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>-->
<!--
    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        
-->
    <!-- Bootstrap 4.1.3 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!--
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
-->
    
     <!-- Custom CSS -->
    <link rel="stylesheet" href="/kochavitmob/js/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="/kochavitmob/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="/kochavitmob/css/styles.css">

    <title>כוכבית</title>
</head>
<body>
