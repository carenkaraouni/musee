<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=h, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php require_once('_expo.php'); ?>
<?php require_once('barre3.php'); ?>
<div style="text-align: center;">
  <h1>La boutique</h1>
  <h3>Voici les articles que vous retrouverez au magasin du musee</h3>
</div>

<div class="boutique">
    <div class="card">
    <img src="img/jocondequidab.jpg"/>
    <div class="intro">
        <h1>La Joconde 25£</h1>
    </div>
    </div>


    <div class="card">
    <img src="img/mug-la-nuit-etoilee-vincent-van-gogh-1889.jpg"/>
    <div class="intro">
        <h1>La Nuit etoile 6£</h1>
    </div>
    </div>
    </div>

<div class="boutique">
    <div class="card">
    <img src="img/oreiller.jpg"/>
    <div class="intro">
        <h1>Oreiller
            25£
        </h1>
    </div>
    </div>

    <div class="card">
    <img src="img/livre.jpg"/>
    <div class="intro">
        <h1>Livre Picasso 20£</h1>
    </div>
    </div>
    <div class="card">
    <img src="img/assiette.jpg"/>
    <div class="intro">
        <h1>Assiette Picasso 5£</h1>
    </div>
    </div>
    </div>
    </div>

    
    
    
</body>
</html>

<style>
    body{
        background-color: rgb(166, 172, 175);
    }
    /**{
        margin: 0px;
        padding: 0px;
        font-family: sans-serif;
    }*/

    img{
        height:250px;
        margin-left: 30px;
        margin-top:30px;
    }


</style>

<?php require_once('footer.php');?>
