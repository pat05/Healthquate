<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to the login page
    exit();
} else {
    include "../db_connect.php";
    include "../send_email.php";
    include "../crypt.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['contrat_id'];
        $prix = encrypt($_POST['price']);

        $stmt = $connection->prepare("UPDATE contrat SET prix=? WHERE id=?");
        $stmt->bind_param('si', $prix, $id);

        if ($stmt->execute()) {
            $stmt = $connection->prepare("SELECT id, nom, prenom, email FROM contrat WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $nom, $prenom, $email);

            if ($stmt->num_rows == 1 && $stmt->fetch()) {
                $msg = "Prix du contrat mis à jour avec success";
                header('Location: index.php?msg=' . encrypt($msg));
                // send mail 
                $subject = "Réponse à la demande de Contrat";
                $message = 'Bonjour, suite à votre récente demande de contrat, apres examination ' .
                    'de votre dossier le prix fixé est de ' . $_POST['price'] . ' euros';
                sendMail(decrypt($email), decrypt($nom) . ' ' . decrypt($prenom), $subject, $message);
            }
        } else {
            // echo "Error updating contract: " . $connection->error;
            $msg = "Oups!! Une erreur c'est produite lors du traitement de votre demande";
            header('Location: index.php?err=' . encrypt($msg));
        }

        $connection->close();
    }
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
    <title>ADMIN PAGE</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-left fs-3 mb-5">
        HEALTHQUATE
        <h5>
            <a href="logout.php" class="link-underline-light">Logout</a>
        </h5>
    </nav>

    <div class="container">
        <div class="text-left mb-4">
            <h3>Listes des demandes de contrat</h3>
        </div>
    </div>
    <div class="container">
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
        <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Poids</th>
                    <th scope="col">Taille</th>
                    <th scope="col">Ville</th>
                    <th scope="col">Zip</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `contrat`";
                $result = mysqli_query($connection, $sql);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $row['id'] ?></th>
                            <td><?php echo decrypt($row['nom']) ?></td>
                            <td><?php echo decrypt($row['prenom']) ?></td>
                            <td><?php echo decrypt($row['email']) ?></td>
                            <td><?php echo decrypt($row['poids']) ?></td>
                            <td><?php echo decrypt($row['taille']) ?></td>
                            <td><?php echo decrypt($row['ville']) ?></td>
                            <td><?php echo decrypt($row['zip']) ?></td>
                            <td><?php echo decrypt($row['prix']) ?></td>
                            <td>
                                <button class="btn edit-btn" data-id="<?= $row['id'] ?>">
                                    <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>
                                </button>
                            </td>
                        </tr>
                <?php }
                }
                $connection->close();
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../index.js"></script>
</body>

</html>