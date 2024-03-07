<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['ID'])) {
    $userId = $_SESSION['ID'];

    $user = $DB->prepare("SELECT * FROM utilisateur where idUtilisateur = :ID");
    $user->bindParam(':ID', $userId);
    $user->execute();
    $users = $user->fetch(PDO::FETCH_ASSOC);


    if (isset($_POST['UPDATE'])) {
        $editedFname = $_POST['prenom'];
        $editedLname = $_POST['nom'];
        $editedEmail =  $_POST['email'];
        $update = $DB->prepare("UPDATE utilisateur SET prenom = :new_prenom, nom = :new_nom, email = :editedEmail where idUtilisateur = :ID");
        $update->bindParam(':new_prenom', $editedFname);
        $update->bindParam(':new_nom', $editedLname);
        $update->bindParam(':editedEmail',  $editedEmail);
        $update->bindParam(':ID', $userId);
        $update->execute();
        header("location: profile.php");
        echo '
        <div class="fixed-top w-100 " style="margin-top: 100px;" >
            <div class="alert alert-success d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    Modifié avec succès
                </div>
                <div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        ';
        
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="profile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>PROFILE</title>
    <script src="https://kit.fontawesome.com/f8618ee835.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="events.php" class="LOGO">FARHA EVENTS</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="events.php">Accueil</a></li>
                <li><a href="#Événements-disponibles">Événements disponibles</a></li>
                <li><a href="#FOOTER">Contact</a></li>
            </ul>
            <div class="search">
                <span class="icon">
                    <ion-icon name="search-outline" class="searchBtn"></ion-icon>
                    <ion-icon name="close-outline" class="closeBtn"></ion-icon>
                </span>
            </div>
            <ion-icon name="menu-outline" class="menuToggle"></ion-icon>
        </div>
        <div class="searchBox">
            <input type="text" name="" placeholder="Recherche...">
        </div>
    </header>

    <div style="display: flex; justify-content: center; ">
<img src="imgs/ACCOUNT-ICON.png" alt="" class="ICON">
    </div>
    <section >
    <h3>Mes informations</h3>
        <div>
        <p>Nom: <?php echo $users['nom'] ?></p>
        <p>Prénom: <?php echo $users['prenom'] ?></p>
        <p>Email: <?php echo $users['email'] ?></p>
        </div>
    </section>

    <section>
        <h3>Modifier mes informations </h3>
        <form action="" method="post">
        <input type="text" placeholder="Prénom" value=" <?php echo $users['prenom'] ?>"  name="prenom" >
        <input type="text" placeholder="Nom" value=" <?php echo $users['nom'] ?>"  name="nom" >
        <input type="email" placeholder="Email" name="email" value="<?php echo $users['email'] ?>" >
        <input type="submit"   class="UPDATE-INFO" value="Modifier" name="UPDATE" >
        </form>
    </section>

    <section>
        <h3>Mes factures</h3>
        <table class="table table-striped">
    <thead>
        <tr>
            <th>Référence Facture</th>
            <th>Nom de l'événement</th>
            <th>Date de l'évènement</th>
            <th>Total Payé</th>
            <th>Voir les détails</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>12345</td>
            <td>Événement 1</td>
            <td>2024-02-15</td>
            <td>250€</td>
            <td>Voir</td>
        </tr>
        <tr>
            <td>67890</td>
            <td>Événement 2</td>
            <td>2024-03-01</td>
            <td>150€</td>
            <td>Voir</td>
        </tr>
        <tr>
            <td>54321</td>
            <td>Événement 3</td>
            <td>2024-03-10</td>
            <td>180€</td>
            <td>Voir</td>
        </tr>
    </tbody>
</table>

    </section>


    <footer id="FOOTER">

        <div class="contact-info">
            <h3>Contact Us</h3>
            <p>Email: info@farha-events.com</p>
            <p>Phone: 123-456-7890</p>
            <div class="social-links">

            </div>
        </div>

        <div class="quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li>Accueil</li>
                <li>Événements disponibles</a></li>
                <li>About Us</li>
                <li>FAQs</li>
            </ul>
        </div>

        <div class="legal-info">
            <h3>Legal</h3>
            <ul>
                <li>Privacy Policy</li>
                <li>Terms of Service</li>
                <li>© 2024 FARHA EVENTS. All Rights Reserved.</li>
            </ul>
        </div>

    </footer>
    <script src="header-script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>