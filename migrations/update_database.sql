ALTER TABLE
    `admin` CHANGE `username` `username` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `password` `password` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;

ALTER TABLE
    `contrat` CHANGE `nom` `nom` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `prenom` `prenom` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `poids` `poids` VARCHAR(255) NOT NULL,
    CHANGE `taille` `taille` VARCHAR(255) NOT NULL,
    CHANGE `ville` `ville` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `zip` `zip` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
    CHANGE `prix` `prix` VARCHAR(255) NULL DEFAULT NULL;