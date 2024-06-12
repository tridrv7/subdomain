<?PHP
/*
function loadRecordli($loadField, $loadTbl, $loadWhere, $loadOrder){
    require '../assets/config/dbconfig.php';
    
    $sql = "SELECT $loadField FROM $loadTbl";
    if(!empty($loadWhere)) { $sql.=" WHERE $loadWhere"; }
    if(!empty($loadOrder)){ $sql.=" ORDER BY $loadOrder"; }
    
    $rs = mysqli_query($conn, $sql);
    
    $rowLoad = '';
    while($row = mysqli_fetch_array($rs)){
        $rowLoad.="<li><a href=\"javascript:void()\" onClick=\"loadPageTwo('dg_aturan','$row[0]','$row[1]')\"><span class=\"sub-item\">$row[1]</span></a></li>";
    }
    
    return $rowLoad;
}
*/
//var
$_px	= isset($_REQUEST['_px']) ? strval($_REQUEST['_px']) : '';	
$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
$_p2	= isset($_REQUEST['_p2']) ? strval($_REQUEST['_p2']) : '';	
$_c1	= isset($_REQUEST['_c1']) ? strval($_REQUEST['_c1']) : '';	
$_c2	= isset($_REQUEST['_c2']) ? strval($_REQUEST['_c2']) : '';	

function inOpt($loadField, $loadTbl, $loadWhere, $loadOrder, $typeView){

    $sql = "SELECT $loadField FROM $loadTbl";
    if(!empty($loadWhere)) { $sql.=" WHERE $loadWhere"; }
    if(!empty($loadOrder)){ $sql.=" ORDER BY $loadOrder"; }

    $rowLoad = '';
	$result = $GLOBALS['mysqli']->query($sql);
	$rowNum = $result->num_rows;
	
	while ($row = $result->fetch_array()) {
		$_val = $row[0];
		$_disp = $row[1];
		
		switch($typeView){
			case 1://_mast-kategori.php
				$view = '<option style="padding-bottom: 0;" value="'.$_val.'">'.$_disp.'</option>';
				break;
			case 2://_set-menu.php
				$view = '<option style="padding-bottom: 0;" value="'.$loadTbl.'-'.$_val.'">'.$_disp.'</option>';
				break;
			case 3:
				$num_ag = loadRecText('count(*)', 'tb_agnd', '_active=1 AND _cre="'.$_val.'"');
				$num_fl = loadRecText('count(*)', 'tb_files', '_active=1 AND _cre="'.$_val.'"');
				$num_ga = loadRecText('count(*)', 'tb_galery', '_active=1 AND _cre="'.$_val.'"');
				$num_li = loadRecText('count(*)', 'tb_link', '_active=1 AND _cre="'.$_val.'"');
				$num_po = loadRecText('count(*)', 'tb_post', '_active=1 AND _cre="'.$_val.'"');
				$num_all = $num_ag + $num_fl + $num_ga + $num_li + $num_po;

				$view = '<div class="col-sm-6 col-xl-2">
							<div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white mb-g">
								<div class="">
									<h3 class="display-4 d-block l-h-n m-0 fw-500">
										<small class="m-0 l-h-n text-capitalize">'.$_disp.'</small>
										'.$num_all.'
									</h3>
								</div>
								<i class="fal fa-solid fa-file position-absolute pos-right pos-bottom opacity-50 mb-n1 mr-n1" style="font-size:6rem"></i>
							</div>
						</div>';
				break;
		}
		
		$rowLoad .= $view;
	}
	
    return $rowLoad;
}

function hrefAside($field, $tbl, $sqlJoin, $sqlWhere, $sqlOrder){
	
    $sql = "SELECT $field FROM $tbl";
    if(!empty($sqlJoin)) { $sql.=" $sqlJoin"; }
    if(!empty($sqlWhere)) { $sql.=" WHERE $sqlWhere"; }
    if(!empty($sqlOrder)){ $sql.=" ORDER BY $sqlOrder"; }

    $rowLoad = '';
	$result = $GLOBALS['mysqli']->query($sql);
	
	while ($row = $result->fetch_array()) {
		$_var1 = $row[0];
		$_var2 = $row[1];
		$_var2c = str_replace(" ","-","$row[1]");
		$_var3 = $row[2];
		$_var4 = $row[3];
		
		//a.ka_id, a.ka_name, a.fm_id, b.fm_file
		
		$view =	"<li>".
					"<a href=\"javascript:void(0)\" onClick=\"goPublic('$_var4','$_var1','$_var2c','publikasi_data_$_var2c')\">".
					"<span class=\"nav-link-text\" data-i18n=\"nav.settings_user\">$_var2</span>".
					"</a>".
				"</li>";
		
		$rowLoad .= $view;
	}
	
    return $rowLoad;
}

