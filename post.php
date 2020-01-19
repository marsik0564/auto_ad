<?php
$dat=date('Y-m-d H:i:s');
if (isset($_REQUEST['subp'])) 
    try {
        require_once('bdconnect.php');  
        $query = 'INSERT INTO ad VALUES (NULL, :uid, :date, :obl, :gor, :mark, :mod, :obdv, :prob, :kolhoz)';
        $ad = $pdo->prepare($query);
        $ad->execute([
            'uid' => $_REQUEST['uid'],
            'date' => $dat,
            'obl' => $_REQUEST['obl'],
            'gor' => $_REQUEST['gor'],
            'mark' => $_REQUEST['mark'],
            'mod' => $_REQUEST['mod'],
            'obdv' => $_REQUEST['obdv'],
            'prob' => $_REQUEST['prob'],
            'kolhoz' => $_REQUEST['kolhoz']
        ]);
        $query = "SELECT id
            FROM ad
            WHERE uid = :uid 
            AND crdate = :date";
        $ad = $pdo->prepare($query);
        $ad->execute([
            'uid' => $_REQUEST['uid'],
            'date' => $dat
        ]);
        $dirname = $ad->fetch(); 
        mkdir('images/'.$dirname['id']);
        foreach ($_FILES['fotos']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['fotos']['tmp_name'][$key];
                $name = basename($_FILES['fotos']['name'][$key]);
                move_uploaded_file($tmp_name, 'images/'.$dirname['id']."/$name");
            }
        }
        $query = "SELECT kolpost
            FROM users
            WHERE uid = :uid";
        $ad = $pdo->prepare($query);
        $ad->execute([
            'uid' => $_REQUEST['uid']
        ]);
        $kol = $ad->fetch();
        $kol['kolpost']++; 
        $query = "UPDATE users
            SET kolpost = :kol
            WHERE uid = :uid";
        $ad = $pdo->prepare($query);
        $ad->execute([
            'kol' => $kol['kolpost'],
            'uid' => $_REQUEST['uid']
        ]); 
        //header('Location: '.$_SERVER['HTTP_REFERER']); 
    } catch (PDOException $e) {
        //header('refresh: 4; url='.$_SERVER['HTTP_REFERER']);
        echo "Ошибка выполнения запроса: ". $e->getMessage();
    }
?>