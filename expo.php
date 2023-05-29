<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php require_once('_nav.php'); ?>
<?php require_once('barre2.php')

?>



<h1>bienvenue dans l'expo du momemnt</h1>
<?php

    require_once('functions.php');

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }

   

    $bdd = connect();

    $sql = "SELECT * FROM categories";

    $sth = $bdd->prepare($sql);
        
    $sth->execute();

    $categories = $sth->fetchAll();
?>

<style>
     h1 {
            text-align: center;
        }
   .container {
        overflow-x: scroll;
    }
   
    .carte {
        display: flex;
        flex-wrap: nowrap;
        padding: 10px;
    }
   
    .rectangle {
        flex: 0 0 auto;
        width: 300px; /* Adjust the width as per your requirements */
        height: 480px;
        background-color: rgb(204, 209, 209);
        list-style: none;
        border: 2px solid black;
        border-radius: 20px;
        margin-right: 10px; /* Add some margin between the rectangles */
        padding: 10px; /* Add padding for content within the rectangles */
    }
    .btn-link {
        position: relative;
    display: inline-block;
    padding: 10px 20px;
    color: #b79726;
    font-size: 16px;
    text-decoration: none;
    text-transform: uppercase;
    overflow: hidden;
    transition: 0.5s;
    margin-top: 40px;
    letter-spacing: 4px;
    background: transparent;
    border: 1px solid #b79726;
    cursor: pointer;
}

.btn-link:hover {
    background: #f49803;
    color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px #f4c803, 0 0 25px #bd9d0b, 0 0 50px #f4e403, 0 0 100px #d5cf1e;
}
</style>


<div class="container">
    <ul class="carte">
        <?php foreach($categories as $category) { ?>
            <div>
            <li class="rectangle" style="background-image: url('<?php echo $category['pic']; ?>'); background-size: cover;">

            <a href="expocat.php?id=<?php echo $category['id']; ?>" class="btn btn-blue btn-link"><?php echo $category['name']; ?></a>

                   

                        
                    </a>
                </li>
            </div>
        <?php } ?>
    </ul>
</div>


    <?php require_once('footer.php');?>
</body>
</html>