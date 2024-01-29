<?php 

//echo '<h1>Расписание</h1>';
$url = 'http://raspisanie.belovo.ru/function/api.php'; // url, на который отправляется запрос

$group = $_GET['gruppa'];

$day_week = date("N");
if($day_week>=6){
	$week = 'next';
}else{
	$week = 'this';
}



if(empty($group)){
	echo '<center><h1><b>Такой группы не существует</b></h1></center>';
}else{
    echo '<center><b><h2>'.$group.'</h2></b></center>';
	
	echo '<input type="button" class="display_prepod fusion-builder-modal-save" id="display_prepod" value="Отобразить/скрыть преподавателей">';

//echo $group;

    $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
    $daysweek = array(1 => 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье');
    $month = array(1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
    $timelesson = array(1 => '1', '2', '3', '4', '5', '6');
    $time_lesson = array(1 => '8:30-10:05', '10:15-11:50', '12:15-13:50', '14:00-15:35', '16:00-17:35', '17:45-19:20');

	if($week == 7){
		 $post_data = [ // поля нашего запроса
        'group' => $group,
		'week' => $day_week,
    ];
	}else{
		 $post_data = [ // поля нашего запроса
        'group' => $group,
    ];
	}
  
		$headers = []; // заголовки запроса
        $post_data = http_build_query($post_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true); // true - означает, что отправляется POST запрос
        $result = curl_exec($curl);
        $dataGroup = json_decode($result);

		//print_r($result);	
		//print_r($dataGroup);
		//
		echo '<table border=1px>';
		echo '<tr><td class="head">Время занятия</td><td class="head">Название дисциплины</td><td class="head prepod" >ФИО преподавателя</td><td class="head">Кабинет</td></tr>';
        foreach($dataGroup as $key => $value){

            $date = date("j", strtotime("$key $week week")).' '.$month[date("n", strtotime("$key $week week"))];

            echo '<tr><td colspan=5 class="head"><b><center>'.$date.' ('.$daysweek[date("w",strtotime("$key $week week"))].')</center></b></td></tr>';
            foreach($dataGroup->$key as $key1 => $value){
                echo '<tr><td class="head">'.$time_lesson[$dataGroup->$key->$key1->Vremya_provedeniya_zanyatii].'</td><td>'.$dataGroup->$key->$key1->Nazvanie_distsipliny.' ('.$dataGroup->$key->$key1->tip_zanyatii.')<span class="mobile_prepod"><br><b>'.$dataGroup->$key->$key1->Familiya.' '.mb_substr($dataGroup->$key->$key1->Imya, 0, 1).'. '.mb_substr($dataGroup->$key->$key1->Otchestvo, 0, 1).'</b></span></td><td class="prepod">'.$dataGroup->$key->$key1->Familiya.' '.mb_substr($dataGroup->$key->$key1->Imya, 0, 1).'. '.mb_substr($dataGroup->$key->$key1->Otchestvo, 0, 1).'.</td><td>'.$dataGroup->$key->$key1->Nomer_kabineta.'</td></tr>';
           /*     foreach($dataGroup->$key->$key1 as $key2)
                echo $key2.' ';
           */ }
                         //   echo "<Br>";
        }
        echo '</table>';
		//$datetime = date("w");
		//echo $day_week;
		//echo $week;


	
	}

?>