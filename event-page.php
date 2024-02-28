<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENT-PAGE</title>
    <script src="https://kit.fontawesome.com/f8618ee835.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="event-page.css">
      </style>
</head>
<body>
<header>
        <a href="events.php" class="LOGO">FARHA EVENTS</a>
        <div class="group">
            <ul class="navigation">
                <li><a href="events.php">Accueil</a></li>
                <li><a href="#Événements-disponibles">Événements disponibles</a></li>
                <li><a href="#FOOTER">Contact</a></li>
                <li><a href="" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" >Se connecter</a></li>
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
<?php

include 'connection.php';


if (isset($_GET['ID'])) {
   $ID = $_GET['ID'];

   $sql = "SELECT * FROM evenement 
           INNER JOIN version ON evenement.idEvenement = version.idEvenement 
           WHERE evenement.idEvenement = '" . $ID . "'";


    $Statement = $DB->prepare($sql);
    $Statement->execute();
    $path = "imgs";
    $Action2 = "Acheter maintenant";
    $row = $Statement->fetch(PDO::FETCH_ASSOC);


        echo "   <h1 class='titre'>{$row['titre']}</h1>";
      
      echo '<section class="EVENT-DETAILLE" >';
      echo '<div class="EVENT-IMAGE-div">';
      echo '<img src="' . $path . '/' . $row['image'] . '" alt="" class="EVENT-IMAGE">';
      echo '</div>';
      echo '<div class="EVENT-INFORMATION">';
      $datetime = $row["dateEvenement"];
      $formatted_date = date("M d, Y", strtotime($datetime));
      $formatted_time = date("h:i A", strtotime($datetime));
      $calendar_icon = '<i class="fa-regular fa-calendar-days"></i>';
      $clock_icon = '<i class="fa-regular fa-clock"></i>';
      echo '<p class="EVENT-date">' . $calendar_icon . ' ' . $formatted_date . ' ' . $clock_icon . ' ' . $formatted_time . '</p>';
      echo '<div class="PRICE-container">';
      echo "   <h1 class='Price'>Tarif Normal :{$row['tarifnormal']} MAD</h1>";
      echo ' <p>Nombre de Tickets:</p> <input type="number" name="quantity" min="1" max="100">';
      echo '</div>';
      echo '<div class="PRICE-container">';
      echo "   <h1 class='Price'> Tarif Reduit: {$row['tarifReduit']} MAD</h1>";
      echo '<p>Nombre de Tickets:</p><input type="number" name="quantity" min="1" max="100">';
      echo '</div>';
      echo"<p class='ACTION-TEXT'> Vite !! Achetez rapidement vos tickets </p>";
      
      // Current date and time
      $currentDate = date("Y-m-d H:i:s");

      // Calculate the difference in seconds
      $diff = strtotime($datetime) - strtotime($currentDate);
      
      // Calculate the remaining days, hours, minutes, and seconds
      $days = floor($diff / (60 * 60 * 24));
      $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
      $minutes = floor(($diff % (60 * 60)) / 60);
      $seconds = $diff % 60;
      
      // Output the countdown
      echo '<div id="countdown">';
      echo '<div class="countdown-item">
      <div class="countdown-circle"><span id="days">' . $days . '</span></div>
          <p>Jours</p>
      </div>
      <div class="countdown-item">
          <div class="countdown-circle"><span id="hours">' . $hours . '</span></div>
          <p>Heure</p>
      </div>
      <div class="countdown-item">
      <div class="countdown-circle" ><span id="minutes">' . $minutes . '</span></div>
          <p>Minute</p>
      </div>
      <div class="countdown-item">
      <div class="countdown-circle"> <span id="seconds" >' . $seconds . '</span></div>
          <p>Second</p>
      </div>';
      echo "</div>";

      echo '<button type="submit" name="' . $Action2 . '" class="action-BTN">' . $Action2 . '</button>';
      echo "<p class='cntc-msg'>* Vous devez vous connecter pour pouvoir acheter les billets *</p>";

      echo '</section>';
      echo '<section class="DESCRIPTION">';
      echo "   <h1 class='description'>Description :</h1>";
      echo "   <p class='description-CONTENT'>{$row['description']}</p>";
      echo '</section>';
      echo "<section class='RELATED-EVENTS'>
      <h1 class='RELATED-EVENTS-TITRE'>Autres événements:</h1>
      <p class='RELATED-EVENTS-PRG'>A meme category</p>
      </section>";
}
// Display the category events
echo "<section class='containeer'>";
$sql2 = "SELECT * FROM evenement 
INNER JOIN version ON evenement.idEvenement = version.idEvenement 
WHERE evenement.categorie = '{$row['categorie']}'";

