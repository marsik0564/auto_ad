<?php
try {
    require_once('bdconnect.php');
    require_once('oop.php');
    $get_params='';
    $where=" WHERE id>'0' ";
    $params=[];
    $order="ORDER BY crdate DESC";
    foreach($_GET as $key => $value)
        if (($value!=='')and($key!='subf')and($key!='page')) {
            $get_params.='&'.$key.'='.urlencode($value);
            if ($key=='obdv') 
                $where.="AND $key>= :$key ";
            elseif (($key=='probeg')or($key=='kolhoz'))
                $where.="AND $key<= :$key ";
            else 
                $where.="AND $key= :$key ";
            $params[$key]="$value";     
        }
        if ($where==" WHERE id>'0' ") $where='';
    $obj = new PdoPager(
    new PagesList(),
    $pdo,
    'ad',
    $where,
    $params,
    $order,
    10,
    3,
    $get_params);
    if ($obj->getItemsCount()==0) 
        echo 'Совпадений не найдено';
    else {
        foreach($obj->getItems() as $ad) {
            echo '<div class="row border shadow-sm m-1 ad">'.
            "<small class='text-muted ml-auto'>Опубликовано {$ad['crdate']}</small>".
            "<h3 class='mx-2 w-100'>{$ad['marka']} {$ad['model']}</h3>".            
            '<div class="col-5 align-self-center"> <ul class="list-group my-2">'.
            "<li class='list-group-item list-group-item-secondary'>Область: {$ad['oblast']}; </li>".
            "<li class='list-group-item list-group-item-secondary'>Город: {$ad['gorod']};</li>".
            "<li class='list-group-item list-group-item-secondary'>".
            "Объем двигателя: {$ad['obdv']}см<sup>3</sup>;</li>".
            "<li class='list-group-item list-group-item-secondary'>Пробег: {$ad['probeg']}км;</li>".
            "<li class='list-group-item list-group-item-secondary'>Количество хозяев: {$ad['kolhoz']}</li>".
            '</ul></div><div class="col-7 px-3"><div class="row justify-content-around">';
            $dir = opendir('images/'.$ad['id']);
            $i=0;
            while(($file = readdir($dir)) !== false){
                if(is_file('images/'.$ad['id']."/".$file)) {
                    //$i++;          
                    echo '<div class="col-3 p-0"><img src="images/'.
                    $ad['id']."/".$file.'" class="img-thumbnail" /></div>';
                    //if(fmod($i,5) == 0) echo '<br />';
                    }
            }
            closedir($dir);   
            echo " </div> </div> </div>";
        }
        echo "<p>$obj</p>";
    }
} catch (PDOException $e) {
    echo "Ошибка выполнения запроса: ". $e->getMessage();
}
?>