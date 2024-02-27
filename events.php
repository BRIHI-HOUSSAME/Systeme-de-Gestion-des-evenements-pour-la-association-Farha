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
                <li><a href="#">Se connecter</a></li>
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
            <input type="text"  name="" placeholder="Recherche...">
        </div>
    </header>
<script>
    let searchBtn = document.querySelector('.searchBtn');
    let closeBtn = document.querySelector('.closeBtn');
    let searchBox = document.querySelector('.searchBox');
    let navigation = document.querySelector('.navigation');
    let toggleMenu = document.querySelector('.menuToggle');
    let header = document.querySelector('header');

    searchBtn.onclick = function () {
        searchBox.classList.add('active');
        closeBtn.classList.add('active');
        searchBtn.classList.add('active');
        toggleMenu.classList.add('hide');

    }
    closeBtn.onclick = function () {
        searchBox.classList.remove('active');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        toggleMenu.classList.remove('hide');

    }

    toggleMenu.onclick = function () {
        header.classList.toggle('open');
        closeBtn.classList.remove('active');
        searchBtn.classList.remove('active');
        toggleMenu.classList.remove('active');
    }
</script>

<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="slids-imgs/SLIDE4.jpg" class="d-block w-100" >
    </div>
    <div class="carousel-item">
      <img src="slids-imgs/SLIDE5.jpg" class="d-block w-100" >
    </div>
    <div class="carousel-item">
      <img src="slids-imgs/SLIDE3.jpg" class="d-block w-100" >
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
include 'connection.php';
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
echo"<p>Catégorie :";
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
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
