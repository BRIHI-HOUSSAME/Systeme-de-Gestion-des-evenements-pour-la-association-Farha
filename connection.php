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
?>