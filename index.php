<?php 
  require('conf/config.php');
  require('conf/phpFunction.php');

if(!empty(loadRecText('prof_sty', 'pub_profile', '_active=1'))){
	$_urlTemp = explode('/', $_SERVER['REQUEST_URI']);
	if(loadRecText('prof_sty', 'pub_profile', '_active=1') != $_urlTemp[1]){
		echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/'.loadRecText('prof_sty', 'pub_profile', '_active=1').'" http-equiv="refresh">';	
	}
} else {
	echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/template-1" http-equiv="refresh">';	
}
?>