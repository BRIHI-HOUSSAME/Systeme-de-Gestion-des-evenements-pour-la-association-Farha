<?php
    $dsn = 'mysql:host=localhost;dbname=farha';
    $user = 'root';
    $pass = 'Hossam2003@SQL';



try {
    $DB = new PDO($dsn, $user, $pass);
    $DB->exec('USE farha');
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}

function verify_user($email, $pdo)
{
    $stmCheckUser = $pdo->prepare("SELECT * FROM utilisateur WHERE email=:email");
    $stmCheckUser->bindParam(':email',$email);
    $stmCheckUser->execute();
    $data = $stmCheckUser ->fetchAll(PDO::FETCH_ASSOC);

    if(count($data)>0)
        return true;
    else 
        return false;

}
function login_user($email, $pw, $pdo){

    $stmLoginUser = $pdo->prepare("SELECT * FROM utilisateur WHERE email=:email and motPasse=:pw");
    $stmLoginUser->bindParam(':email',$email);
    $stmLoginUser->bindParam(':pw',$pw);
    $stmLoginUser->execute();
        $data = $stmLoginUser ->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($data)>0)
            return true;
        else 
            return false;

    }
function get_userd_ID($email, $pw, $pdo){

    $stmLoginUser = $pdo->prepare("SELECT * FROM utilisateur WHERE email=:email and motPasse=:pw");
    $stmLoginUser->bindParam(':email',$email);
    $stmLoginUser->bindParam(':pw',$pw);
    $stmLoginUser->execute();
    $id_user = $stmLoginUser ->fetch(PDO::FETCH_ASSOC);
    return $id_user['idUtilisateur'];
}

function getCapacityVersion($pdo, $ID){
    $stmCapacity = $pdo->prepare("SELECT capacite FROM salle INNER JOIN version on salle.numSalle = version.numSalle WHERE numVersion = :ID");
    $stmCapacity->bindParam(':ID', $ID);

    $stmCapacity->execute();
    $data = $stmCapacity->fetch(PDO::FETCH_ASSOC);
    return $data['capacite'];
}

function getCountTicket($pdo, $ID){
    $stmCountTicket = $pdo->prepare("SELECT COUNT(*) as NBTicket FROM facture INNER JOIN billet on facture.idFacture = billet.codeFacture WHERE numVersion = :ID");
    $stmCountTicket ->bindParam(':ID', $ID);

    $stmCountTicket ->execute();
    $data = $stmCountTicket ->fetch(PDO::FETCH_ASSOC);
    return $data['NBTicket'];
}

function createBill($pdo,$ID){
   
    do{
            $idF='F'.mt_rand(1000,100000);
            $stmCheckIdF = $pdo->prepare("select * from facture where idFacture=:idF");
            $stmCheckIdF ->bindParam(':idF',$idF );
            $stmCheckIdF ->execute();
            $data = $stmCheckIdF ->fetch(PDO::FETCH_ASSOC);
    }while($data);


    $stmCreateBill = $pdo->prepare("insert into facture values(:idF,now(),:iduser,:ID)");
    $stmCreateBill ->bindParam(':idF', $idF);
    $stmCreateBill ->bindParam(':iduser', $_SESSION['ID']);
    $stmCreateBill ->bindParam(':ID', $ID); 
    $stmCreateBill ->execute();
    return $idF;
}

function getLastPlace($pdo,$codeF){
    //Récupérer la dernière place
    $stmgetPlace = $pdo->prepare("select max(numPlace) as lastPlace from billet where codeFacture=:codeF");
    $stmgetPlace ->bindParam(':codeF',$codeF);
    $stmgetPlace ->execute();
    $datagetPlace = $stmgetPlace ->fetch(PDO::FETCH_ASSOC);
    $place=($datagetPlace['lastPlace']!=NULL)?$datagetPlace['lastPlace']:0;
    $place++;
    return $place;
}

function createTicket($pdo,$codeF,$type,$place){
   
    do{
            $idT='B'.mt_rand(100,1000);
            $stmCheckIdT = $pdo->prepare("select * from billet where codeBillet=:idT");
            $stmCheckIdT ->bindParam(':idT',$idT);
            $stmCheckIdT ->execute();
            $dataCheckIdT = $stmCheckIdT ->fetch(PDO::FETCH_ASSOC);
    }while($dataCheckIdT);




    $stmCreateTicket = $pdo->prepare("insert into billet values(:codeB,:type,:numP,:codeF)");
    $stmCreateTicket ->bindParam(':codeB', $idT);
    $stmCreateTicket ->bindParam(':type', $type);
    $stmCreateTicket ->bindParam(':numP', $place); 
    $stmCreateTicket ->bindParam(':codeF', $codeF); 
    $stmCreateTicket ->execute();
    return $idT;
  
    
}  
function Purchases_invoices($userId, $DB)
{
    $Purchases = "SELECT * 
    FROM utilisateur u 
    INNER JOIN facture f ON u.idUtilisateur = f.idUtilisateur
    WHERE u.idUtilisateur = :userId;";
    $statement_p = $DB->prepare($Purchases);
    $statement_p->bindParam(':userId', $userId);
    $statement_p->execute();
    $row_p = $statement_p->fetchAll(PDO::FETCH_ASSOC);
    return $row_p;
}

function Tickets_on_invoice($invoiceId, $DB){
    $Tickets = "SELECT * FROM billet INNER JOIN facture 
    on billet.codeBillet = facture.idFacture 
    where facture.idFacture = :invoiceId ";
    $statement_t = $DB->prepare($Tickets);
    $statement_t->bindParam(':invoiceId', $invoiceId);
    $statement_t->execute();
    $row_t = $statement_t->fetchAll(PDO::FETCH_ASSOC);
    return $row_t;
}
function Version_event($versionId, $DB){
    $sql = "SELECT *, TIME(dateEvenement) , DATE(dateEvenement) FROM evenement INNER JOIN version 
    on version.idEvenement = evenement.idEvenement 
    WHERE numVersion = :versionId ";
$statement = $DB->prepare($sql);
$statement->bindParam(':versionId', $versionId);
$statement->execute();

$row = $statement->fetch(PDO::FETCH_ASSOC);
return $row;
}





















?>