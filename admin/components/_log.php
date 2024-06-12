<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	
session_start();
require '../../conf/config.php';
require '../../conf/phpFunction.php';


	$_log_mail = mysqli_real_escape_string($mysqli, $_REQUEST['_pVar1']);
	$_log_pwd = mysqli_real_escape_string($mysqli, $_REQUEST['_pVar2']);
	$_log_captMath = $_REQUEST['math'];
    
    
            //SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active FROM m_users WHERE 1
            if($_SESSION['keys']==$_log_captMath){
                $query = $mysqli->query("SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active FROM set_users WHERE us_email='$_log_mail'");

                //$fetch = $query->fetch_array();
                //$rows = $query->num_rows;
				
                if($query->num_rows!==0){
					$row = $query->fetch_assoc();
					if(password_verify($_log_pwd, $row['us_passwd'])){
						$_SESSION['usNip'] = $row['us_nip'];
						$_SESSION['usNama'] = $row['us_nama'];
						$_SESSION['usRole'] = $row['us_roles'];
						
						updateField('us_last=SYSDATE()', 'set_users', 'us_nip='.$_SESSION['usNip']);
						
						echo json_encode(array('codeErrors'=>555,'msgErrors'=>$servAdmin));
					} else {
						echo json_encode(array('codeErrors'=>502,'msgErrors'=>'Periksa kembali Email dan Password'));
					}
                }else{
					echo json_encode(array('codeErrors'=>502,'msgErrors'=>'Periksa kembali Email dan Password'));
                }
            }else{
                //echo array("codeMsg"=>"35", "txtMsg"=>"37");
                echo json_encode(array('codeErrors'=>501,'msgErrors'=>'Captcha tidak cocok'));
            }
            
            $mysqli->close();   
} else {
	header('Location:'.$_SERVER['HTTP_HOST']);
}
?>