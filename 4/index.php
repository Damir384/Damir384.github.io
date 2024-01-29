<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="schedule">
    <meta name="apple-mobile-web-app-title" content="schedule">
    <meta name="msapplication-starturl" content="/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="sw-conf.js"></script>
    <style>
        * {
            margin: 0px;
        }

        html {
            min-height: 100%;
        }

        body {
            min-height: 100%;
            background: #EBE4D1;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 16px;
        }

        .gruppa {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            color: black;
            margin: 16px 0px 0px 0px;
        }

        .text {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        table {
            background: black;
        }

        .col-info {
            background: #FF971D;
            color: #F9F6F7;
        }

        .col {
            background: #F9F6F7;
        }

        .col-time {
            background: #FFE8D6;
            color: black;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="center">
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
	echo '<meta http-equiv="refresh" content="0; URL=https://youtu.be/dQw4w9WgXcQ">';
}else{
    echo '<h2 class="gruppa">'.$group.'</h2>';

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
        echo '<table class="table">';
        echo '<tr class="row"><td class="col-info"><h6 class="text">Время занятия</h6></td><td class="col-info"><h6 class="text">Название дисциплины</h6></td><td class="col-info"><h6 class="text">Кабинет</h6></td></tr><tr></tr>';
        foreach($dataGroup as $key => $value){

            $date = date("j", strtotime("$key $week week")).' '.$month[date("n", strtotime("$key $week week"))];

            echo '<tr class="row-date"><td colspan="3" class="col-info"><h6>'.$date.' ('.$daysweek[date("w",strtotime("$key $week week"))].'</h6></td></tr>';
            foreach($dataGroup->$key as $key1 => $value){
                echo '<tr class="row"><td class="col-time"><h6 class="text">'.$time_lesson[$dataGroup->$key->$key1->Vremya_provedeniya_zanyatii].'</h6></td><td class="col"><h6 class="text">'.$dataGroup->$key->$key1->Nazvanie_distsipliny.' ('.$dataGroup->$key->$key1->tip_zanyatii.')</h6></td><td class="col"><h6 class="text">'.$dataGroup->$key->$key1->Nomer_kabineta.'</h6></td>';
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
            </table>
        </div>
    </div>
</body>
</html>