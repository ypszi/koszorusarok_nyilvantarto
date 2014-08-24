<html !doctype>
<head>
<link href="css/orderstyle.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/alertwindow.css" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<!-- http://igorescobar.github.io/jQuery-Mask-Plugin/ -->
<style type="text/css">
#new_offer {
	display: none;
	padding: 5px 5px 5px 15px;
	border-radius: 5px;
	width: 850px;
	height: 570px;
	position: fixed;
	margin: 0px auto;
	left: 8%;
	top: 2%;
	box-shadow: 5px 5px 5px #555;
	background: #c9dba6;
	background: -moz-linear-gradient(top, #c9dba6 0%, #7a9d74 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#c9dba6), color-stop(100%,#7a9d74));
	background: -webkit-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: -o-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: -ms-linear-gradient(top, #c9dba6 0%,#7a9d74 100%);
	background: linear-gradient(to bottom, #FBFFF2 0%,#C3D5C0 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c9dba6', endColorstr='#7a9d74',GradientType=0 );
	z-index: 5;
	}

	#new_offer > h1 {
		color: #fff;
		font-size: 21px;
		/*margin-top: 30px;
		margin-bottom: 40px;
		margin-left: 65px;
		margin-right: 70px;*/
	}
</style>
	<script type="text/javascript" src="js/protea_functions.js"></script>
</head>
<body onLoad="toStep1();">
	<?php
		$_SESSION['wreathNum'] = 0;
		$_SESSION['offerNum'] = 0;

		$_SESSION['wreath'] = "";
		$_SESSION['wreath_preview_src'] = "";
		$_SESSION['azonosito'] = "";
		$_SESSION['givers'] = "";

		$_SESSION["isRibbon"] = "";
		$_SESSION["ribbon"] = "";
		$_SESSION["ribboncolor"] = "";
		$_SESSION["farewelltext"] = "";
		$_SESSION['wreathNum'] = 0;

		$_SESSION['offer'] = "";
		$_SESSION['offerazonosito'] = "";
		$_SESSION['offergivers'] = "";

		$_SESSION["isOfferribbon"] = "";
		$_SESSION["offerribbon"] = "";
		$_SESSION["offerribboncolor"] = "";
		$_SESSION["offerfarewell"] = "";
		$_SESSION['offerNum'] = 0;

		$_SESSION['curr_wreath_type'] = "";


		$_SESSION['dead_name'] = "";
		$_SESSION['ritual_date'] = "";
		$_SESSION['ritual_time'] = "";
		$_SESSION['shipment'] = "";
		$_SESSION['clocation'] = "";
		$_SESSION['caddress'] = "";
		$_SESSION['cfuneral'] = "";

		$_SESSION['customer_name'] = "";
		$_SESSION['phone_num'] = "";
		$_SESSION['email'] = "";

		$_SESSION['paid'] = "";
		$_SESSION['ship_price'] = "";
		$_SESSION['price'] = 0;
		$_SESSION['downprice'] = 0;
		$_SESSION['remainder'] = 0;
		
		$_SESSION['order_note'] = "";
		$_SESSION['shopname'] = "";

		$_SESSION["generated_id"] = null;

	?>
<div class="title">
	<span class="firstWord"> Új </span> Megrendelés
</div>

	<div id="order_steps_div">
		<ul id="order_steps" class="step1" style="background-position: 50% 0%">
			<li id="ord_step1" class="step_current" style="cursor: default" onClick="">
				<span>Koszorú </span>
			</li>
			<li id="ord_step2" class="step_todo" style="cursor: default" onClick="">
				<span>Megrendelő adatok </span>
			</li>
			<li id="ord_step3" class="step_todo" style="cursor: default" onClick="">
				<span>Összegzés </span>
			</li>
		</ul>
	</div>

	<div id="alertwindow"></div>

	<div id="new_offer" style="z-index: 6; overflow-x: hidden; overflow-y: scroll;">
	</div>
	
	<div id="ordertable">
	</div>
</body>
</html>