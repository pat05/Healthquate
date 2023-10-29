<?php

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to the login page
    exit();
} else {
    include "../db_connect.php";
    include "../crypt.php";
    include "../get_price.php";

    if (isset($_GET['id'])) {
        $contractId = $_GET['id'];

        $stmt = $connection->prepare("SELECT id, nom, prenom, email, poids, taille FROM contrat WHERE id = ?");
        $stmt->bind_param('i', $contractId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nom, $prenom, $email, $poids, $taille);

        if ($stmt->num_rows == 1 && $stmt->fetch()) {
            echo '
        <div class="modal-header">
            <h4 class="modal-title" id="updatePriceModalLabel">Mise à jour prix</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="text-left mb-4">
                    <p class="text-muted"> Vous êtes sur le point de mettre à jour le prix de
                        la demande de contrat de Mr(Mme) ' . decrypt($nom) . ' ' . decrypt($prenom) . '
                    </p>
                </div>
            </div>
            <div class="container d-flex justify-content-center">
                <form method="post" id="updateForm" class="form-contract" action="./index.php">
                    <input type="hidden" id="id" value="' . $id . '" name="contrat_id">
                    <div class="row mb-3">
                        <label class="form-label" for="price"><strong>Prix : </strong></label>
                        <input type="number" step="0.001" class="form-control" id="price" name="price" value="' . get_price(decrypt($taille), decrypt($poids)) . '">
                    </div>
                    <div class="mb-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</button>
                        <button type="submit" class="btn btn-primary">VALIDER</button>
                    </div>
                </form>
            </div>
        </div>';
        }
        $connection->close();
    }
}
