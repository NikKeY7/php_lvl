<link rel="stylesheet" type="text/css" href="css.css">
<?php
$username = "UserName#6171";
$lvl_users_file='stats.json';
$lvl_settings_file='settings.json';

$settings = json_decode(file_get_contents($lvl_settings_file), true);
$user = json_decode(file_get_contents($lvl_users_file), true);

foreach ($user as $user) {
	if($user['username']==$username){
		$lvl = '0';
		$simple_xp = '0';
		foreach ($settings as $settings) {
			$next = $lvl+1;
			
			if($settings['lvl'] == $next){
				$next_xp = $settings['xp'];
			}
			$prev = $settings['lvl']-1;
			if($lvl == $prev AND $user['xp']>=$settings['xp']){
				$lvl = $settings['lvl'];
			}
			if($settings['lvl'] == $lvl){
				$simple_xp = $settings['xp'];
			}
			
		}
		$now_xp = $user['xp']-$simple_xp;
		$pers = $now_xp*100/($next_xp-$simple_xp); 
		
		$file_s = fopen("temp.tpl", "r");
		while (!feof($file_s)) {
			$line = fgets($file_s);
			$user_p = str_replace('{name}',$username,$line);
			$user_p = str_replace('{xp}',$user['xp'],$user_p);
			$user_p = str_replace('{max_xp}',$next_xp,$user_p);
			$user_p = str_replace('{lvl}',$lvl,$user_p);
			$user_p = str_replace('{persent}',$pers,$user_p);
			echo($user_p); 
		}
		fclose($file_s);

	}
}



?>