$Statement = $DB->prepare($sql2);
$Statement->execute();
while ($row2 = $Statement->fetch(PDO::FETCH_ASSOC)) {
   $Action = "J'achète";

    echo '<div class="cards">';
    echo "<img class='card-image' src='{$path}/{$row2['image']}'>";
    echo '<div class="card-details">';
    echo '<div class="category-div">';
    echo "<span>{$row2['categorie']}</span>";
    echo '</div>';
    echo "<h6 class='card-titre'>{$row2['titre']}</h6>";

    $datetime = $row2["dateEvenement"];
    $formatted_date = date("M d, Y", strtotime($datetime));
    $formatted_time = date("h:i A", strtotime($datetime));
    $calendar_icon = '<i class="fa-regular fa-calendar-days"></i>';
    $clock_icon = '<i class="fa-regular fa-clock"></i>';

    echo '<p class="card-date">' . $calendar_icon . ' ' . $formatted_date . ' ' . $clock_icon . ' ' . $formatted_time . '</p>';
    echo "<p class='card-price' > À partir de : {$row2['tarifReduit']} MAD</p>";

    echo '</div>';
    echo '<a href="EVENT-PAGE.php"><button class="card-button">' . $Action . '</button></a>';
    echo '</div>';
}
echo "</section>";

?>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header">
        <h1  class="cnx-titre" id="exampleModalToggleLabel">Connexion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- <form > -->
        <input type="text" placeholder="Votre adresse e-mail"  class="input-cnx">
        <input type="text" placeholder="Votre Mot de passe" class="input-cnx" >
        <input type="submit" name="CNX-DONE" class="CNX-BTN" value="Connexion">
        <!-- </form> -->
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
        <h1 class="cnx-titre" id="exampleModalToggleLabel">Nouveau compte</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body  ">
        <!-- <form > -->
        <div class="input-ins-div">
        <input type="text" placeholder="Votre Nom"  class="input-ins">
        <input type="text" placeholder="Votre Prenom " class="input-ins" >
        </div>
        <div class="input-ins-div">
        <input type="text" placeholder="Votre adresse e-mail"  class="input-ins">
        <input type="password" placeholder="Votre Mot de passe" class="input-ins" >
        </div>


        <input type="submit" name="INS-DONE" class="CNX-BTN" value="Inscription">
        <!-- </form> -->  
        </div>
    </div>
  </div>
</div>



    
        
    




<script>
        // Set the initial countdown values from PHP
        var days = <?php echo $days; ?>;
        var hours = <?php echo $hours; ?>;
        var minutes = <?php echo $minutes; ?>;
        var seconds = <?php echo $seconds; ?>;

        // Function to update the countdown
        function updateCountdown() {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                        days--;
                        if (days < 0) {
                            // Countdown is over
                            days = 0;
                            hours = 0;
                            minutes = 0;
                            seconds = 0;
                        }
                    }
                }
            }

            // Display the updated countdown
            document.getElementById('days').innerHTML = days;
            document.getElementById('hours').innerHTML = hours ;
            document.getElementById('minutes').innerHTML =  minutes ;
            document.getElementById('seconds').innerHTML =  seconds ;

            // Call the function again after 1 second
            setTimeout(updateCountdown, 1000);
        }

        // Start the countdown when the page loads
        window.onload = function() {
            updateCountdown();
        };
    </script>

    
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