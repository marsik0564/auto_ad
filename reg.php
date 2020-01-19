<?php
$arr = [];
try {
    require_once('bdconnect.php');
    if (isset($_REQUEST['em'])) {
        $query = "SELECT * FROM users WHERE email=:mail";    
        $auto = $pdo->prepare($query);
        $auto->execute(['mail'=>$_REQUEST['em']]);
        $user= $auto->fetch();
        if ($user['email'] !== NULL) {
            if (isset($_REQUEST['pass'])) {
                if ($user['pass'] === md5($_REQUEST['pass'])) {
                    $arr = [
                        "uid" => "{$user['uid']}",
                        "kolpost" => "{$user['kolpost']}",
                        "email" => "{$user['email']}",
                        "error" => ""
                    ];
                } else $arr = ["error" => "Не правильный пароль"];
            } else exit;
        } else $arr = ["error" => "Такой email не зарегистрирован в базе данных"];
    } elseif (isset($_REQUEST['emr'])) {
        $query = "INSERT INTO users VALUES (NULL, '".
            $_REQUEST['emr'].
            "', '".
            md5($_REQUEST['passr']).
            "', '0');";
        if ($pdo->exec($query)!==false) {
            $query = "SELECT uid, kolpost FROM users WHERE email=:mail";
            $auto = $pdo->prepare($query);
            $auto->execute(['mail'=>$_REQUEST['emr']]);
            $user = $auto->fetch();
            $arr = [
                "uid" => "{$user['uid']}",
                "kolpost" => "{$user['kolpost']}",
                "email" => "{$_REQUEST['emr']}",
                "error" => ""
            ];           
        }
    }
} catch (PDOException $e) {
    echo $arr=["error" => "Ошибка выполнения запроса: ".$e->getMessage()];
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>