function privAcc($txtbread, $priv){

	$result = $GLOBALS['mysqli']->query("SELECT COUNT(*) AS nRec, a.page_id, a.page_name, a.page_addr, b.ro_id, b.rr_read, b.rr_cre, b.rr_up, b.rr_del
								FROM set_page a
									LEFT JOIN set_rules b
										ON a.page_id = b.page_id AND b.ro_id='$priv'
								WHERE a._active=1 AND a.page_addr='$txtbread'
								GROUP BY a.page_id")
							  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);

	
	$row = $result->fetch_assoc();
	$rowNum = $result->num_rows;
	
	if($rowNum!=0){
		return array('_num'=>$row['nRec'],'_re'=>$row['rr_read'],'_cr'=>$row['rr_cre'],'_up'=>$row['rr_up'],'_de'=>$row['rr_del']);
	} else {
		return array('_num'=>$row['nRec']);
	}

	die();

}
function updateOneField($loadField, $loadTbl, $loadWhere){
    
	$sql = "UPDATE $loadTbl AS t1, (SELECT $loadField FROM $loadTbl WHERE $loadWhere) as t2
				SET t1.$loadField = t2.$loadField+1 
				WHERE $loadWhere";
	
	$result = $GLOBALS['mysqli']->query($sql);
	
    //return $rowLoad;
}

function updateField($setField, $setTbl, $setWhere){
	$sql = "UPDATE $setTbl
				SET $setField
				WHERE $setWhere";
	
	$result = $GLOBALS['mysqli']->query($sql);
	
    //return $rowLoad;
}

function loadRecText($field, $table, $condition){
	
    $sql = "SELECT $field FROM $table WHERE $condition";
	$result = $GLOBALS['mysqli']->query($sql);
	$row = $result->fetch_assoc();
	
    return $row[$field];
}

function logSites($dt, $IP, $OS, $BR, $C){
    //logSites($dateYMD, getIP(), get_operating_system(), get_the_browser());

    $logid = $dt.str_pad(loadRecText('count(*)', 'log_sites', 'logcat='.$C.' AND logid LIKE "'.$dt.'%"')+1, 3, '0', STR_PAD_LEFT);
    
	$sql = "INSERT INTO log_sites
				VALUES ('$logid', '$IP', '$BR', '$OS', SYSDATE(), '$C')";
	
	$result = $GLOBALS['mysqli']->query($sql);
	
    return $rowLoad;
}

function sidebarLi($loadPage, $textdisp){
	$rest = "<li><a href=\"javascript:void(0);\" onClick=\"$loadPage\"><span class=\"sub-item\">$textdisp</span></a></li>";
	return $rest;
}

