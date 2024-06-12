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

require '../config/config.php';

function loadRec($loadField, $loadTbl, $loadWhere, $loadOrder, $typeView){

    $sql = "SELECT $loadField FROM $loadTbl";
    if(!empty($loadWhere)) { $sql.=" WHERE $loadWhere"; }
    if(!empty($loadOrder)){ $sql.=" ORDER BY $loadOrder"; }

    $rowLoad = '';
	$result = $GLOBALS['mysqli']->query($sql);
	$rowNum = $result->num_rows;
	
	while ($row = $result->fetch_assoc()) {
		/*
		$jns_id = $row['jns_id'];
		$jns_panjang = $row['jns_panjang'];
        //$rowLoad.="<li><a href=\"javascript:void()\" onClick=\"loadPageTwo('dg_aturan','$jns_id','$jns_panjang')\"><span class=\"sub-item\">$jns_panjang</span></a></li>";
		$rowLoad .= sidebarLi("goPage('models/fmPeraturan','Produk Hukum','$jns_panjang','$jns_id')","$jns_panjang");
		*/
		switch($typeView){
			//backend
			case 1:
				$jns_id = $row['jns_id'];
				$jns_pendek = $row['jns_pendek'];
				$jns_panjang = $row['jns_panjang'];
				$jns_type = $row['jns_type'];
				
				list($jns_page,$pTitle) = jnsID($jns_type);
                
                    $view = "<li><a href=\"javascript:void(0);\" onClick=\"goPage('$jns_page','$pTitle','$jns_panjang','$jns_id','$jns_pendek')\">$jns_panjang</a></li>";
				break;
			case 2:
				$opd_id = $row['opd_id'];
				$opd_pendek = $row['opd_pendek'];
				$opd_panjang = $row['opd_panjang'];
				
				$view = "<option value=\"$opd_id\">$opd_panjang</option>";
				break;
			case 3:
				$view = '
					<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
						<div class="da-card">
							<div class="da-card-photo">
								<img src="vendors/images/photo4.jpg" alt="">
								<div class="da-overlay">
									<div class="da-social">
										<ul class="clearfix">
											<li><a href="#"><i class="fa fa-facebook"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter"></i></a></li>
											<li><a href="#"><i class="fa fa-envelope-o"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="da-card-content">
								<h5 class="h5 mb-10">Don H. Rabon</h5>
								<p class="mb-0">Lorem ipsum dolor sit amet</p>
							</div>
						</div>
					</div>
				';
				break;
			case 4: //dashboard -> counting peraturan
				$name = $row['jns_panjang'];
				$ttl = $row['ttl_aturan'];
				$jml = 12/$row['jnsJml'];
				$view = '
					<div class="col-xl-'.$jml.' mb-30">
						<div class="card-box height-100-p widget-style1">
							<div class="d-flex flex-wrap align-items-center">
								<div class="widget-data">
									<div class="h4 mb-0">'.$ttl.'</div>
									<div class="weight-600 font-14">'.$name.'</div>
								</div>
							</div>
						</div>
					</div>
				';
				break;
			case 5: //dashboard -> graphic
				$name = $row['jns_panjang'];				
				$jns = $row['jns_id'];
				$mundur = 15;
				$Ynow = date('Y');
				$Ymin = $Ynow-$mundur;
				/*

	{
		name: 'Installation',
		data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
	}, {
		name: 'Manufacturing',
		data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
	},				
				
				*/
				
				$view = '{';
				$view .= 'name: "'.$name.'",';
				$view .= 'data: [';
				
				for($Y=$Ymin; $Y<=$Ynow; $Y++){
					$view .= loadRecText("COUNT(*)","p_aturan","jns_id=$jns AND atr_thn=$Y").',';

				}
				
				$view .= ']';
				$view .= '},';
				
				break;
            case 6:
                $kec_id = $row['kec_id'];
                $kec_name = $row['kec_name'];
                    //SELECT count(*) FROM p_desa WHERE kec_id='04' AND _active=3;
                $_active3 = loadRecText('count(*)', 'p_desa', 'kec_id='.$kec_id.' AND _active=3');
                $_active1 = loadRecText('count(*)', 'p_desa', 'kec_id='.$kec_id.' AND _active=1');
                
                
                    $view = "<li><a href=\"javascript:void(0);\" onClick=\"goPage('models/fmDesa','Produk Hukum','$kec_name','$kec_id','')\" class=\"d-flex justify-content-between\">$kec_name <span class=\"badge badge-warning\">$_active3</span></a></li>";
                
                break;
            case 7: //hak akses akun
                $ro_id = $row['ro_id'];
                $ro_name = $row['ro_name'];
                    //SELECT ro_id, ro_name FROM jdih.m_role
                
                    $view = '<option style="padding-bottom: 0;" value="'.$ro_id.'">'.$ro_name.'</option>';
                                
                break;
				
				
			//frontend
			case 11:
				//SELECT a.jns_id, a.jns_panjang, a.jns_pendek, (SELECT COUNT(*) FROM p_aturan WHERE jns_id=a.jns_id) AS record FROM m_aturan a WHERE a._active=1
				$jns_id = $row['jns_id'];
				$jns_pendek = $row['jns_pendek'];
				$jns_panjang = $row['jns_panjang'];
				$jns_type = $row['jns_type'];
				$rec = $row['record'];
				
				switch($jns_type){
					case 1:
							//$jns_page='views/listRegulation'; ur, pTitle, sTitle, _c1, _c2)
							$jns_page='listRegulation_Produk Hukum';
							$pTitle = 'Produk Hukum';
						break;
					case 2:
							//$jns_page='views/listBankum';
							$jns_page='listBankum_Bantuan Hukum';
							$pTitle = 'Bantuan Hukum';
						break;
					case 3:
							//$jns_page='views/listKajian';
							$jns_page='listKajian_Kajian Hukum';
							$pTitle = 'Kajian Hukum';
						break;
				}				
				
				$_href = $jns_page.'_'.$jns_panjang.'_'.$jns_id.'_';
				
				if($rec!=='0'){
					//$view = "<li><a href=\"javascript:void(0);\" onClick=\"goPage('$jns_page','$pTitle','$jns_panjang','$jns_id','')\">$jns_panjang</a></li>";
					//$view = "<li><a href=\"#$_href\" class=\"link\">$jns_panjang</a></li>";
					//$view = "<li><a href=\"#$_href\" class=\"link\">$jns_panjang</a></li>";
					//$view = "<li><a data-bs-toggle=\"modal\" data-bs-target=\"#myModal\" href=\"javascript:void(0)\" data-href="$_href">$jns_panjang</a></li>";
					$view = "<li><a onClick=\"openModal('$_href','$pTitle','$jns_panjang')\" href=\"javascript:void(0)\">$jns_panjang</a></li>";
				} else {
					$view = "";
				}
				break;
			case 12:
				switch($row['nws_type']){
					case 1:
						$_p1 = "Berita";
						break;
					case 2:
						$_p1 = "Artikel";
						break;
				}
				
				//$_href = "goPage('views/dtNewsArc', '$_p1', '', '$row[nws_type]', '$row[nws_id]')";
				$_href = "dtNewsArc_".$_p1."__".$row['nws_type']."_".$row['nws_id'];
				$view = '
                    <li class="clearfix">
                        <div class="widget-posts-title"><a href="#'.$_href.'">'.$row['nws_title'].'</a></div>
                        <div class="widget-posts-meta">'.tgl_pendek($row['_cre_date']).'</div>
                    </li>
				';
				
				
				break;
			case 13:
				$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
				$vname = loadRecText('jns_panjang', 'm_aturan', 'jns_id='.$row['jns_id'].' AND jns_type=1');
				//$_href = "goPage('views/dtRegulation', '$_p1', '$vname', '$row[jns_id]', '$row[atr_id]')";
				$_href = "dtRegulation_".$_p1."_".$vname."_".$row['jns_id']."_".$row['atr_id'];
                
				$view = '
						<tr>
							<td>'.$row['atr_no'].'</td>
							<td>'.$row['atr_thn'].'</td>
							<td>'.$row['atr_desk'].'</td>
							<td><a href="#'.$_href.'"><i class="bx bxs-low-vision"></i></a></td>
						</tr>
				';
				
				
				/*
							<td class="text-center"><a href="javascript:void(0);" onClick="'.$_href.'"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></td>
				$view = '
						<tr>
							<td>'.$row['atr_no'].'</td>
							<td>'.$row['atr_thn'].'</td>
							<td>'.$row['atr_desk'].'</td>
							<td>
								<a style="margin-right:20px" class="views" href="javascript:void(0);"
										title="'.$vname.' nomor '.$row['atr_no'].' tahun '.$row['atr_thn'].'" 
										postDate="'.tgl_panjang($row['_cre_date']).'" 
										id="'.$row['atr_id'].'">
									ssss
								</a>
							</td>
						</tr>				
				';
				*/
				
				break;
			case 14:
				//SELECT pro_id, pro_title, pro_desk, _active, _cre, _cre_date, _chg, _chg_date FROM set_pro WHERE 1
				$pro_id = $row['pro_id'];
				$pro_title = $row['pro_title'];
				
				$_href = 'dtProfil_Profil_'.$pro_title.'__'.$pro_id;

				$view = "<li><a href=\"#$_href\">$pro_title</a></li>";
				//$view = "<li><a href=\"javascript:void(0);\" onClick=\"goPage('views/dtProfil','Profil','','','$pro_id')\">$pro_title</a></li>";
				
				break;
			case 15://listbankum
				$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
				$vname = loadRecText('jns_panjang', 'm_aturan', 'jns_id='.$row['jns_id'].' AND jns_type=2');
				//$_href = "goPage('views/dtBankum', '$_p1', '$vname', '$row[jns_id]', '$row[atr_id]')";
				$_href = "dtBankum_".$_p1."_".$vname."_".$row['jns_id']."_".$row['atr_id'];

				$view = '
						<tr>
							<td><a href="#'.$_href.'">'.$row['atr_no'].'</a></td>
							<td><a href="#'.$_href.'">'.$row['atr_desk'].'</a></td>
						</tr>				
				';
				break;
			case 16:
				//SELECT img_id, sli_img, sli_title, sli_desk, _active, _cre, _cre_date, _chg, _chg_date FROM set_img WHERE 1
				$sli_img = 'HTTP://'.$_SERVER['SERVER_NAME'].'/upload/banner/'.$row['sli_img'];
				$sli_title = $row['sli_title'];
				$sli_desk = $row['sli_desk'];
                /*
				$view = '
                        <li class="bg-dark" style="background-image:url('.$sli_img.');">
                          <div class="container">
                            <div class="image-caption">
                              <h2 class="font-alt caption-text">'.$sli_title.'</h2>
                              <h3 class="font-alt mb-40 titan-title-size-1 fadeInUp">'.$sli_desk.'</h3>
                            </div>
                          </div>
                        </li>
				';*/
				$view = '
                  <div data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5" class="sl-slide bg-2">
                    <div style="background-image: url('.$sli_img.');background-repeat: no-repeat;background-size: cover;" class="sl-slide-inner">
                      <div class="container">
                        <h1 class="text-capitalize">'.$sli_title.'</h1>
                        <p>'.$sli_desk.'</p>
                      </div>
                    </div>
                  </div>
				';
				break;
			case 17:
				//SELECT sub_id, gal_id, sub_title, sub_file FROM p_subgal WHERE _active=1
				$sub_file = '/GPictures/'.$row['sub_file'];
				$sub_title = $row['sub_title'];
				$view = '
                          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                            <div class="portfolio-wrap">
                              <img src="'.$sub_file.'" class="img-fluid" alt="'.$sub_title.'">
                              <div class="portfolio-info">
                                <!--<h4>Card 2</h4>-->
                                <p>'.$sub_title.'</p>
                                <div class="portfolio-links">
                                  <a href="'.$sub_file.'" data-gallery="portfolioGallery" class="text-center portfolio-lightbox" title="'.$sub_title.'">
                                      <i class="bx bx-low-vision"></i>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
				';
				break;
			case 18:
				//SELECT team_nip, team_pic, team_name, team_jabatan, _active, _cre, _cre_date, _chg, _chg_date FROM set_team WHERE 1
				$team_pic = 'HTTP://'.$_SERVER['SERVER_NAME'].'/upload/team/'.$row['team_pic'];
				$team_nip = $row['team_nip'];
				$team_name = $row['team_name'];
				$team_jabatan = $row['team_jabatan'];
				$view = '
                          <div class="swiper-slide">
                            <div class="member" data-aos="fade-up" data-aos-delay="100">
                            
                                <div class="member-img"> 
                                    <img src="'.$team_pic.'" class="img-fluid img-thumbnail" alt="" width="100%">
                                    <div class="social p-1"> 
                                        <h7 class="text-white" style="text-shadow: 2px 2px 4px #000000">'.$team_name.'</h7>
                                        <hr class="text-white w-100 m-0">
                                        <p class="text-white" style="text-shadow: 2px 2px 4px #000000">'.$team_jabatan.'</p>
                                    </div>
                                </div>                          
                
                                <!--

                            
                            
                              <div class="member-img">
                                <img src="'.$team_pic.'" class="img-fluid" alt="">
                                <div class="social">
                                    <h4>'.$team_name.'</h4>
                                    <span>'.$team_jabatan.'</span>
                                </div>
                              </div>

                              <div class="member-info">
                                <h4>'.$team_name.'</h4>
                                <span>'.$team_jabatan.'</span>
                              </div>
                                -->
                              
                            </div>
                          </div>
				';
				break;
			case 19://listKajian
				$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
				$vname = loadRecText('jns_panjang', 'm_aturan', 'jns_id='.$row['jns_id'].' AND jns_type=3');
				//$_href = "goPage('views/dtBankum', '$_p1', '$vname', '$row[jns_id]', '$row[atr_id]')";
				$_href = "dtKajian_".$_p1."_".$vname."_".$row['jns_id']."_".$row['atr_id'];

				$view = '
						<tr>
							<td>'.$row['atr_no'].'</td>
							<td>'.$row['atr_desk'].'</td>
							<td><a href="#'.$_href.'"><i class="bx bxs-low-vision"></i></a></td>
						</tr>				
				';
				break;
			case 20:
				//SELECT link_id, link_title, link_des, _active, _cre, _cre_date, _chg, _chg_date FROM set_link WHERE  1
				$link_title = $row['link_title'];
				$link_des = $row['link_des'];
				
				$view = "<li><i class=\"bx bx-chevron-right\"></i><a href=\"$link_des\" target=\"_blank\">$link_title</a></li>";
				
				break;
            case 21:
				$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
				$vname = loadRecText('jns_panjang', 'm_aturan', 'jns_id='.$row['jns_id'].' AND jns_type=1');
				//$_href = "goPage('views/dtRegulation', '$_p1', '$vname', '$row[jns_id]', '$row[atr_id]')";
				$_href = "dtRegulation_".$_p1."_".$vname."_".$row['jns_id']."_".$row['atr_id'];
				$view = '( <a href="#'.$_href.'">'.$vname.' Nomor '.$row['atr_no'].' Tahun '.$row['atr_thn'].'</a> )';                
                break;
                
            //SEARCH
            case 22:
				//SELECT a.jns_id, a.jns_panjang, a.jns_pendek, (SELECT COUNT(*) FROM p_aturan WHERE jns_id=a.jns_id) AS record FROM m_aturan a WHERE a._active=1
				$jns_id = $row['jns_id'];
				$jns_pendek = $row['jns_pendek'];
				$jns_panjang = $row['jns_panjang'];
				$jns_type = $row['jns_type'];
				$rec = $row['record'];
								
				$_href = $jns_page.'_'.$jns_panjang.'_'.$jns_id.'_';
				
				if($rec!=='0'){
                    $view = "<option value=\"$jns_id\">$jns_panjang</option>";
				} else {
					$view = "";
				}
                break;
            case 23:
				$_p1	= isset($_REQUEST['_p1']) ? strval($_REQUEST['_p1']) : '';	
				//$_href = "goPage('views/dtRegulation', '$_p1', '$vname', '$row[jns_id]', '$row[atr_id]')";
				$_href = "dtGalery_".$_p1."_Foto_".$row['gal_type']."_".$row['gal_id'];
                //_Galeri%20Kegiatan_Foto_1_2022042102
				$view = '
						<tr>
							<td>'.tgl_pendek($row['_cre_date']).'</td>
							<td>'.$row['gal_title'].'</td>
							<td><a href="#'.$_href.'"><i class="bx bxs-low-vision"></i></a></td>
						</tr>
				';
                break;
            //START PRODUK HUKUM DESA
            //VIEW KECAMATAN
            case 24:
                $kec_id = $row['kec_id'];
                $kec_name = $row['kec_name'];
                
                    $view = "<li><a href=\"javascript:void(0);\" onClick=\"openDesa('$kec_id','Pilih Desa Di Kecamatan ','$kec_name')\">$kec_name</a></li>";                
                break;
            case 25:
                //SELECT a.id, a.satuan, a.nama, a.tgl_upload, a.uraian, a.jenis_peraturan, a.no_ditetapkan, a.tgl_ditetapkan, a.tahun, a.kec_id, a.desa_id, b.desa_id, b.kec_id, b.desa_name, b.desa_url FROM p_desa a LEFT JOIN m_desa b ON a.desa_id = b.desa_id
                $fl = $row['desa_url'].'/desa/upload/dokumen/'.$row['satuan'];
                $tt = $row['nama'];
                    
				$view = "
						<tr>
							<td>".$row['no_ditetapkan']."</td>
							<td>".$row['tgl_ditetapkan']."</td>
							<td>".$row['nama']."</td>
							<td>".$row['jenis_peraturan']."</td>
							<td><a href=\"javascript:void(0)\" onClick=\"openPDF('$fl','$tt')\"><i class=\"bi bi-eye h5 p-2\"></i></a></td>
						</tr>
				";                
                break;
		}
		
		$rowLoad .= $view;
	}
	
    return $rowLoad;
}

function jnsID($varID){
	switch($varID){
		case 1:
				$var01='models/fmPeraturan';
				$var02 = 'Produk Hukum';
			break;
		case 2:
				$var01='models/fmBankum';
				$var02 = 'Bantuan Hukum';
			break;
		case 3:
				$var01='models/fmKajian';
				$var02 = 'Kajian Hukum';
			break;
		case 4:
				$var01='models/fmSK';
				$var02 = 'Surat Keputusan';
			break;
	}
	return array($var01,$var02);
}

function updateOneField($loadField, $loadTbl, $loadWhere){
    
	$sql = "UPDATE $loadTbl AS t1, (SELECT $loadField FROM $loadTbl WHERE $loadWhere) as t2
				SET t1.$loadField = t2.$loadField+1 
				WHERE $loadWhere";
	
	$result = $GLOBALS['mysqli']->query($sql);
	
    return $rowLoad;
}

function updateField($setField, $setTbl, $setWhere){
	$sql = "UPDATE $setTbl
				SET $setField
				WHERE $setWhere";
	
	$result = $GLOBALS['mysqli']->query($sql);
	
    return $rowLoad;
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
	$cry = base64_encode(md5("pass@w0rd".trim($cry.'--JDIHN--')));

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