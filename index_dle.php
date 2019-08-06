<link rel="stylesheet" type="text/css" href="css.css">
<?php
$db_con = mysqli_connect('localhost','toor','123456','dle');



$lvl_settings_file='settings.json';

$settings = json_decode(file_get_contents($lvl_settings_file), true);

$sql=mysqli_query($db_con, "SELECT * FROM dle_users WHERE user_id = '".$_COOKIE['dle_user_id']."' LIMIT 1");
while($row=mysqli_fetch_array($sql)){
	$user=$row['name'];
	$xp=$row['xp'];
}
$lvl = '0';
$simple_xp = '0';
foreach ($settings as $settings) {
	$next = $lvl+1;
			
	if($settings['lvl'] == $next){
		$next_xp = $settings['xp'];
	}
	$prev = $settings['lvl']-1;
	if($lvl == $prev AND $xp>=$settings['xp']){
		$lvl = $settings['lvl'];
	}
	if($settings['lvl'] == $lvl){
		$simple_xp = $settings['xp'];
	}
}
$now_xp = $xp-$simple_xp;
$pers = $now_xp*100/($next_xp-$simple_xp); 
		
$file_s = fopen("temp.tpl", "r");
while (!feof($file_s)) {
	$line = fgets($file_s);
	$user_p = str_replace('{name}',$user,$line);
	$user_p = str_replace('{xp}',$xp,$user_p);
	$user_p = str_replace('{max_xp}',$next_xp,$user_p);
	$user_p = str_replace('{lvl}',$lvl,$user_p);
	$user_p = str_replace('{persent}',$pers,$user_p);
	echo($user_p); 
}
fclose($file_s);




?>