function bulan($var){
	$bulan = array (
		01 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	return $bulan[$var];
}
function tgl_panjang($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function tgl_pendek($tanggal){
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agust',
		'Sept',
		'Okt',
		'Nov',
		'Des'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function tgljam($tanggal){
	list($tgl, $jam) = explode(' ', $tanggal);
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Agust',
		'Sept',
		'Okt',
		'Nov',
		'Des'
	);
	
	list($th, $bl, $tg) = explode('-', $tgl);
	if($th==date('Y')){
		$th = '';
	}
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $tg.' '.$bulan[(int)$bl].' '.$th;
}

function substrwords($text, $maxchar, $end='...') {
	$text = strip_tags($text);
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}

function beda_waktu($date1, $date2, $format = false) 
{
	$diff = date_diff( date_create($date1), date_create($date2) );
	if ($format)
		return $diff->format($format);
	
	return array('y' => $diff->y,
				'm' => $diff->m,
				'd' => $diff->d,
				'h' => $diff->h,
				'i' => $diff->i,
				's' => $diff->s
			);
}

//START EMAIL HIDDEN//
function mask($str, $first, $last) {
    $len = strlen($str);
    $toShow = $first + $last;
    return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat("*", $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
}

function mask_email($email) {
    $mail_parts = explode("@", $email);
    $domain_parts = explode('.', $mail_parts[1]);

    $mail_parts[0] = mask($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
    $domain_parts[0] = mask($domain_parts[0], 2, 1); // same here
    $mail_parts[1] = implode('.', $domain_parts);

    return implode("@", $mail_parts);
}
//END EMAIL//

//SIDOARJO DALAM ANGKA
function curWord($cu){
	$cux = number_format($cu, 0);
	$lenCux = strlen($cux);

	if($lenCux>8){
		if(substr($cux,2,1)!=0){
			switch($lenCux){
				case 9:
					$subCux = substr($cux, 0, 3);

					$combine = $subCux.' Juta';
					break;
				case 13:
					$subCux = substr($cux, 0, 3);

					$combine = $subCux.' M';
					break;
				case 17:
					$subCux = substr($cux, 0, 3);

					$combine = $subCux.' T';
					break;
			}
		} else {
			switch($lenCux){
				case 9:
					$subCux = substr($cux, 0, 1);

					$combine = $subCux.' Juta';
					break;
				case 13:
					$subCux = substr($cux, 0, 1);

					$combine = $subCux.' M';
					break;
				case 17:
					$subCux = substr($cux, 0, 1);

					$combine = $subCux.' T';
					break;
			}
		}
	} else {
		$combine = $cux;
	}
	
	return $combine;
}
//END SIDOARJO DALAM ANGKA

//date ago
function TimeAgo ($oldTime, $newTime) {
$timeCalc = strtotime($newTime) - strtotime($oldTime);
if ($timeCalc >= (60*60*24*30*12*2)){
	$timeCalc = intval($timeCalc/60/60/24/30/12) . " years ago";
	}else if ($timeCalc >= (60*60*24*30*12)){
		$timeCalc = intval($timeCalc/60/60/24/30/12) . " year ago";
	}else if ($timeCalc >= (60*60*24*30*2)){
		$timeCalc = intval($timeCalc/60/60/24/30) . " months ago";
	}else if ($timeCalc >= (60*60*24*30)){
		$timeCalc = intval($timeCalc/60/60/24/30) . " month ago";
	}else if ($timeCalc >= (60*60*24*2)){
		$timeCalc = intval($timeCalc/60/60/24) . " days ago";
	}else if ($timeCalc >= (60*60*24)){
		$timeCalc = " Yesterday";
	}else if ($timeCalc >= (60*60*2)){
		$timeCalc = intval($timeCalc/60/60) . " hours ago";
	}else if ($timeCalc >= (60*60)){
		$timeCalc = intval($timeCalc/60/60) . " hour ago";
	}else if ($timeCalc >= 60*2){
		$timeCalc = intval($timeCalc/60) . " minutes ago";
	}else if ($timeCalc >= 60){
		$timeCalc = intval($timeCalc/60) . " minute ago";
	}else if ($timeCalc > 0){
		$timeCalc .= " seconds ago";
	}
return $timeCalc;
}//end date ago

// mail function ============================================================
	function sendOTP($email,$otp) {
		require('class/class.phpmailer.php');
		require('class/class.smtp.php');
	
		$message_body = "Kode OTP :<br/><br/>" . $otp;
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = 'tls'; // tls or ssl
		$mail->Port     = "587";
		$mail->Username = "hukum@sidoarjokab.go.id";
		$mail->Password = "Hukum1234";
		$mail->Host     = "mail.sidoarjokab.go.id";
		$mail->Mailer   = "smtp";
		$mail->SetFrom("hukum@sidoarjokab.go.id", "Bagian Hukum Kab. Sidoarjo");
		$mail->AddAddress($email);
		$mail->Subject = "OTP Code";
		$mail->MsgHTML($message_body);
		$mail->IsHTML(true);
		$result = $mail->Send();
		
		return $result;
	}
//============================================================================

function enc($cry) {
	$cry = base64_encode(md5("pass@w0rd".trim($cry.'--SITES--')));

	return $cry;
}


// log akses site ============================================================

function getIP(){
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($addr[0]);
        } else {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function get_operating_system() {
    $u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $operating_system = 'Other';

    //Get the operating_system name
	if($u_agent) {
		if (preg_match('/linux/i', $u_agent)) {
			$operating_system = 'Linux';
		} elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
			$operating_system = 'Mac';
		} elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
			$operating_system = 'Windows';
		} elseif (preg_match('/ubuntu/i', $u_agent)) {
			$operating_system = 'Ubuntu';
		} elseif (preg_match('/iphone/i', $u_agent)) {
			$operating_system = 'IPhone';
		} elseif (preg_match('/ipod/i', $u_agent)) {
			$operating_system = 'IPod';
		} elseif (preg_match('/ipad/i', $u_agent)) {
			$operating_system = 'IPad';
		} elseif (preg_match('/android/i', $u_agent)) {
			$operating_system = 'Android';
		} elseif (preg_match('/blackberry/i', $u_agent)) {
			$operating_system = 'Blackberry';
		} elseif (preg_match('/webos/i', $u_agent)) {
			$operating_system = 'Mobile';
		}
	} else {
		$operating_system = php_uname('s');
	}
    
    return $operating_system;
}

function get_the_browser()
{
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
   return 'Internet explorer';
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)
    return 'Internet explorer';
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false)
   return 'Mozilla Firefox';
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
   return 'Google Chrome';
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false)
   return "Opera Mini";
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false)
   return "Opera";
 else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false)
   return "Safari";
 else
   return 'Other';
}
//============================================================================

?>
