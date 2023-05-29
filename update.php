<?php
// Inclure le fichier
require_once "db_connect.php";
 
// Definir les variables
$prenom = $nom = $email = $adresse = $code_postale = $staut= "";
$prenom_err = $nom_err = $email_err =$adresse_err = $code_postale_err = $staut_err=  "";
 
// verifier la valeur id dans le post pour la mise à jour
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // recuperation du champ chaché
    $id = $_POST["id"];
    
    // Validate prenom
    $input_prenom = trim($_POST["prenom"]);
    if(empty($input_prenom)){
        $prenom_err = "Veillez entrez un prenom.";
    } elseif(!filter_var($input_prenom, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $prenom_err = "Veillez entrez a valid prenom.";
    } else{
        $prenom = $input_prenom;
    }
    
    // Validate nom
    $input_nom = trim($_POST["name"]);
    if(empty($input_nom)){
        $nom_err = "Veillez entrez un nom.";     
    } else{
        $nom = $input_nom;
    }

    // Validate adresse
    $input_adresse = trim($_POST["adresse"]);
    if(empty($input_adresse)){
        $adresse_err = "Veillez entrez une adresse.";     
    } else{
        $adresse = $input_adresse;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Veillez entrez un email.";     
    } else{
        $email = $input_email;
    }  

    // Validate code postale
    $input_code_postale = trim($_POST["code_postale"]);
    if(empty($input_code_postale)){
        $code_postale_err = "Veillez entrez un code postale.";     
    } else{
        $code_postale = $input_code_postale;
    }  
     

    // Validate code postale
    $input_statut = trim($_POST["statut"]);
    if(empty($input_statut)){
        $statut_err = "Veillez entrez un code postale.";     
    } else{
        $statut = $input_statut;
    }  
     
    
    // verifier les erreurs avant modification
    if(empty($prenom_err) && empty($nom_err) && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET prenom=?, name=?, email=?,code_postale=?,adresse=?,statut=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_prenom, $param_nom, $param_email, $param_adresse, $param_code_postale, $param_statut,$param_id);
            
            // Set parameters
            $param_prenom = $prenom;
            $param_nom = $nom;
            $param_email = $email;
            $param_adresse = $adresse;
            $param_code_postale = $code_postale;
            $param_statut = $statut;
            $param_id = $id;
            
            // executer
            if(mysqli_stmt_execute($stmt)){
                // enregistremnt modifié, retourne
                header("location: admin.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // si il existe un paramettre id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // recupere URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare la requete
        $sql = "SELECT * FROM users WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* recupere l'enregistremnt */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // recupere les champs
                    $prenom = $row["prenom"];
                    $nom = $row["name"];
                    $email = $row["email"];
                    $adresse = $row["adresse"];
                    $code_postale = $row["code_postale"];
                    $statut = $row["statut"];

                } else{
                    // pas de id parametter valid, retourne erreur
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // pas de id parametter valid, retourne erreur
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistremnt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Mise à jour de l'enregistremnt</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Prenom</label>
                            <input type="text" name="prenom" class="form-control <?php echo (!empty($prenom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prenom; ?>">
                            <span class="invalid-feedback"><?php echo $prenom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($nom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nom; ?>">
                            <span class="invalid-feedback"><?php echo $nom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <textarea readonly name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"><?php echo $email; ?></textarea>
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control <?php echo (!empty($adresse_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $adresse; ?>">
                            <span class="invalid-feedback"><?php echo $adresse_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Code Postale</label>
                            <input type="text" name="code_postale" class="form-control <?php echo (!empty($code_postale_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $code_postale; ?>">
                            <span class="invalid-feedback"><?php echo $code_postale_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Statut</label>
                            <input readonly type="text" name="statut" class="form-control <?php echo (!empty($statut_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $statut; ?>">
                            <span class="invalid-feedback"><?php echo $statut_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="admin.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>