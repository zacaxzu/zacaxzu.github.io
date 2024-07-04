<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikacija za demose</title>

  <link rel="stylesheet" href="./css/login_html.css" />
  <link rel="stylesheet" href="./css/postanidemos_html.css" />
  <link rel="stylesheet" href="./css/registracija_html.css" />
  <link rel="stylesheet" href="./css/navigation-bar.css" />
  <link rel="stylesheet" href="./css/navigation-bar-postavke.css" />
  <link rel="stylesheet" href="./css/galerija_html.css" />
  <link rel="stylesheet" href="./css/rezervacije-prof_html.css" />
  <link rel="stylesheet" href="./css/novidemos_html.css" />
  <link rel="stylesheet" href="./css/opis-posla-public.css" />

  <?php
  if (isset($darkmode) && $darkmode === 0);
  else if ((isset($_COOKIE['mode']) && $_COOKIE['mode'] === '0') ||
    (isset($darkmode) && $darkmode === 1)
  ) {
    echo '<link rel="stylesheet" href="./css/darkmode.css" />';
  }

  if(!isset($_COOKIE['username']) || $_COOKIE['username']==='')
    echo '<link rel="stylesheet" href="./css/navigation-bar-login.css" />';
  ?>
  <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
</head>

<body>
