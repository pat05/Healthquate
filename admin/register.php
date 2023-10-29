<?php

include "../db_connect.php";
include "../crypt.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = encrypt($_POST['username']);
    $hashedPassword = encrypt(password_hash($_POST['password'], PASSWORD_BCRYPT));

    $stmt = $connection->prepare("INSERT INTO `admin` (`username`, `password`, `email`) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $email);
    $result = $stmt->execute();
    if ($result) {
        // Registration successful
        $msg = "Compte crée avec success. Veuillez-vous connecter";
        header('Location: register.php?msg=' . encrypt($msg));
    } else {
        // Registration failed
        $err = "Oups!! Une erreur c'est produite lors du traitement de votre demande";
        header('Location: register.php?err=' . encrypt($err));
    }

    $stmt->close();
    $connection->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
    <link rel="stylesheet" href="../index.css" />
    <title>CREATION DE COMPTE</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-left fs-3 mb-5">
        HEALTHQUATE
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3>CREATION DE COMPTE</h3>
        </div>
    </div>
    <div class="container d-flex justify-content-center">
        <form action="" method="post" class="form-contract">
            <?php
            if (isset($_GET['msg'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                 ' . decrypt($_GET['msg']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>';
            }
            if (isset($_GET['err'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . decrypt($_GET['err']) . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            }
            ?>
            <div class="row mb-3">
                <div class="col">
                    <label for="email" class="form-label">
                        Email:
                    </label>
                    <input id="email" type="email" class="form-control" name="email" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="username" class="form-label">
                        Username:
                    </label>
                    <input id="username" type="text" class="form-control" name="username" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">
                        Mot de passe:
                    </label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>
            <div class="row mb-2 m-1">
                <button type="submit" class="btn btn-success" name="submit">SE CONNECTER</button>
            </div>
            <div class="d-flex">Déjà de inscrit? <a href="login.php"> Connectez-vous</a></div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../index.js"></script>
</body>

</html>