<?php
 session_start();
include 'connection.php';


if(isset($_POST['Acheter-Maintenant'])) {
    if(isset($_SESSION['ID'])) {
        $NBnormal = (int)$_POST['quantity-normal'];
        $NBreduit = (int)$_POST['quantity-reduit'];
        
        if($NBnormal > 0 || $NBreduit > 0) {

          $salleCapacity = getCapacityVersion($DB, $_GET['ID']);
                            
                            $countTicket = getCountTicket($DB, $_GET['ID']);
                            
                            $ticketsAvailables=$salleCapacity-$countTicket;
                            if($ticketsAvailables==0)
                            echo '
                            <div class="fixed-top w-100 " style="margin-top: 100px;">
                                <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                        </svg>
                                        Il reste plus de places !!
                                    </div>
                                    <div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            ';
                            else
                                if(($NBnormal+$NBreduit)>$ticketsAvailables)
                                echo '
                                <div class="fixed-top w-100 " style="margin-top: 100px;">
                                    <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                            </svg>
                                            Il reste que '.$ticketsAvailables.'places!!
                                        </div>
                                        <div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                                ';
                                else{

                                    $codeF=createBill($DB,$_GET['ID']);

                                    for($i=1;$i<=$NBnormal;$i++){
                                            $p=getLastPlace($DB,$codeF);
                                            $TK=createTicket($DB,$codeF,'Normal',$p);
                                    }
                                    for($i=1;$i<=$NBreduit;$i++)
                                    {
                                        $p=getLastPlace($DB,$codeF);
                                        $TK=createTicket($DB,$codeF,'Réduit',$p);
                                }
                                }

        } else {
            echo '
            <div class="fixed-top w-100 " style="margin-top: 100px;">
                <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg>
                        Veuillez mentionner le nombre de billets.
                    </div>
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        echo '
        <div class="fixed-top w-100 " style="margin-top: 100px;">
            <div class="alert alert-danger d-flex align-items-center justify-content-between alert-dismissible fade show px-5" role="alert">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                    Vous devez vous connecter pour pouvoir acheter les billets,<span data-bs-target="#exampleModalToggle1" data-bs-toggle="modal" class="acht-msg">Connécter vous</span>
                </div>
                <div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        ';
    }
}


  // Connexion form target
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

  // Inscription form taget
  
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
      $idUser = get_userd_ID($_POST['email'], $_POST['password'], $DB);
      $_SESSION['ID']=$idUser;
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
?>

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
        <li><a href="events.php#Événements-disponibles">Événements disponibles</a></li>
        <li><a href="#FOOTER">Contact</a></li>
        <li>
        <?php 

        if(isset($_SESSION['ID'])){
          echo'<a href="profile.php" >Profile</a>';
        }
        else{
          echo'<a href="" data-bs-target="#exampleModalToggle1" data-bs-toggle="modal">Mon Compte</a>';
        }
        ?>
        </li>
      </ul>
    </div>
  </header>



</div>

  <div class="modal fade" id="exampleModalToggle1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
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


    <?php



    if (isset($_GET['ID'])) {
      
      $_SESSION['Version-ID'] = $_GET['ID'];

        $sql = "SELECT * FROM evenement 
           INNER JOIN version ON evenement.idEvenement = version.idEvenement 
           WHERE evenement.idEvenement = '" . $_SESSION['Version-ID']  . "'";


        $Statement = $DB->prepare($sql);
        $Statement->execute();
        $path = "imgs";
        $Action2 = "Acheter maintenant";
        $row = $Statement->fetch(PDO::FETCH_ASSOC);

        // display the DETAILLE 

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

        echo '<form action="" method="POST">';
        echo '<div class="PRICE-container">';
        echo "   <h1 class='Price'>Tarif Normal :{$row['tarifnormal']} MAD</h1>";
        echo ' <p>Nombre de Tickets:</p><input type="number" name="quantity-normal" min="1" max="100">';
        echo '</div>';
        echo '<div class="PRICE-container">';
        echo "   <h1 class='Price'> Tarif Reduit: {$row['tarifReduit']} MAD</h1>";
        echo '<p>Nombre de Tickets:</p><input type="number" name="quantity-reduit" min="1" max="100">';
        echo '</div>';
        echo "<p class='ACTION-TEXT'> Vite !! Achetez rapidement vos tickets </p>";
        
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
        
          echo '<button type="submit" name="Acheter-Maintenant" class="action-BTN">' . $Action2 . '</button>';

      
        
        echo "<p class='cntc-msg'>* Vous devez vous connecter pour pouvoir acheter les billets *</p>";
        echo "</form>";

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
        echo '<a a href="EVENT-PAGE.php?ID=' . $row2['idEvenement'] . '"><button class="card-button" >' . $Action . '</button></a>';
        echo '</div>';
    }
    echo "</section>";

    ?>


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
            document.getElementById('hours').innerHTML = hours;
            document.getElementById('minutes').innerHTML = minutes;
            document.getElementById('seconds').innerHTML = seconds;

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