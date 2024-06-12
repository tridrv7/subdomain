<?php
require('../../conf/config.php');
require('../../conf/phpFunction.php');

$profile  =  $mysqli->query('SELECT * from pub_profile WHERE _active=1 ORDER BY _cre DESC');
$prof     = $profile->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT emp_id, parent FROM pub_employees WHERE parent!='' AND _active=1 AND jab_id IN (001,015,002) ORDER BY parent DESC";
//$sql = "SELECT emp_id, parent FROM pub_employees WHERE parent!='' AND _active=1 ORDER BY parent DESC";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
	$json = [];
	while($row1 = $result->fetch_assoc()) {
		//echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["amount"]. "<br>";
		$json[]=[(string)$row1["parent"] , (string)$row1["emp_id"]];

	}
} else {
    echo "0 results";
}

$sqlPerson = "SELECT emp_id, emp_nm, emp_img, jab_id, dept_id, parent FROM pub_employees WHERE _active=1 AND jab_id IN (001,015,002) ORDER BY jab_id";
$resultPerson = $mysqli->query($sqlPerson);

$json_arr = array();
while($row = $resultPerson->fetch_assoc()) {
	
    $row_arr['id'] = $row['emp_id'];
	/*
	if($row['jab_id']){
		$jab = loadRecText('jab_nm', 'set_jabdept', 'jab_id="'.$row['jab_id'].'" AND stat=1');
	} else {
		$jab = '';
	}
	*/
	
	if($row['jab_id']=='001'){
		$row_arr['layout'] = '';
		$jab = loadRecText('jab_nm', 'set_jabdept', 'jab_id="'.$row['jab_id'].'" AND stat=2');
		
		/*
		if($row['jab_id']='002'){
			$row_arr['column'] = '1';
			$row_arr['offset'] = '75%';
		}
		if(strpos("'001', '002', '015'", $row['jab_id']) != true) {
			$row_arr['layout'] = 'hanging';
		} else {
			$row_arr['layout'] = '';
		}
		
		if($row['jab_id']='001'){
		}else if($row['jab_id']='002'){
		}else if($row['jab_id']='015'){
		}else{
			$row_arr['layout'] = 'hanging';
		}
		*/
	}else{
		
		if($row['jab_id']=='015'){
			$row_arr['column'] = '2';
		}
		
		
		$row_arr['layout'] = 'hanging';
		$jab = loadRecText('jab_nm', 'set_jabdept', 'jab_id="'.$row['jab_id'].'" AND stat=2');
	}
	
    $row_arr['title'] = $jab;
    $row_arr['name'] = $row['emp_nm'];
    $row_arr['jab_id'] = $row['jab_id'];
    //$row_arr['image'] = $row['emp_img'];
    $row_arr['image'] = $rLink.$_dirEmp.$row['emp_img'];
	//SELECT `emp_id`, `emp_nip`, `emp_nm`, `emp_desk`, `emp_ent`, `emp_lhkpn`, `emp_img`, `jab_id`, `dept_id`, `parent` FROM `pub_employees` WHERE 1
	
    array_push($json_arr,$row_arr);
}

//$hChart = 120*loadRecText('count(jab_id)', 'set_jabdept', 'stat=2 AND _active=1');
$hChart = 120*3;
$jsonDataStrOrg = json_encode($json);
$jsonDataPerson = json_encode($json_arr);
//echo $jsonDataStrOrg.'<br><br>';
//echo $jsonDataPerson;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= $src?>">

  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="images/sidoarjo.png">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="../css/aos.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/highcharts-organisation/style.css">

  <title><?= $prof[0]['prof_lnm']?></title>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="100">


  <?php 
    require_once('../views/navbar.php');
    require_once('../views/social.php');
  ?>
  

  <div class="untree_co-hero mb-0" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="dots"></div>
          <div class="row justify-content-center">
            <div class="col-md-7 text-center">
              <h2 class="heading" data-aos="fade-up" data-aos-delay="0">STRUKTUR ORGANISASI</h2>
              <!--<h5 data-aos="fade-up" data-aos-delay="0"><?= ucwords($prof[0]['prof_lnm'])?></h5>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-start align-items-center">
        <div class="col-12">
			<!-- partial:index.partial.html -->
			<div id="container" class="mr-4 ml-4"></div>
			<!-- partial -->
		</div>
    </div>
  </div>
  <?php require_once('../views/footer.php')?>

  

  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="../js/jquery-3.4.1.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/jquery.animateNumber.min.js"></script>
  <script src="../js/jquery.waypoints.min.js"></script>
  <script src="../js/jquery.fancybox.min.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/custom.js"></script>
  
<script src="../js/highcharts-organisation/highcharts.js"></script>
<script src="../js/highcharts-organisation/sankey.js"></script>
<script src="../js/highcharts-organisation/organization.js"></script>
<script src="../js/highcharts-organisation/exporting.js"></script>
<script src="../js/highcharts-organisation/accessibility.js"></script>
<script>


	
	
var protoSetState = Highcharts.Point.prototype.setState;

Highcharts.wrap(Highcharts.seriesTypes.organization.prototype, 'pointAttribs', function(p, point, state) {

  var attrs = p.apply(this, Array.prototype.slice.call(arguments, 1));

  if (state === 'inactive') {
    attrs.opacity = 0.2;
  } else {
    attrs.opacity = 1;
  }

  return attrs;
});


Highcharts.seriesTypes.organization.prototype.pointClass.prototype.setState = function(state) {
  var args = arguments;

	// Propagate state to children:
  setChildrenState(this.isNode ? this : this.fromNode);
  
  // Uncomment below to show parents too:
  setParentState(this.isNode ? this : this.toNode);

  function setChildrenState(node) {
    node.linksFrom.forEach(function(link) {
      if (link.toNode) {
        setChildrenState(link.toNode);
      }
    });

    protoSetState.apply(node, args);
  }

  function setParentState(node) {
    node.linksTo.forEach(function(link) {

      if (link.fromNode) {
        setParentState(link.fromNode);
      }
    });

    protoSetState.apply(node, args);
  }
};


Highcharts.chart('container', {
    chart: {
        height: '<?=$hChart?>',
        inverted: true
    },

    title: {
		useHTML: true,
        text: '<?=ucwords($prof[0]['prof_lnm'])?>'
    },

    accessibility: {
        point: {
            descriptionFormatter: function (point) {
                var nodeName = point.toNode.name,
                    nodeId = point.toNode.id,
                    nodeDesc = nodeName === nodeId ? nodeName : nodeName + ', ' + nodeId,
                    parentDesc = point.fromNode.id;
                return point.index + '. ' + nodeDesc + ', reports to ' + parentDesc + '.';
            }
        }
    },

    series: [{
        type: 'organization',
        name: '<?= $prof[0]['prof_lnm']?>',
        keys: ['from', 'to'],
		data: <?=$jsonDataStrOrg?>,
		nodes: <?=$jsonDataPerson?>,
        colorByPoint: false,
        dataLabels: {
            color: 'white'
        },
        borderColor: 'white',
        nodeWidth: 55,
		nodePadding: 5,
		hangingIndent: 15,
		hangingIndentTranslation: 'shrink',
    }],
    tooltip: {
        outside: true,
    },
    exporting: {
        allowHTML: true,
        sourceWidth: 800,
        sourceHeight: 600
    }

});	
</script>

</body>
</html>
