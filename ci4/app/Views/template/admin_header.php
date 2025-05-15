<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>

<body>
    <div id="container">
        <header>
            <h1><center>ADMIN PANEL</center></h1>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel'); ?>" class="active">Dashboard</a>
            <a href="<?= base_url('/artikel'); ?>">Artikel</a>
        </nav>

        <section id="wrapper">
            <section id="main">