<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Jersey+20&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <style>
* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  padding: 0;
  margin: 0;
}

#notfound {
  position: relative;
  height: 70vh;
  background: #030005;
}

#notfound .notfound {
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
      -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
}

.notfound {
  max-width: 767px;
  width: 100%;
  line-height: 1.4;
  text-align: center;
}

.notfound .notfound-404 {
  position: relative;
  height: 180px;
  margin-bottom: 20px;
  z-index: -1;
}

.notfound .notfound-404 h1 {
  font-family: 'Montserrat', sans-serif;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50% , -50%);
      -ms-transform: translate(-50% , -50%);
          transform: translate(-50% , -50%);
  font-size: 224px;
  font-weight: 900;
  margin-top: 0px;
  margin-bottom: 0px;
  margin-left: -12px;
  color: #030005;
  text-transform: uppercase;
  text-shadow: -1px -1px 0px #8400ff, 1px 1px 0px #ff005a;
  letter-spacing: -20px;
}


.notfound .notfound-404 h2 {
  font-family: "Jersey 20", sans-serif;
  font-style: normal;
  position: absolute;
  left: 0;
  right: 0;
  top: 100px;
  font-size: 42px;
  font-weight: 700;
  color: #fff;
  text-transform: uppercase;
  text-shadow: 0px 2px 0px red;
  letter-spacing: 13px;
  margin: 0;
}
		
.notfound .notfound-404 h4 {
    font-family: "Shadows Into Light", cursive;
  position: absolute;
  left: 0;
  right: 0;
  top: 180px;
  font-size: 20px;
  color: #fff;
  text-transform: capitalize;
  text-shadow: 0px 2px 2px 2px red;
  letter-spacing: 5px;
  margin: 0;
}

.notfound a {
  font-family: 'Montserrat', sans-serif;
  display: inline-block;
  text-transform: uppercase;
  color: #ff005a;
  text-decoration: none;
  border: 2px solid;
  background: transparent;
  padding: 10px 40px;
  font-size: 14px;
  font-weight: 700;
  -webkit-transition: 0.2s all;
  transition: 0.2s all;
}

.notfound a:hover {
  color: #8400ff;
}

@media only screen and (max-width: 767px) {
    .notfound .notfound-404 h2 {
        font-size: 24px;
    }
}

@media only screen and (max-width: 480px) {
  .notfound .notfound-404 h1 {
      font-size: 182px;
  }
} 
    </style>

</head>
<body>
<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>403</h1>
				<h2>akses terbatas</h2>
				<h4>silahkan hubungi administrator untuk dapat akses</h4>
			</div>
		</div>
	</div>

</body>
</html>
