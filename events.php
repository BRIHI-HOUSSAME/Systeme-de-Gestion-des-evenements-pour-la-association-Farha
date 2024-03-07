<?php
session_start();
include 'connection.php';
  // Connexion form
  if (isset($_POST['CNX-DONE'])) {
    if (login_user($_POST['email-cnx'], $_POST['password-cnx'], $DB)) {
      echo '
      <div class="fixed-top w-100 " style="margin-top: 100px;" >
          <div class="alert alert-success d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
              <div class="d-flex align-items-center justify-content-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>
                  Connexion réussie
              </div>
              <div>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          </div>
      </div>
      ';

      $idUser = get_userd_ID($_POST['email-cnx'], $_POST['password-cnx'], $DB);
      $_SESSION['ID']=$idUser;
    } else {
      echo '
          <div class="fixed-top w-100" style="margin-top: 100px;">
              <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                  <div class="d-flex align-items-center justify-content-center gap-3">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                      </svg>
                      Email ou mot de passe incorrect
                  </div>
                  <div>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              </div>
          </div>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="events.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>FARHA</title>
  <script src="https://kit.fontawesome.com/f8618ee835.js" crossorigin="anonymous"></script>
</head>

<body>

  <header>
    <a href="events.php" class="LOGO">FARHA EVENTS</a>
    <div class="group">
      <ul class="navigation">
        <li><a href="">Accueil</a></li>
        <li><a href="#Événements-disponibles">Événements disponibles</a></li>
        <li><a href="#FOOTER">Contact</a></li>
        <li>
        <?php 
        if(isset($_SESSION['ID'])){
          echo'<a href="profile.php" >Profile</a>';
        }
        else{
          echo'<a href="" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Mon Compte</a>';
        }
        ?>
        </li>
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



  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="cnx-titre" id="exampleModalToggleLabel">Connexion</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <input type="text" placeholder="Votre adresse e-mail" required name="email-cnx" class="input-cnx">
            <input type="text" placeholder="Votre Mot de passe" required name="password-cnx" class="input-cnx">
            <input type="submit" name="CNX-DONE" class="CNX-BTN" value="Connexion">
          </form>
        </div>
        <div class="modal-footer">
          <p>vous n'avez pas un compte ?</p><span class="INS-target" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">inscrivez-vous</span>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="cnx-titre" id="exampleModalToggleLabel2">Nouveau compte</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="input-ins-div">
              <input type="text" class="input-ins" placeholder="Votre Nom" name="nom" required>
              <input type="text" class="input-ins" placeholder="Votre Prenom" name="prenom" required>
            </div>
            <div class="input-ins-div">
              <input type="email" class="input-ins" placeholder="Votre adresse e-mail" name="email" required>
              <input type="password" class="input-ins" placeholder="Votre Mot de passe" name="password" required>
            </div>
          </div>
          <div>
            <div style="display:flex; justify-content: space-between;">
              <div> <input type="submit" name="INS-DONE" class="CNX-BTN" value="Inscription"></div>
              <div style="display:flex;  margin-top:15px; margin-right:15px ">
                <p>Vous avez déjà un compte?</p>
                <span class="INS-target" data-bs-toggle="modal" data-bs-target="#exampleModalToggle"> Connexion</span>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- carousel  -->

  <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="slids-imgs/SLIDE4.jpg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="slids-imgs/SLIDE5.jpg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="slids-imgs/SLIDE3.jpg" class="d-block w-100">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <?php
  // include 'connection.php';

  if (isset($_POST['INS-DONE'])) {
    if (!verify_user($_POST['email'], $DB)) {
      $insertQuery = "INSERT INTO utilisateur (nom, prenom, email, motPasse) VALUES (:name, :lastName, :email, :password)";
      $stmInsertUser = $DB->prepare($insertQuery);
      $stmInsertUser->bindParam(':name', $_POST['nom']);
      $stmInsertUser->bindParam(':lastName', $_POST['prenom']);
      $stmInsertUser->bindParam(':email', $_POST['email']);
      $stmInsertUser->bindParam(':password', $_POST['password']);
      $stmInsertUser->execute();
      echo '
          <div class="fixed-top w-100 " style="margin-top: 100px;" >
              <div class="alert alert-success d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                  <div class="d-flex align-items-center justify-content-center gap-3">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:" viewBox="0 0 16 16">
                      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                      </svg>
                      Inscription réussie
                  </div>
                  <div>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              </div>
          </div>
          ';
    } else {
      echo '
          <div class="fixed-top w-100 " style="margin-top: 100px;">
              <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                  <div class="d-flex align-items-center justify-content-center gap-3">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                      </svg>
                      Email existant
                  </div>
                  <div>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              </div>
          </div>
          ';
    }
  }


  // Initialize variables
  $startDate = "";
  $endDate = "";

  // Check if the form is submitted
  if (isset($_POST['FILTER-DONE'])) {
    $category = $_POST['categories'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Start building the SQL query based on user input
    $sql = "SELECT * FROM evenement 
            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
            WHERE dateEvenement > current_date()";

    // Add category filter if selected
    if (!empty($category)) {
      $sql .= " AND categorie = :category";
    }

    // Add date range filter if provided
    if (!empty($startDate) && !empty($endDate)) {
      $sql .= " AND dateEvenement BETWEEN :startDate AND :endDate";
    }

    $Statement = $DB->prepare($sql);

    // Bind parameters if they exist
    if (!empty($category)) {
      $Statement->bindParam(':category', $category, PDO::PARAM_STR);
    }
    if (!empty($startDate) && !empty($endDate)) {
      $Statement->bindParam(':startDate', $startDate, PDO::PARAM_STR);
      $Statement->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    }

    $Statement->execute();
  } else {
    // If form is not submitted, fetch all upcoming events
    $sql = "SELECT * FROM evenement 
            INNER JOIN version ON evenement.idEvenement = version.idEvenement 
            WHERE dateEvenement > current_date()";
    $Statement = $DB->prepare($sql);
    $Statement->execute();
  }

  $path = "imgs";
  $Action = "J'achète";

  // Display the filter form
  echo '<h1 class="Titre" id="Événements-disponibles">Événements disponibles :</h1>';
  echo '<div class="Filter-div">';
  echo '<form method="POST" class="filter-form">'; // Add form tag for submission
  echo '<h4 class="FILTRE-TITRE">Filtrer par :</h4>';

  $Filter = "SELECT DISTINCT  categorie FROM Evenement";
  $result = $DB->query($Filter);
  echo "<p>Catégorie :";
  echo '<select name="categories">';
  echo '<option value="">Toutes les catégories</option>'; // Option for all categories
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $selected = ($row["categorie"] == $category) ? 'selected' : '';
    echo '<option value="' . $row["categorie"] . '" ' . $selected . '>' . $row["categorie"] . '</option>';
  }
  echo '</select>';
  echo "</p>";

  echo '<p>Ou par Date :  Entre <input type="date" name="startDate" value="' . $startDate . '"> Et <input type="date" name="endDate" value="' . $endDate . '"></p>';

  echo '<button type="submit" name="FILTER-DONE" class="FILTER-BTN">Appliquer</button>';
  echo '</form>'; // Close form tag

  echo '</div>';

  // Display the events
  echo "<section class='containeer' >";
  while ($row = $Statement->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="cards">';
    echo "<img class='card-image' src='{$path}/{$row['image']}'>";
    echo '<div class="card-details">';
    echo '<div class="category-div">';
    echo "<span>{$row['categorie']}</span>";
    echo '</div>';
    echo "<h6 class='card-titre'>{$row['titre']}</h6>";

    $datetime = $row["dateEvenement"];
    $formatted_date = date("M d, Y", strtotime($datetime));
    $formatted_time = date("h:i A", strtotime($datetime));
    $calendar_icon = '<i class="fa-regular fa-calendar-days"></i>';
    $clock_icon = '<i class="fa-regular fa-clock"></i>';

    echo '<p class="card-date">' . $calendar_icon . ' ' . $formatted_date . ' ' . $clock_icon . ' ' . $formatted_time . '</p>';
    echo "<p class='card-price' > À partir de : {$row['tarifReduit']} MAD</p>";

    echo '</div>';
    echo '<a href="EVENT-PAGE.php?ID=' . $row['idEvenement'] . '"><button class="card-button">' . $Action . '</button></a>';
    echo '</div>';
  }
  echo "</section>";
  ?>
  <section class="features">
    <div class="feature">
      <i class="fa-solid fa-ticket"></i>
      <h3>Achetez des tickets</h3>
      <p>Achetez des tickets de qualité pour les meilleurs événements en toute sécurité !</p>
    </div>
    <div class="feature">
      <i class="fa-solid fa-award"></i>
      <h3>Notre garantie 100 %</h3>
      <p>Éliminez les risques et assurez-vous une transaction sécurisée et protégée en faisant affaire avec FARHA EVENTS</p>
    </div>
    <div class="feature">
      <i class="fa-solid fa-phone-volume"></i>
      <h3>Support 24/24H</h3>
      <p>+212 123-456-7890 / info@farha-events.com</p>
    </div>
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