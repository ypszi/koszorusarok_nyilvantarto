	function visibility(param) {
		var visible = param;
		if (visible) {
			document.getElementById('login').style.display = 'block';
			$("#login_password").focus();
		}
		else {
			document.getElementById('login').style.display = 'none';
		}
	}

	function pw_reset(user_id) {
		$.ajax({
				type: "GET",
				url: "pw_reset.php?user_id=" + user_id,
				success: function(data){
				$("#alertwindow").html(data);
				}
			});
	}

	///////////////// OFFERFORM.PHP /////////////////

		function loadBaseWreathSizes_oForm(from, to) {
			var base_wreath_type = document.getElementById(from).value;

			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/base_wreath_sizes.php?base_wreath_type=" + base_wreath_type,
				success: function(data){
				document.getElementById(to).disabled = "";
				$("#"+to).html(data);
				}
			});
		}

		function leftForUs() {
			$(".toHide").toggle();
			$("#flower").toggle();
			$("#leaf").toggle();
			$("#rezgotable").toggle();

			if($('#left_for_us').prop('checked')) {
				$("#fullprice").attr("onchange","componentPrice()");
				$("#calced_price").html(' Összetevőkre szánt összeg: ');
				$("#copy_price").css('display', 'none');
				$("#kiertekeles").attr("onclick","componentPrice()");
			} else {
				$("#fullprice").attr("onchange","");
				$("#calced_price").html(' Kalkulált ár: ');
				$("#copy_price").css('display', 'inline-block');
				$("#kiertekeles").attr("onclick","calcFullPrice_oForm()");
			}
		}

		function componentPrice() {
			var calced_price = document.getElementById("orig_wreathprice").value;
			calced_price = calced_price.replace(/\s+/g, ''); //kiszedi a space karaketereket
			calced_price = calced_price.replace("Ft", ''); //kiszedi a "Ft"-ot
			var component_price = parseInt($("#fullprice").val()) - parseInt(calced_price);
			component_price = addSpaces(component_price) + " Ft";
			$("#wreath_price").val(component_price);
		}

		function isLeftForUs() {
			var isleftForUs = document.getElementById('left_for_us').checked;
			return isleftForUs;
		}

		function addFlowerRow_oForm() {
			var xmlhttp;
			var flowernum = document.getElementById('flowernum').value;
			flowernum++;
			document.getElementById('flowernum').value = flowernum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = document.getElementById('flower').insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-offer-submenu/new-offer/flowerrow.php?flowernum="+flowernum,true);
			xmlhttp.send();
		}

		function remFlowerRow_oForm() {
			var rowCount = $('#flower tr').length;
			if (rowCount > 2) {
				document.getElementById('flower').deleteRow(-1);
				var flowernum = document.getElementById('flowernum').value;
				flowernum--;
				document.getElementById('flowernum').value = flowernum;
			}
		}

		function addLeafRow_oForm() {
			var xmlhttp;
			var leafnum = document.getElementById('leafnum').value;
			leafnum++;
			document.getElementById('leafnum').value = leafnum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = document.getElementById('leaf').insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-offer-submenu/new-offer/leafrow.php?leafnum="+leafnum,true);
			xmlhttp.send();
		}

		function remLeafRow_oForm() {
			var rowCount = $('#leaf tr').length;
			if (rowCount > 2) {
				document.getElementById('leaf').deleteRow(-1);
				var leafnum = document.getElementById('leafnum').value;
				leafnum--;
				document.getElementById('leafnum').value = leafnum;
			}
		}

		function writeWPrice_oForm() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/wsubtotal.php",
				success: function(data){
				$("#wsubtotal").html(data);
				}
			}); }, 200);
		}
		function writeFPrice_oForm() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/fsubtotal.php",
				success: function(data){
				$("#fsubtotal").html(data);
				}
			}); }, 200);
		}
		function writeLPrice_oForm() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/lsubtotal.php",
				success: function(data){
				$("#lsubtotal").html(data);
				}
			}); }, 200);
		}
		function writeRPrice_oForm() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/rsubtotal.php",
				success: function(data){
				$("#rsubtotal").html(data);
				}
			}); }, 200);
		}

		function offerribbonEnable() {
			var isEnabled = document.getElementById('isOfferribbon').checked;
			document.getElementById("offerribbon").disabled = "";
			document.getElementById("offerribboncolor").disabled = "";
			document.getElementById("offerfarewell").disabled = "";
			document.getElementById("offergivers").disabled = "";
			if (isEnabled == "") {
				document.getElementById("offerribbon").disabled = "disabled";
				document.getElementById("offerribboncolor").disabled = "disabled";
				document.getElementById("offerfarewell").disabled = "disabled";
				document.getElementById("offergivers").disabled = "disabled";
			}
			calculatePrice_oForm();
			writeRPrice_oForm();
		}

		function RibbonPrice() {
			var isOfferribbon = document.getElementById('isOfferribbon').checked;
			var ribbontype = $('#offerribbon').val();
			var ribboncolor = $('#offerribboncolor').val();
			var fwtext = $('#offerfarewell').val();
			var givers = document.getElementById('offergivers').value;

			if (isOfferribbon) {
				$.ajax({
					type: "GET",
					url: "menu-main/menu-offer-submenu/new-offer/ribbonitemprice.php?ribbontype="+ribbontype+"&ribboncolor="+ribboncolor,
					success: function(data){
						$("#ribbonprice").val(data);
						calculatePrice_oForm();
						writeRPrice_oForm();
					}
				});
			}
		}

		function calculatePrice_oForm() {
			var wtype = document.getElementById('base_wreath_type').value;
			var wsize = document.getElementById('base_wreath_size').value;

			if (!isLeftForUs()) { // szerkesztésnél fontos -> ha nincs ránk bízva, akkor kell inicializálni ezeket
				var fname = new Array();
				var fcolor = new Array();
				var qty = new Array();
				var flowernum = document.getElementById('flowernum').value;
				var fitemprice = new Array();

				var leafcolor = new Array();
				var leafqty = new Array();
				var leafnum = document.getElementById('leafnum').value;
				var litemprice = new Array();

				var rezgo = document.getElementById('rezgo').checked;
				var rezgoqty = document.getElementById('rezgoqty').value;
			}

			var isOfferribbon = document.getElementById('isOfferribbon').checked;
			var offerribbon = document.getElementById('offerribbon').value;
			var offerribboncolor = document.getElementById('offerribboncolor').value;
			var ritemprice = document.getElementById('ribbonprice').value;

			if (!isLeftForUs()) { // szerkesztésnél fontos -> ha nincs ránk bízva, akkor kell inicializálni ezeket
				var ftable = document.getElementById("flower");
				var fselects = ftable.getElementsByTagName("select");
				var frowNums = (fselects.length)/2;
				var ltable = document.getElementById("leaf");
				var lselects = ltable.getElementsByTagName("select");
				var lrowNums = lselects.length;
			}

			var query1 = new Array();
			var query2 = new Array();
			var query3 = new Array();
			var query4 = new Array();
			var query5 = new Array();
			var query6 = new Array();
			var query7 = new Array();

			var ind = 0;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				qty[ind] = document.getElementById("qty"+ind);
				fitemprice[ind] = document.getElementById('itemprice'+ind);

				query1.push(encodeURIComponent(fname[ind].getAttribute('id')) + '=' + encodeURIComponent(fname[ind].value));
				query2.push(encodeURIComponent(fcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(fcolor[ind].value));
				query3.push(encodeURIComponent(qty[ind].getAttribute('id')) + '=' + encodeURIComponent(qty[ind].value));
				query6.push(encodeURIComponent(fitemprice[ind].getAttribute('id')) + '=' + encodeURIComponent(fitemprice[ind].value));

				ind++;
			};

			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);
				litemprice[ind] = document.getElementById('leafitemprice'+ind);

				query4.push(encodeURIComponent(leafcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(leafcolor[ind].value));
				query5.push(encodeURIComponent(leafqty[ind].getAttribute('id')) + '=' + encodeURIComponent(leafqty[ind].value));
				query7.push(encodeURIComponent(litemprice[ind].getAttribute('id')) + '=' + encodeURIComponent(litemprice[ind].value));

				ind++;
			};

			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/calculate.php?wtype="+ wtype + "&wsize=" + wsize + "&"
				+ query1.join('&') + '&' + query2.join('&') + '&'
				+ query3.join('&') + '&' + query6.join('&') + "&flowernum=" + flowernum + '&'
				+ query4.join('&') + '&' + query5.join('&') + '&'
				+ query7.join('&') + "&leafnum=" + leafnum
				+ "&rezgo=" + rezgo + "&rezgoqty=" + rezgoqty
				+ "&isOfferribbon=" + isOfferribbon + "&offerribbon=" + offerribbon + "&offerribboncolor=" + offerribboncolor + "&ribbonprice=" + ritemprice,
				success: function(data){
					$(".toLoad_wreathPrice").val(data);
					$(".toLoad_wreathPrice").val(data);
				}
			});
		}

		function calcFullPrice_oForm() {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/fullprice.php",
				success: function(data){
					$("#fullprice").val(data);
				}
			});
		}

		function rezgoqtyEnable_oForm() {
			var isEnabled = document.getElementById('rezgo').checked;
			document.getElementById("rezgoqty").disabled = "";
			if (isEnabled == "") {
				document.getElementById("rezgoqty").disabled = "disabled";
			}
		}

		function dataCheck_oForm(is_Shopselect) {
			var alertwindow = document.getElementById('alertwindow');
			if (is_Shopselect) {
				var shop_select = document.getElementById('shop_select').value;
			}
			var wreath_name = document.getElementById('wreath_name').value;
			var base_wreath_type = document.getElementById('base_wreath_type').value;
			var base_wreath_size = document.getElementById('base_wreath_size').value;
			var fname = new Array();
			var fcolor = new Array();
			var fqty = new Array();
			var leafcolor = new Array();
			var leafqty = new Array();
			var rezgoqty = document.getElementById('rezgoqty').value;
			var isOfferribbon = document.getElementById('isOfferribbon').checked;
			var ribbontype = $('#offerribbon').val();
			var ribboncolor = $('#offerribboncolor').val();
			var fwtext = $('#offerfarewell').val();
			var givers = document.getElementById('offergivers').value;
			var note = document.getElementById('note').value;
			var wreathprice = document.getElementById('wreath_price').value;
			var endprice = document.getElementById('fullprice').value;
			var ind = 0;
			var ftable = document.getElementById("flower");
			var fselects = ftable.getElementsByTagName("select");
			var frowNums = (fselects.length)/2;
			var ltable = document.getElementById("leaf");
			var lselects = ltable.getElementsByTagName("select");
			var lrowNums = lselects.length;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				fqty[ind] = document.getElementById("qty"+ind);
			};
			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);
			};

			if (isLeftForUs()) {
				if (shop_select == "") {
					alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
					alertwindow.style.display = "block";
					setTimeout('alertwindow.style.display = "none";', 1000);
					return false;
				} else {
					if (wreath_name == "") {
						alertwindow.innerHTML = '<h1>Üres mező: Koszorú név!</h1>';
						alertwindow.style.display = "block";
						setTimeout('alertwindow.style.display = "none";', 1000);
						return false;
					} else {
						if (base_wreath_type == "") {
							alertwindow.innerHTML = '<h1>Üres mező: Koszorú alap!</h1>';
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (base_wreath_size == "") {
								alertwindow.innerHTML = '<h1>Üres mező: Koszorú méret!</h1>';
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (isOfferribbon) {
									if (ribbontype == null) {
										alertwindow.innerHTML = '<h1>Nem választott szalagot!</h1>';
										alertwindow.style.display = "block";
										setTimeout('alertwindow.style.display = "none";', 1000);
										return false;
									} else {
										if (ribboncolor == null) {
											alertwindow.innerHTML = '<h1>Nem választott szalag színt!</h1>';
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										} else {
											if (endprice == "") {
												alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
												alertwindow.style.display = "block";
												setTimeout('alertwindow.style.display = "none";', 1000);
												return false;
											} else {
												return true;
											}
										}
									}
								} else {
									if (endprice == "") {
										alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
										alertwindow.style.display = "block";
										setTimeout('alertwindow.style.display = "none";', 1000);
										return false;
									} else {
										return true;
									}
								}
							}
						}
					}
				}
			} else {
				if (is_Shopselect) {
					if (shop_select == "") {
						alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
						alertwindow.style.display = "block";
						setTimeout('alertwindow.style.display = "none";', 1000);
						return false;
					} else {
						if (wreath_name == "") {
							alertwindow.innerHTML = '<h1>Üres mező: Koszorú név!</h1>';
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						}
						else {
							if (base_wreath_type == "") {
								alertwindow.innerHTML = '<h1>Üres mező: Koszorú alap!</h1>';
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (base_wreath_size == "") {
									alertwindow.innerHTML = '<h1>Üres mező: Koszorú méret!</h1>';
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								} else {
									if (fname[1].value == "") {
										alertwindow.innerHTML = '<h1>Üres mező: Virág típus!</h1>';
										alertwindow.style.display = "block";
										setTimeout('alertwindow.style.display = "none";', 1000);
										return false;
									} else {
										if (fcolor[1].value == "") {
											alertwindow.innerHTML = '<h1>Üres mező: Virág szín!</h1>';
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										} else {
											if (isOfferribbon) {
												if (ribbontype == null) {
													alertwindow.innerHTML = '<h1>Nem választott szalagot!</h1>';
													alertwindow.style.display = "block";
													setTimeout('alertwindow.style.display = "none";', 1000);
													return false;
												} else {
													if (ribboncolor == null) {
														alertwindow.innerHTML = '<h1>Nem választott szalag színt!</h1>';
														alertwindow.style.display = "block";
														setTimeout('alertwindow.style.display = "none";', 1000);
														return false;
													} else {
														if (endprice == "") {
															alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
															alertwindow.style.display = "block";
															setTimeout('alertwindow.style.display = "none";', 1000);
															return false;
														} else {
															return true;
														}
													}
												}
											} else {
												if (endprice == "") {
													alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
													alertwindow.style.display = "block";
													setTimeout('alertwindow.style.display = "none";', 1000);
													return false;
												} else {
													return true;
												}
											}
										}
									}
								}
							}
						}
					}
				} else {
					if (wreath_name == "") {
						alertwindow.innerHTML = '<h1>Üres mező: Koszorú név!</h1>';
						alertwindow.style.display = "block";
						setTimeout('alertwindow.style.display = "none";', 1000);
						return false;
					}
					else {
						if (base_wreath_type == "") {
							alertwindow.innerHTML = '<h1>Üres mező: Koszorú alap!</h1>';
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (base_wreath_size == "") {
								alertwindow.innerHTML = '<h1>Üres mező: Koszorú méret!</h1>';
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (fname[1].value == "") {
									alertwindow.innerHTML = '<h1>Üres mező: Virág típus!</h1>';
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								}
								else {
									if (fcolor[1].value == "") {
										alertwindow.innerHTML = '<h1>Üres mező: Virág szín!</h1>';
										alertwindow.style.display = "block";
										setTimeout('alertwindow.style.display = "none";', 1000);
										return false;
									}
									else {
										if (endprice == "") {
											alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										}
										else {
											return true;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		function copyprice() {
			var calced_price = document.getElementById('wreath_price').value;
			document.getElementById('fullprice').value = calced_price;
		}

		function wreathfromcatalog(id) {
			var catalog = document.getElementById('from_catalog');
			var params = window.location.search.replace("?", "");
			if (catalog.checked) {
				$.ajax({
					type: "GET",
					url: (params == "page=ajanlatok&subpage=uj_ajanlat")?"menu-main/menu-offer-submenu/new-offer/catalogwreath.php?offer_div=right-content&ajanlat_id="+id:"menu-main/menu-offer-submenu/new-offer/catalogwreath.php?offer_div=new_offer&ajanlat_id="+id,
					success: function(data){
					$("#wreath_from_catalog").html(data);
					}
				});
				$("#wreath_from_catalog").toggle();
			} else {
				$("#wreath_from_catalog").toggle();
				$("#prev_img_catwreath").toggle();
			}
		}

		function make_new_offer(id) {
			var dataChecked = dataCheck_oForm(true);
			if (dataChecked) {
				$.ajax({
					type: "POST",
					url: "menu-main/menu-offer-submenu/new-offer/newoffer.php?ajanlat_id="+id,
					data: $("#wreathform").serialize(),
					success: function(data){
						$("#alertwindow").html(data);
					}
				});
			}
		}

		function update_offer(subpage) {
			var dataChecked = dataCheck_oForm(true);
			if (dataChecked) {
				$.ajax({
					type: "POST",
					url: "menu-main/menu-offer-submenu/new-offer/offermod.php?subpage="+subpage,
					data: $("#wreathform").serialize(),
					success: function(data){
						$("#alertwindow").html(data);
					}
				});
			}
		}

		function loadWreathimg(wname) {
			var wreath_name = wname.value;

			$.ajax({
				type: "GET",
				url: "menu-main/menu-order-submenu/new-order/wreathimg.php?wreath_name=" + wreath_name,
				success: function(data){
				$('#hidd_prev_img_catwreath').val(data);
				$('#prev_img_catwreath').attr('src',data);
				$('#prev_img_catwreath').width("80");
 				$('#prev_img_catwreath').css('visibility', 'visible');
				}
			});
		}

	///////////////// OFFERFORM.PHP VÉGE /////////////////

	///////////////// NEW_ORDER.PHP /////////////////

	function toStep1(back) {
			document.getElementById('order_steps').style.backgroundPosition = "50% 0%";

			$("#ord_step1").unbind( "click" );
			$("#ord_step2").unbind( "click" );
			$("#ord_step3").unbind( "click" );

			$("#ord_step1").css("cursor", "default");
			$("#ord_step2").css("cursor", "default");
			$("#ord_step3").css("cursor", "default");

		var isBack = (!back) ? "" : "?back=true";

		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/orderstep1.php" + isBack,
			data: (!back) ? "" : $("#step2").serialize(),
			success: function(data){
				$("#ordertable").html(data);
				$.getScript("js/protea_functions.js");
			}
		});
	}

	function toStep2(back) {
			document.getElementById('order_steps').style.backgroundPosition = "50% 50%";

			$("#ord_step1").unbind( "click" );
			$("#ord_step2").unbind( "click" );
			$("#ord_step3").unbind( "click" );


			$("#ord_step1").bind( "click", function(){
				toStep1(true);
			});

			$("#ord_step1").css("cursor", "pointer");
			$("#ord_step2").css("cursor", "default");
			$("#ord_step3").css("cursor", "default");


		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/orderstep2.php",
			data: (!back) ? $("#step1").serialize() : "back=true",
			success: function(data){
				$("#ordertable").html(data);
				$.getScript("js/protea_functions.js");
				$(document).ready(function(){
				  $('#phone_num').mask('+36 00 000 0000', {'translation': {3: '3', 6: '6'}});
				});
				var isPaid = $('#paid').is(':checked');
				if (!isPaid) {
					calcRemainder();
				}
				calcSumm();
			}
		});
	}

	function toStep3() {
			document.getElementById('order_steps').style.backgroundPosition = "50% 100%";

			$("#ord_step1").unbind( "click" );
			$("#ord_step2").unbind( "click" );
			$("#ord_step3").unbind( "click" );


			$("#ord_step1").bind( "click", function(){
				toStep1(true);
			});
			$("#ord_step2").bind( "click", function(){
				toStep2(true);
			});

			$("#ord_step1").css("cursor", "pointer");
			$("#ord_step2").css("cursor", "pointer");
			$("#ord_step3").css("cursor", "default");

		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/orderstep3.php",
			data: $("#step2").serialize(),
			success: function(data){
				$("#ordertable").html(data);
				$.getScript("js/protea_functions.js");
			}
		});
	}

	function order() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/order.php",
			success: function(data){
			$("#ordertable").html(data);
			}
		});
	}

	///////////////// ORDERSTEP 1-hez /////////////////

	function addWreath() {
		var xmlhttp;
		var wtableRef = document.getElementById('ord_wreath');
		if ($('#wreath_type1').val() == null && $('#wreath_type1').length != 0 && $('#wreathnum').val() <= 1) {
			alertwindow.innerHTML = "<h1>Először az első koszorút válassza ki!</h1>";
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
		} else {
			var newRow = wtableRef.insertRow(-1);
			var lastRowIndex = wtableRef.rows.length-1;

			var wreathnum = document.getElementById('wreathnum').value;
			var offernum = document.getElementById('offernum').value;

			wreathnum++;
			document.getElementById('wreathnum').value = wreathnum;
			$.ajax({
				type: "GET",
				url: "menu-main/menu-order-submenu/new-order/wreathrow.php?wreathnum="+wreathnum,
				success: function(data){
				$(newRow).html(data);
				$.getScript("js/protea_functions.js");
				}
			});
		}
	}
	function remWreathRow() {
		var rowCount = $('#ord_wreath tr').length;
		var wtableRef = document.getElementById('ord_wreath');
		if (rowCount > 2) {
			wtableRef.deleteRow(-1);
			var wreathnum = document.getElementById('wreathnum').value;
			if (wreathnum > 0) {
				wreathnum--;
			}
			document.getElementById('wreathnum').value = wreathnum;
		}
		$.getScript("js/protea_functions.js");
	}

	function addOffer() {
		var offtableRef = document.getElementById('ord_offer');
		var lastRowIndex = offtableRef.rows.length-1;
		if ($('#offer1').val() == null && $('#offer1').length != 0 && $('#offernum').val() <= 1) {
			alertwindow.innerHTML = "<h1>Először az első ajánlatot válassza ki!</h1>";
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
		} else {
			var newRow = offtableRef.insertRow(-1);
			var wreathnum = document.getElementById('wreathnum').value;
			var offernum = document.getElementById('offernum').value;

			offernum++;
			document.getElementById('offernum').value = offernum;
			$.ajax({
				type: "GET",
				url: "menu-main/menu-order-submenu/new-order/offerrow.php?offernum="+offernum,
				success: function(data){
				$(newRow).html(data);
				$.getScript("js/protea_functions.js");
				}
			});
		}
	}
	function remOfferRow() {
		var rowCount = $('#ord_offer tr').length;
		var offtableRef = document.getElementById('ord_offer');
		if (rowCount > 3) { // 9 = Az ord_offer táblában 1 fenti tr + 1 tr az első ord_offers tábla + ord_offers táblában 7 tr
			offtableRef.deleteRow(-1);
			var offernum = document.getElementById('offernum').value;
			if (offernum > 0) {
				offernum--;
			}
			document.getElementById('offernum').value = offernum;
		}
		$.getScript("js/protea_functions.js");
	}
	function ribbonEnable(id) {
		id = id.substring(8, 9); //1
		var isEnabled = document.getElementById('isRibbon'+id).checked;
		document.getElementById("ribbon"+id).disabled = "";
		document.getElementById("ribboncolor"+id).disabled = "";
		document.getElementById("farewelltext"+id).disabled = "";
		if (isEnabled == "") {
			document.getElementById("ribbon"+id).disabled = "disabled";
			document.getElementById("ribboncolor"+id).disabled = "disabled";
			document.getElementById("farewelltext"+id).disabled = "disabled";
		}
	}

	function loadWreathimg(wname, id) {
		var wreath_name = wname.value;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/wreathimg.php?wreath_name=" + wreath_name,
			success: function(data){
			$('#wreath_preview_src'+id).val(data);
			$('#wreath_preview'+id).attr('src',data);
			}
		});
	}

	function new_offer(id) {  // AZ ELŐUGRÓ ABLAKOT HÍVJA MEG -> ÚJ AJÁNLAT
		var newOfferBtn = $("#offer" + id).parent().next().children().first();
		newOfferBtn.css("opacity", "0.3");
		newOfferBtn.removeAttr("onclick");
		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/offerform.php?popup=true&r_ajanlat=r_ajanlat&ajanlat_id="+id,
			success: function(data){
			$("#new_offer").toggle();
			// $("#exit").toggle();
			$("#new_offer").html(data);
			}
		});
	}

	function mod_offer(id) {  // AZ ELŐUGRÓ ABLAKOT HÍVJA MEG -> AJÁNLAT MÓDOSÍT
		var ajanlat_type = document.getElementById("offer"+id);
		if ($(ajanlat_type).val() == null) {
			alertwindow.innerHTML = "<h1>Nem választott ajánlatot!</h1>";
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
		} else {
			$.ajax({
				type: "GET",
				url: "menu-main/menu-offer-submenu/new-offer/offerform.php?popup=true&ajanlat_type="+ajanlat_type.value,
				success: function(data){
				$("#new_offer").toggle();
				$("#exit").toggle();
				$('#new_offer').html(data);
				//document.getElementById('exit').style.display = "block";
				}
			});
		}
	}

	function del_offer(id) {  // Ajánlat sorát törli
		if (confirm("Biztosan törli ezt a sort?")) {
			$('#offertable'+id).parent().parent().remove();
			$('#offernum').val($('#offernum').val()-1);
		}
	}

	var checknum = 0;

	function check() {
		var alertwindow = document.getElementById('alertwindow');

		var wreathnum = document.getElementById('wreathnum').value;
		var offernum = document.getElementById('offernum').value;

		if ($("#wreath1").val() === null && $("#offer1").val() === null) {
			alertwindow.innerHTML = "<h1>Nem választott ki koszorút és ajánlatot se!</h1>";
			alertwindow.style.display = "block";
			setTimeout(function() {alertwindow.style.display = "none";}, 1000);
			return false;
		}

		if ($("#wreath1").val() === null && $("#offer1").val() === null) {
			alertwindow.innerHTML = "<h1>Nem választott ki koszorút!</h1>";
			alertwindow.style.display = "block";
			setTimeout(function() {alertwindow.style.display = "none";}, 1000);
			return false;
		}

		if ($("#offer1").val() === null && $("#wreath1").val() === null) {
			alertwindow.innerHTML = "<h1>Nem választott ki ajánlatot!</h1>";
			alertwindow.style.display = "block";
			setTimeout(function() {alertwindow.style.display = "none";}, 1000);
			return false;
		}

		if (wreathnum > 0) {
			var checked = true;
			return check_wreaths(checked);
		}
		if (offernum > 0) {
			var checked = true;
			return check_offers(checked);
		}
	}

	function check_wreaths(checked) {
		var alertwindow = document.getElementById('alertwindow');
		var wreathnum = document.getElementById('wreathnum').value;
		var offernum = document.getElementById('offernum').value;
		checknum++;

		for (var i = 0; i < wreathnum; i++) {
			if ($("#wreath"+wreathnum).val() === null) {
				alertwindow.innerHTML = "<h1>Nem választott ki koszorút!</h1>";
				alertwindow.style.display = "block";
				setTimeout(function() {alertwindow.style.display = "none";}, 1000);
				checknum = 0;
				return false;
			} else {
				if ($("#isRibbon"+wreathnum).is(':checked')) {
					if ($("#ribbon"+wreathnum).val() === null) {
						alertwindow.innerHTML = "<h1>Nem választott ki szalag típust!</h1>";
						alertwindow.style.display = "block";
						setTimeout(function() {alertwindow.style.display = "none";}, 1000);
						checknum = 0;
						return false;
					} else {
						if ($("#ribboncolor"+wreathnum).val() === null) {
							alertwindow.innerHTML = "<h1>Nem választott ki szalag színt!</h1>";
							alertwindow.style.display = "block";
							setTimeout(function() {alertwindow.style.display = "none";}, 1000);
							checknum = 0;
							return false;
						} else {
							if ($("#farewelltext"+wreathnum).val() === null) {
								alertwindow.innerHTML = "<h1>Nem választott ki búcsúszöveget!</h1>";
								alertwindow.style.display = "block";
								setTimeout(function() {alertwindow.style.display = "none";}, 1000);
								checknum = 0;
								return false;
							} else {
								if ($("#givers"+wreathnum).val() === "") {
									alertwindow.innerHTML = "<h1>Üres mező: Akik adják!</h1>";
									alertwindow.style.display = "block";
									setTimeout(function() {alertwindow.style.display = "none";}, 1000);
									checknum = 0;
									return false;
								} else {
									if (offernum > 0 && checknum < 2) {
										return check_offers();
									} else {
										return true;
									}
								}
							}
						}
					}
				} else {
					if (offernum > 0 && checknum < 2) {
						return check_offers();
					} else {
						return true;
					}
				}
			}
		}
	}

	function check_offers(checked) {
		var alertwindow = document.getElementById('alertwindow');
		var wreathnum = document.getElementById('wreathnum').value;
		var offernum = document.getElementById('offernum').value;
		checknum++;

		for (var i = 0; i < offernum; i++) {
			if ($("#offer"+offernum).val() === null) {
				alertwindow.innerHTML = "<h1>Nem választott ki ajánlatot!</h1>";
				alertwindow.style.display = "block";
				setTimeout(function() {alertwindow.style.display = "none";}, 1000);
				checknum = 0;
				return false;
			} else if (wreathnum > 0 && checknum < 2) {
				return check_wreaths();
			} else {
				return true;
			}
		}
	}

	function loadCatalogWreathNames(from, to) {
		var catalogwreathnames = document.getElementById(from).value;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/catalogwreathnames.php?catalogwreathnames=" + catalogwreathnames,
			success: function(data){
			document.getElementById(to).disabled = "";
			$("#"+to).html(data);
			}
		});
	}

	///////////////// ORDERSTEP 2-höz /////////////////

	function loadCemetery(id) {
		$("#c_address").val($("#cemetery" + id + "_address").val());
		$("#c_location").val($("#cemetery" + id + "_name").val());
	}

	function customPlace() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/customplace.php",
			success: function(data){
			$("#custom_ship_place").html(data);
			}
		});
	}

	function customShipment() {
		var radios = document.getElementsByName('shipment');
		if (radios[0].checked) {
			$("#ship_price").val('0 Ft');
		} else {
			if (radios[1].checked) {
				$("#ship_price").val('0 Ft');
			}
		}
		if (radios[2].checked) {
			customPlace();
			$("#ship_price").val('2 000 Ft');
			document.getElementById("custom_ship_place").style.display = "block";
		} else {
			document.getElementById("custom_ship_place").style.display = "none";
		}
	}

	function pay_prices() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/new-order/pay_prices.php",
			success: function(data){
			$("#pay_prices").html(data);
			}
		});
	}

	function isPaid() {
		var paid = document.getElementById('paid');
		if (paid.checked) {
			document.getElementById("pay_prices").style.display = "none";
		} else {
			document.getElementById("pay_prices").style.display = "block";
			pay_prices();
		}
	}

	function addSpaces(nStr) { // olyan mint php-ban a number_format();
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ' ' + '$2');
		}
		return x1 + x2;
	}

	function calcSumm() {
		var price = document.getElementById("end_price").value;
		price = price.replace(/\s+/g, ''); //kiszedi a space karaketereket
		price = price.replace("Ft", ''); //kiszedi a "Ft"-ot
		var ship_price = document.getElementById("ship_price").value;
		ship_price = ship_price.replace(/\s+/g, '');
		ship_price = ship_price.replace("Ft", '');

		var fullprice = parseInt(price) + parseInt(ship_price);

		document.getElementById("sum_price").value = addSpaces(fullprice) + " Ft";
	}

	function calcRemainder() {
		var price = document.getElementById("end_price").value;
		price = price.replace(/\s+/g, ''); //kiszedi a space karaketereket
		price = price.replace("Ft", ''); //kiszedi a "Ft"-ot
		var ship_price = document.getElementById("ship_price").value;
		ship_price = ship_price.replace(/\s+/g, '');
		ship_price = ship_price.replace("Ft", '');

		var fullprice = parseInt(price) + parseInt(ship_price);

		var downprice = document.getElementById("downprice").value;
		downprice = downprice.replace(/\s+/g, '');
		downprice = parseInt(downprice);
		var remainder = addSpaces(fullprice - downprice);
		document.getElementById("remainder").value = remainder + " Ft";
	}

	function pending_on_shipment() {
		var radios = document.getElementsByName('shipment');

		if (radios[0].checked) {
			$(".pending_on_shipment").hide();
			$("#pending_on_shipment").html("* Átvétel időpontja");
		} else {
			$(".pending_on_shipment").show();
			$("#pending_on_shipment").html("* Szertartás időpontja");
		}

	}

	function check2() {
		var email = document.getElementById('email').value;
		var mail = /^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;

		var dead_name = document.getElementById('dead_name').value;
		var ritual_date = document.getElementById('ritual_date').value;
		var ritual_time = document.getElementById('ritual_time').value;
		var shipment = document.getElementsByName('shipment');

		var paid = document.getElementById('paid');

		if ($("#customer_name").val() == "") {
			alertwindow.innerHTML = "<h1>Üres mező: Megrendelő neve!</h1>";
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
			return false;
		} else {
			if ($("#phone_num").val().length < 13) {
				alertwindow.innerHTML = "<h1>Hibás mező: Telefonszám!</h1>";
				alertwindow.style.display = "block";
				setTimeout('alertwindow.style.display = "none";', 1000);
				return false;
			} else {
				if (email != "" && !mail.test(email)) {
					alertwindow.innerHTML = "<h1>Hibás mező: E-mail cím!</h1>";
					alertwindow.style.display = "block";
					setTimeout('alertwindow.style.display = "none";', 1000);
					return false;
				} else {
					if (shipment[2].checked) {
						var c_location = document.getElementById('c_location').value;
						var c_address = document.getElementById('c_address').value;
						var c_funeral = document.getElementById('c_funeral').value;

						if (c_location == "") {
							alertwindow.innerHTML = "<h1>Üres mező: Temetés helyszíne!</h1>";
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (c_address == "") {
								alertwindow.innerHTML = "<h1>Üres mező: Temetés címe!</h1>";
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (c_funeral == "") {
									alertwindow.innerHTML = "<h1>Üres mező: Ravatalozó / terem!</h1>";
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								} else {
									if (ritual_date == "") {
										alertwindow.innerHTML = "<h1>Üres mező: Szertartás/Átvétel dátuma!</h1>";
										alertwindow.style.display = "block";
										setTimeout('alertwindow.style.display = "none";', 1000);
										return false;
									} else {
										if (ritual_time == "") {
											alertwindow.innerHTML = "<h1>Üres mező: Szertartás/Átvétel ideje!</h1>";
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										} else {
											if (dead_name == "" && !shipment[0].checked) {
												alertwindow.innerHTML = "<h1>Üres mező: Elhunyt neve!</h1>";
												alertwindow.style.display = "block";
												setTimeout('alertwindow.style.display = "none";', 1000);
												return false;
											} else {
												if (!paid.checked) {
													var downprice = document.getElementById('downprice').value;
													var remainder = document.getElementById('remainder').value;

													if (downprice == "") {
														alertwindow.innerHTML = "<h1>Üres mező: Előleg!</h1>";
														alertwindow.style.display = "block";
														setTimeout('alertwindow.style.display = "none";', 1000);
														return false;
													} else {
														if (remainder == "") {
															alertwindow.innerHTML = "<h1>Üres mező: Hátralék!</h1>";
															alertwindow.style.display = "block";
															setTimeout('alertwindow.style.display = "none";', 1000);
															return false;
														} else {
															if ($("#shopname").val() == null) {
																alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
																alertwindow.style.display = "block";
																setTimeout('alertwindow.style.display = "none";', 1000);
																return false;
															} else {
																return true;
															}
														}
													}
												} else {
													if ($("#shopname").val() == null) {
														alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
														alertwindow.style.display = "block";
														setTimeout('alertwindow.style.display = "none";', 1000);
														return false;
													} else {
														return true;
													}
												}
											}
										}
									}
								}
							}
						}
					} else {
						if (ritual_date == "") {
							alertwindow.innerHTML = "<h1>Üres mező: Szertartás/Átvétel dátuma!</h1>";
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (ritual_time == "") {
								alertwindow.innerHTML = "<h1>Üres mező: Szertartás/Átvétel ideje!</h1>";
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (dead_name == "" && !shipment[0].checked) {
									alertwindow.innerHTML = "<h1>Üres mező: Elhunyt neve!</h1>";
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								} else {
									if (!paid.checked) {
										var downprice = document.getElementById('downprice').value;
										var remainder = document.getElementById('remainder').value;

										if (downprice == "") {
											alertwindow.innerHTML = "<h1>Üres mező: Előleg!</h1>";
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										} else {
											if (remainder == "") {
												alertwindow.innerHTML = "<h1>Üres mező: Hátralék!</h1>";
												alertwindow.style.display = "block";
												setTimeout('alertwindow.style.display = "none";', 1000);
												return false;
											} else {
												if ($("#shopname").val() == null) {
													alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
													alertwindow.style.display = "block";
													setTimeout('alertwindow.style.display = "none";', 1000);
													return false;
												} else {
													return true;
												}
											}
										}
									} else {
										if ($("#shopname").val() == null) {
											alertwindow.innerHTML = "<h1>Válasszon boltot!</h1>";
											alertwindow.style.display = "block";
											setTimeout('alertwindow.style.display = "none";', 1000);
											return false;
										} else {
											return true;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	///////////////// NEW_ORDER.PHP VÉGE /////////////////

	///////////////// CATALOGWREATH.PHP /////////////////

	function loadCatalogWreathNames(from, to) {
		var catalogwreathnames = document.getElementById(from).value;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/catalogwreathnames.php?catalogwreathnames=" + catalogwreathnames,
			success: function(data){
			document.getElementById(to).disabled = "";
			$("#"+to).html(data);
			}
		});
	}

	function loadWreathfromCatalog(div, ajanlat_select) {
		var wreath_type = document.getElementById('wreath_type').value;
		var wreath_size = document.getElementById('wreath_size').value;
		var params = window.location.search.replace("?", "");
		$.ajax({
			type: "GET",
			url: (params == "page=ajanlatok&subpage=uj_ajanlat")?"menu-main/menu-offer-submenu/new-offer/offerform.php?wreath_type=" + wreath_type + "&wreath_size=" + wreath_size + "&ajanlat_id=" + ajanlat_select : "menu-main/menu-offer-submenu/new-offer/offerform.php?wreath_type=" + wreath_type + "&wreath_size=" + wreath_size + "&popup=true&r_ajanlat=r_ajanlat&ajanlat_id=" + ajanlat_select,
			success: function(data){
			$("#"+div).html(data);
			calculatePrice_oForm(); writeWPrice(); writeFPrice(); writeLPrice();
			}
		});
	}

	function loadWreathfromOffer(div, ajanlat_select) {
		var copy_id = parseInt($("#copy_id").val());
		var params = window.location.search.replace("?", "");
		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/offerform.php?" + "copy_id=" + copy_id + "&ajanlat_id=" + ajanlat_select + (params == "page=ajanlatok&subpage=uj_ajanlat" ? "" : "&popup=true&r_ajanlat=r_ajanlat"),
			success: function (data) {
				$("#"+div).html(data);
				calculatePrice_oForm(); writeWPrice(); writeFPrice(); writeLPrice();
			}
		});
	}

	function loadFlowerColors(ftype,fcolor) {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-setting-submenu/wreath/flowercolors.php?flowertype=" + ftype.value,
			success: function(data){
			fcolor.disabled = "";
			$(fcolor).html(data);
			}
		});
	}

	///////////////// CATALOGWREATH.PHP VÉGE /////////////////

	///////////////// FLOWERROW.PHP /////////////////

	function ItemPrice(id) {
		var ftype = document.getElementById('flower'+id).value;
		var fcolor = document.getElementById('color'+id).value;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/itemprice.php?ftype="+ftype+"&fcolor="+fcolor,
			success: function(data){
			$("#itemprice"+id).val(data);
			}
		});
	}

	///////////////// FLOWERROW.PHP VÉGE /////////////////

	///////////////// LEAFROW.PHP /////////////////

	function LeafItemPrice(id) {
		var leaf = document.getElementById('leaf'+id).value;
		var leafqty = document.getElementById('leafqty'+id).value;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-offer-submenu/new-offer/leafitemprice.php?leaf="+leaf,
			success: function(data){
			$("#leafitemprice"+id).val(data);
			}
		});
	}

	///////////////// LEAFROW.PHP VÉGE /////////////////

	///////////////// ORDER.PHP /////////////////

function mark_it() {
		if(confirm('Biztosan rendezettnek jelöli a rendelést?')) {
			return true;
		} else {
			return false;
		}
	}

	function changeshop(id) {
		if ($("#change_shop").val() == null) {
			alert("Először válasszon boltot!");
			return false;
		} else {
			if(confirm('Biztosan áthelyezi a rendelést?')) {
				$.ajax({
					type: "GET",
					url: "menu-main/menu-order-submenu/change_shop.php?id="+id,
					data: "&shop="+$("#change_shop").val(),
					success: function(data){
					$("#right-content").html(data);
					}
				});
			} else {
				return false;
			}
		}
	}

	function shop_change(id) {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/shop_change_form.php?id="+id,
			success: function(data){
			$("#shop_changer").toggle();
			$('#shop_changer').html(data);
			document.getElementById('exit').style.display = "block";
			}
		});
	}

	///////////////// ORDER.PHP VÉGE /////////////////

	///////////////// ACQUISITION.PHP /////////////////

	var acquisitionid = document.getElementsByName("acquisitionid");
	var type = document.getElementsByName("type");

	function editAcquisition(id) {

		type[id].readOnly=false;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='modAcquisition("+id+");' value='Módosít' class='button' >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type='button' onClick='cancelAcquisition("+id+");' value='Mégse' class='button' >";

		modbutton.innerHTML += "<input type='hidden' id='acqtype' value = '"+type[id].value+"'> ";
	}
	function modAcquisition(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/acquisition/acquisitionmod.php",
			data: $("#acquisitionform"+id).serialize(),
			success: function(data){
			$("#acquisition"+id).html(data);
			}
		});
	}
	function cancelAcquisition(id) {
		var acqtype = document.getElementById('acqtype').value;

		type[id].value = acqtype;

		type[id].readOnly=true;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='editAcquisition("+id+");' value='Szerkeszt' class='button' >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type='button' onClick='delAcquisition("+id+");' value='Töröl' class='button' >";

		return false;
	}
	function delAcquisition(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/acquisition/acquisitiondel.php",
				data: $("#acquisitionform"+id).serialize(),
				success: function(data){
				$("#acquisition"+id).html(data);
				}
			});
		}
	}
	function addAcquisitionTR() {
		var xmlhttp;
		var acquisitiontableRef = document.getElementById('acquisition');

		if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var newRow = acquisitiontableRef.insertRow(-1);
				var lastRowIndex = acquisitiontableRef.rows.length-1;
				var newID = lastRowIndex-1;
				newRow.id = "acquisition"+newID;
				newRow.innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("POST","menu-main/menu-setting-submenu/acquisition/newacquisitionTR.php",true);
		xmlhttp.send();
	}
	function addnewacquisition(id) {
		var xmlhttp;
		var acquisitionTR = document.getElementById('acquisition'+id);

		if (type[id].value=="") {
			alert('Üres mező!');
		} else {

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					acquisitionTR.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/acquisition/newacquisition.php?&acquisitionid="+acquisitionid[id].value+"&type="+type[id].value,true);
			xmlhttp.send();
		}
	}

	///////////////// ACQUISITION.PHP VÉGE /////////////////

	///////////////// CITATION.PHP /////////////////


	var citid = document.getElementsByName("citid");
	var cittext = document.getElementsByName("cittext");

	function editCit(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/citation/citationmodform.php",
			data: $("#citationform"+id).serialize(),
			success: function(data){
			$("#citation_popup").html(data);
			$("#citation_popup").toggle();
			}
		});
	}
	function delCit(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/citation/citationdel.php",
				data: $("#citationform"+id).serialize(),
				success: function(data){
				$("#citation"+id).html(data);
				}
			});
		}
	}
	function addcitTR() {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/citation/newcitTR.php",
			success: function(data){
			$("#citation_popup").html(data);
			$("#citation_popup").toggle();
			}
		});
	}

	///////////////// CITATION.PHP VÉGE /////////////////

	///////////////// EMPLOYEES.PHP /////////////////

	var userid = document.getElementsByName("userid");
	var username = document.getElementsByName("username");
	var salary = document.getElementsByName("salary");
	var title = document.getElementsByName("title");
	var shop = document.getElementsByName("shop");
	var picture = document.getElementsByName("picture");
	var color = document.getElementsByName("color");
	var enable = document.getElementsByName("enable");
	var access_level = document.getElementsByName("access_level");

	function editUser(id) {
		var bgcolor = "#"+$("#color"+id).val();
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/employees/usermodform.php",
			data: $("#usereditform"+id).serialize(),
			success: function(data){
			$("#user_popup").html(data);
			$("#colorSelector").css('background-color', bgcolor);
			$("#user_popup").toggle();
			}
		});
	}

	function delUser(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/employees/userdel.php",
				data: $("#usereditform"+id).serialize(),
				success: function(data){
				$("#user"+id).html(data);
				}
			});
		}
	}
	function addUserTR() {
		$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/employees/newuserTR.php",
				success: function(data){
				$("#user_popup").html(data);
				$("#user_popup").toggle();
				}
			});
	}

	///////////////// EMPLOYEES.PHP VÉGE /////////////////


	///////////////// cemetery.PHP /////////////////

	var cemeteryid = document.getElementsByName("cemeteryid");
	var cemeteryname = document.getElementsByName("cemeteryname");
	var cemeteryaddress = document.getElementsByName("cemeteryaddress");

	function editcemetery(id) {
		var bgcolor = "#"+$("#color"+id).val();
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/cemetery/cemeterymodform.php",
			data: $("#cemeteryeditform"+id).serialize(),
			success: function(data){
			$("#cemetery_popup").html(data);
/*			$("#colorSelector").css('background-color', bgcolor);
*/			$("#cemetery_popup").toggle();
			}
		});
	}

	function delcemetery(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/cemetery/cemeterydel.php",
				data: $("#cemeteryeditform"+id).serialize(),
				success: function(data){
				$("#cemetery"+id).html(data);
				}
			});
		}
	}
	function addcemeteryTR() {
		$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/cemetery/newcemeteryTR.php",
				success: function(data){
				$("#cemetery_popup").html(data);
				$("#cemetery_popup").toggle();
				}
			});
	}

	///////////////// cemetery.PHP VÉGE /////////////////



	///////////////// FLOWEREDIT.PHP /////////////////


	var flowerid = document.getElementsByName("flowerid");
	var flowertype = document.getElementsByName("flowertype");
	var flowercolor = document.getElementsByName("flowercolor");
	var flowerprice = document.getElementsByName("flowerprice");

	function editFlower(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/flower/flowermodform.php",
			data: $("#flowereditform"+id).serialize(),
			success: function(data){
			$("#floweredit_popup").html(data);
			$("#floweredit_popup").toggle();
			}
		});
	}

	function delFlower(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/flower/flowerdel.php",
				data: $("#flowereditform"+id).serialize(),
				success: function(data){
				$("#flower"+id).html(data);
				}
			});
		}
	}

	function addFlowerTR() {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/flower/newflowerTR.php",
			success: function(data){
			$("#floweredit_popup").html(data);
			$("#floweredit_popup").toggle();
			}
		});
	}

	///////////////// FLOWEREDIT.PHP VÉGE /////////////////

	///////////////// REFRESH.PHP  /////////////////

	function new_wreath_type() {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/refresh/new_wreathtypeform.php",
			success: function(data){
			$("#wreathtype_popup").html(data);
			$("#wreathtype_popup").toggle();
			}
		});
	}

	///////////////// REFRESH.PHP VÉGE  /////////////////

	///////////////// OUTLAY.PHP  /////////////////

	var outlayid = document.getElementsByName("outlayid");
	var type = document.getElementsByName("type");

	function editOutlay(id) {

		type[id].readOnly=false;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='modOutlay("+id+");' value='Módosít' class='button' >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type='button' onClick='cancelOutlay("+id+");' value='Mégse' class='button' >";

		modbutton.innerHTML += "<input type='hidden' id='outtype' value = '"+type[id].value+"'> ";
	}
	function modOutlay(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/outlay/outlaymod.php",
			data: $("#outlayform"+id).serialize(),
			success: function(data){
			$("#outlay"+id).html(data);
			}
		});
	}
	function cancelOutlay(id) {
		var outtype = document.getElementById('outtype').value;

		type[id].value = outtype;

		type[id].readOnly=true;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='editOutlay("+id+");' value='Szerkeszt' class='button' >";
		var delbutton = document.getElementById('delbutton'+id);
		delbutton.innerHTML = "<input type='button' onClick='delOutlay("+id+");' value='Töröl' class='button' >";

		return false;
	}
	function delOutlay(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/outlay/outlaydel.php",
				data: $("#outlayform"+id).serialize(),
				success: function(data){
				$("#outlay"+id).html(data);
				}
			});
		}
	}
	function addOutlayTR() {
		var xmlhttp;
		var outlaytableRef = document.getElementById('outlay');

		if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var newRow = outlaytableRef.insertRow(-1);
				var lastRowIndex = outlaytableRef.rows.length-1;
				var newID = lastRowIndex-1;
				newRow.id = "outlay"+newID;
				newRow.innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("POST","menu-main/menu-setting-submenu/outlay/newoutlayTR.php",true);
		xmlhttp.send();
	}
	function addnewOutlay(id) {
		var xmlhttp;
		var outlayTR = document.getElementById('outlay'+id);

		if (type[id].value=="") {
			alert('Üres mező!');
		} else {

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					outlayTR.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/outlay/newoutlay.php?&outlayid="+outlayid[id].value+"&type="+type[id].value,true);
			xmlhttp.send();
		}
	}

	///////////////// OUTLAY.PHP VÉGE /////////////////

	///////////////// PW_CHANGE_FORM.PHP  /////////////////

	function pw_check() {
		var old_pw = document.getElementById('old_pw').value;
		var hidd_oldpw = document.getElementById('hidd_oldpw').value;
		var newpw = document.getElementById('new_pw').value;
		var newpw2 = document.getElementById('new_pw_again').value;

		if (old_pw == "") {
			alertwindow.innerHTML = "<h1>Régi jelszó mező üres!</h1>";
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
			return false;
		}	else {
			if (newpw == "") {
				alertwindow.innerHTML = "<h1>Jelszó mező üres!</h1>";
				alertwindow.style.display = "block";
				setTimeout('alertwindow.style.display = "none";', 1000);
				return false;
			} else {
				if (newpw2 == "") {
					alertwindow.innerHTML = "<h1>Jelszó mező újra üres!</h1>";
					alertwindow.style.display = "block";
					setTimeout('alertwindow.style.display = "none";', 1000);
					return false;
				} else {
					if (newpw != newpw2) {
						alertwindow.innerHTML = "<h1>A két jelszó nem egyezik meg!</h1>";
						alertwindow.style.display = "block";
						setTimeout('alertwindow.style.display = "none";', 1000);
						return false;
					} else {
						return true;
					}
				}
			}
		}
	}

	///////////////// PW_CHANGE_FORM.PHP VÉGE /////////////////

	///////////////// SHOPS.PHP  /////////////////

	var shopid = document.getElementsByName("shopid");
	var shopname = document.getElementsByName("shopname");
	var enable = document.getElementsByName("enable");

	function editShops(id) {

		enable[id].readOnly=false;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='modShops("+id+");' value='Módosít' class='button' >";
		modbutton.innerHTML += "<input type='hidden' id='isenabled' value = '"+enable[id].value+"'> ";

		var cancelbutton = document.getElementById('cancelbutton'+id);
		cancelbutton.innerHTML = "<input type='button' onClick='cancelShops("+id+");' value='Mégse' class='button' >";
	}
	function modShops(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/shops/shopsmod.php",
			data: $("#shopsform"+id).serialize(),
			success: function(data){
			$("#shops"+id).html(data);
			}
		});
	}
	function cancelShops(id) {
		var isenabled = document.getElementById('isenabled').value;

		enable[id].value = isenabled;
		enable[id].readOnly=true;

		var modbutton = document.getElementById('modbutton'+id);
		modbutton.innerHTML = "<input type='button' onClick='editShops("+id+");' value='Szerkeszt' class='button' >";
		var cancelbutton = document.getElementById('cancelbutton'+id);
		cancelbutton.innerHTML = "";
		return false;
	}

	///////////////// SHOPS.PHP VÉGE /////////////////

	///////////////// TAPE_TITLE.PHP  /////////////////

	var tapeid = document.getElementsByName("tapeid");
	var tapetext = document.getElementsByName("tapetext");

	function editTape(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/tape_title/tapemodform.php",
			data: $("#tapeform"+id).serialize(),
			success: function(data){
			$("#tapetitle_popup").html(data);
			$("#tapetitle_popup").toggle();
			}
		});
	}
	function delTape(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/tape_title/tapedel.php",
				data: $("#tapeform"+id).serialize(),
				success: function(data){
				$("#tape"+id).html(data);
				}
			});
		}
	}
	function addtapeTR() {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/tape_title/newtapeTR.php",
			success: function(data){
			$("#tapetitle_popup").html(data);
			$("#tapetitle_popup").toggle();
			}
		});
	}

	///////////////// TAPE_TITLE.PHP VÉGE /////////////////

	///////////////// FLOWERROW.PHP  /////////////////

	function loadFlowerColors(ftype,fcolor) {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-setting-submenu/wreath/flowercolors.php?flowertype=" + ftype.value,
			success: function(data){
			fcolor.disabled = "";
			$(fcolor).html(data);
			}
		});
	}

	///////////////// FLOWERROW.PHP VÉGE /////////////////

	///////////////// WREATHFORM.PHP  /////////////////

		var ftableRef;
		var ltableRef;

		function initTableRef() {
			ftableRef = document.getElementById('flower');
			ltableRef = document.getElementById('leaf');
		}

		function loadBaseWreathSizes() {
			var xmlhttp;
			var base_wreath_type = document.getElementById("base_wreath_type");

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("base_wreath_size").disabled = "";
					document.getElementById("base_wreath_size").innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/base_wreath_sizes.php?base_wreath_type=" + base_wreath_type.value,true);
			xmlhttp.send();
		}

		function addFlowerRow() {
			var xmlhttp;
			var flowernum = document.getElementById('flowernum').value;
			flowernum++;
			document.getElementById('flowernum').value = flowernum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = ftableRef.insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/flowerrow.php?flowernum="+flowernum,true);
			//xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			xmlhttp.send();
		}

		function remFlowerRow() {
			var rowCount = $('#flower tr').length;
			if (rowCount > 2) {
				ftableRef.deleteRow(-1);
				var flowernum = document.getElementById('flowernum').value;
				flowernum--;
				document.getElementById('flowernum').value = flowernum;
			}
		}

		function addLeafRow() {
			var xmlhttp;
			var leafnum = document.getElementById('leafnum').value;
			leafnum++;
			document.getElementById('leafnum').value = leafnum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = ltableRef.insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/leafrow.php?leafnum="+leafnum,true);
			//xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			xmlhttp.send();
		}

		function remLeafRow() {
			var rowCount = $('#leaf tr').length;
			if (rowCount > 2) {
				ltableRef.deleteRow(-1);
				var leafnum = document.getElementById('leafnum').value;
				leafnum--;
				document.getElementById('leafnum').value = leafnum;
			}
		}

		function calculatePrice_wForm() {
			var xmlhttp;
			var wtype = document.getElementById('base_wreath_type').value;
			var wsize = document.getElementById('base_wreath_size').value;
			var wreath_price = document.getElementById("wreath_price");

			var fname = new Array();
			var fcolor = new Array();
			var qty = new Array();
			var flowernum = document.getElementById('flowernum').value;

			var leafcolor = new Array();
			var leafqty = new Array();
			var leafnum = document.getElementById('leafnum').value;
			var ind = 0;
			var rezgoqty = document.getElementById('rezgoqty').value;

			var ftable = document.getElementById("flower");
			var fselects = ftable.getElementsByTagName("select");
			var frowNums = (fselects.length)/2;
			var ltable = document.getElementById("leaf");
			var lselects = ltable.getElementsByTagName("select");
			var lrowNums = lselects.length;
			var query1 = new Array();
			var query2 = new Array();
			var query3 = new Array();
			var query4 = new Array();
			var query5 = new Array();

			var rezgo = document.getElementById('rezgo').checked;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				qty[ind] = document.getElementById("qty"+ind);

				query1.push(encodeURIComponent(fname[ind].getAttribute('id')) + '=' + encodeURIComponent(fname[ind].value));
				query2.push(encodeURIComponent(fcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(fcolor[ind].value));
				query3.push(encodeURIComponent(qty[ind].getAttribute('id')) + '=' + encodeURIComponent(qty[ind].value));
				ind++;
			};

			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);

				query4.push(encodeURIComponent(leafcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(leafcolor[ind].value));
				query5.push(encodeURIComponent(leafqty[ind].getAttribute('id')) + '=' + encodeURIComponent(leafqty[ind].value));

				ind++;
			};

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					wreath_price.value=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/calculate.php?wtype=" + wtype + "&wsize=" + wsize + "&"
				+ query1.join('&') + '&' + query2.join('&') + '&' + query3.join('&')  + "&flowernum=" + flowernum + '&'
				+ query4.join('&') + '&' + query5.join('&') + "&leafnum=" + leafnum + "&rezgo=" + rezgo + "&rezgoqty=" + rezgoqty, true);

			xmlhttp.send();
		}

		function calcFullPrice() {
			var xmlhttp;
			var fullprice = document.getElementById("fullprice");

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					fullprice.value=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/fullprice.php",true);
			xmlhttp.send();
		}

		function rezgoqtyEnable() {
			var isEnabled = document.getElementById('rezgo').checked;
			document.getElementById("rezgoqty").disabled = "";
			if (isEnabled == "") {
				document.getElementById("rezgoqty").disabled = "disabled";
			}
		}

		function thumbnail(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

					reader.onload = function (e) {
					$('#img_prev')
					.attr('src', e.target.result)
					.height(155)
					.width(155);
				};

				reader.readAsDataURL(input.files[0]);
				document.getElementById('img_prev').style.visibility = 'visible';
			}
		}

		function thumbnail2(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

					reader.onload = function (e) {
					$('#img_prev2')
					.attr('src', e.target.result)
					.height(155)
					.width(155);
				};

				reader.readAsDataURL(input.files[0]);
				document.getElementById('img_prev2').style.visibility = 'visible';
			}
		}

		function dataCheck() {
			var alertwindow = document.getElementById('alertwindow');
			var wreath_name = document.getElementById('wreath_name').value;
			var base_wreath_type = document.getElementById('base_wreath_type').value;
			var base_wreath_size = document.getElementById('base_wreath_size').value;
			var fname = new Array();
			var fcolor = new Array();
			var fqty = new Array();
			var leafcolor = new Array();
			var leafqty = new Array();
			var rezgoqty = document.getElementById('rezgoqty').value;
			var note = document.getElementById('note').value;
			var wreathprice = document.getElementById('wreath_price').value;
			var endprice = document.getElementById('fullprice').value;
			var ind = 0;
			var ftable = document.getElementById("flower");
			var fselects = ftable.getElementsByTagName("select");
			var frowNums = (fselects.length)/2;
			var ltable = document.getElementById("leaf");
			var lselects = ltable.getElementsByTagName("select");
			var lrowNums = lselects.length;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				fqty[ind] = document.getElementById("qty"+ind);
			};
			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);
			};

			if (wreath_name == "") {
				alertwindow.innerHTML = '<h1>Üres mező: Koszorú név!</h1>';
				alertwindow.style.display = "block";
				setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
				return false;
			}
			else {
				if (base_wreath_type == "") {
					alertwindow.innerHTML = '<h1>Üres mező: Koszorú alap!</h1>';
					alertwindow.style.display = "block";
					setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
					return false;
				} else {
					if (base_wreath_size == "") {
						alertwindow.innerHTML = '<h1>Üres mező: Koszorú méret!</h1>';
						alertwindow.style.display = "block";
						setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
						return false;
					} else {
						if (fname[1].value == "") {
							alertwindow.innerHTML = '<h1>Üres mező: Virág típus!</h1>';
							alertwindow.style.display = "block";
							setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
							return false;
						}
						else {
							if (fcolor[1].value == "") {
								alertwindow.innerHTML = '<h1>Üres mező: Virág szín!</h1>';
								alertwindow.style.display = "block";
								setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
								return false;
							}
							else {
								if (endprice == "") {
									alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
									alertwindow.style.display = "block";
									setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
									return false;
								}
								else {
									return true;
								}
							}
						}
					}
				}
			}
		}

	///////////////// WREATHFORM.PHP VÉGE /////////////////

	///////////////// WREATHSEDIT.PHP  /////////////////

		function loadBaseWreathSizes() {
			var xmlhttp;
			var base_wreath_type = document.getElementById("base_wreath_type");

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("base_wreath_size").disabled = "";
					document.getElementById("base_wreath_size").innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreaths/base_wreath_sizes.php?base_wreath_type=" + base_wreath_type.value,true);
			xmlhttp.send();
		}

		function loadFlowerColors(ftype,fcolor) {
			var xmlhttp;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					fcolor.disabled = "";
					fcolor.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreath/flowercolors.php?flowertype=" + ftype.value,true);
			//xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			xmlhttp.send();
		}

		function addFlowerRow() {
			var xmlhttp;
			var flowernum = document.getElementById('flowernum').value;
			flowernum++;
			document.getElementById('flowernum').value = flowernum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = ftableRef.insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreaths/flowerrow.php?flowernum="+flowernum,true);
			//xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			xmlhttp.send();
		}

		function remFlowerRow() {
			var rowCount = $('#flower tr').length;
			if (rowCount > 2) {
				ftableRef.deleteRow(-1);
				var flowernum = document.getElementById('flowernum').value;
				flowernum--;
				document.getElementById('flowernum').value = flowernum;
			}
		}

		function addLeafRow() {
			var xmlhttp;
			var leafnum = document.getElementById('leafnum').value;
			leafnum++;
			document.getElementById('leafnum').value = leafnum;

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var newRow = ltableRef.insertRow(-1);
					newRow.innerHTML=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreaths/leafrow.php?leafnum="+leafnum,true);
			//xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
			xmlhttp.send();
		}

		function remLeafRow() {
			var rowCount = $('#leaf tr').length;
			if (rowCount > 1) {
				ltableRef.deleteRow(-1);
				var leafnum = document.getElementById('leafnum').value;
				leafnum--;
				document.getElementById('leafnum').value = leafnum;
			}
		}
		function writeWPrice() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-setting-submenu/wreaths/wsubtotal.php",
				success: function(data){
				$("#wsubtotal").html(data);
				}
			}); }, 200);
		}
		function writeFPrice() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-setting-submenu/wreaths/fsubtotal.php",
				success: function(data){
				$("#fsubtotal").html(data);
				}
			}); }, 200);
		}
		function writeLPrice() {
			setTimeout(function(){
			$.ajax({
				type: "GET",
				url: "menu-main/menu-setting-submenu/wreaths/lsubtotal.php",
				success: function(data){
				$("#lsubtotal").html(data);
				}
			}); }, 200);
		}

		function eraseWSubtotal() {
			var wsubtotal = document.getElementById('wsubtotal');
			wsubtotal.innerHTML = "0 Ft";
		}
		function eraseFSubtotal() {
			var fsubtotal = document.getElementById('fsubtotal');
			fsubtotal.innerHTML = "0 Ft";
		}
		function eraseLSubtotal() {
			var lsubtotal = document.getElementById('lsubtotal');
			lsubtotal.innerHTML = "0 Ft";
		}

		function calculatePrice_wEdit() {
			var xmlhttp;
			var wtype = document.getElementById('base_wreath_type').value;
			var wsize = document.getElementById('base_wreath_size').value;
			var wreath_price = document.getElementById("wreath_price");

			var fname = new Array();
			var fcolor = new Array();
			var qty = new Array();
			var flowernum = document.getElementById('flowernum').value;

			var leafcolor = new Array();
			var leafqty = new Array();
			var leafnum = document.getElementById('leafnum').value;
			var ind = 0;
			var rezgoqty = document.getElementById('rezgoqty').value;

			var ftable = document.getElementById("flower");
			var fselects = ftable.getElementsByTagName("select");
			var frowNums = (fselects.length)/2;
			var ltable = document.getElementById("leaf");
			var lselects = ltable.getElementsByTagName("select");
			var lrowNums = lselects.length;
			var query1 = new Array();
			var query2 = new Array();
			var query3 = new Array();
			var query4 = new Array();
			var query5 = new Array();

			var rezgo = document.getElementById('rezgo').checked;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				qty[ind] = document.getElementById("qty"+ind);

				query1.push(encodeURIComponent(fname[ind].getAttribute('id')) + '=' + encodeURIComponent(fname[ind].value));
				query2.push(encodeURIComponent(fcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(fcolor[ind].value));
				query3.push(encodeURIComponent(qty[ind].getAttribute('id')) + '=' + encodeURIComponent(qty[ind].value));
				ind++;
			};

			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);

				query4.push(encodeURIComponent(leafcolor[ind].getAttribute('id')) + '=' + encodeURIComponent(leafcolor[ind].value));
				query5.push(encodeURIComponent(leafqty[ind].getAttribute('id')) + '=' + encodeURIComponent(leafqty[ind].value));

				ind++;
			};

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					wreath_price.value=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreaths/calculate.php?wtype=" + wtype + "&wsize=" + wsize + "&"
				+ query1.join('&') + '&' + query2.join('&') + '&' + query3.join('&')  + "&flowernum=" + flowernum + '&'
				+ query4.join('&') + '&' + query5.join('&') + "&leafnum=" + leafnum + "&rezgo=" + rezgo + "&rezgoqty=" + rezgoqty, true);

			xmlhttp.send();
		}

		function calcFullPrice() {
			var xmlhttp;
			var fullprice = document.getElementById("fullprice");

			if (window.XMLHttpRequest) {	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					fullprice.value=xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","menu-main/menu-setting-submenu/wreaths/fullprice.php",true);
			xmlhttp.send();
		}

		function rezgoqtyEnable() {
			var isEnabled = document.getElementById('rezgo').checked;
			document.getElementById("rezgoqty").disabled = "";
			if (isEnabled == "") {
				document.getElementById("rezgoqty").disabled = "disabled";
			}
		}

		function thumbnail(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

					reader.onload = function (e) {
					$('#img_prev')
					.attr('src', e.target.result)
					.height(128)
					.width(128);
				};

				reader.readAsDataURL(input.files[0]);
				document.getElementById('img_prev').style.visibility = 'visible';
			}
		}

		function dataCheck() {
			var alertwindow = document.getElementById('alertwindow');
			var wreath_name = document.getElementById('wreath_name').value;
			var base_wreath_type = document.getElementById('base_wreath_type').value;
			var base_wreath_size = document.getElementById('base_wreath_size').value;
			var fname = new Array();
			var fcolor = new Array();
			var fqty = new Array();
			var leafcolor = new Array();
			var leafqty = new Array();
			var rezgoqty = document.getElementById('rezgoqty').value;
			var note = document.getElementById('note').value;
			var wreathprice = document.getElementById('wreath_price').value;
			var endprice = document.getElementById('fullprice').value;
			var ind = 0;
			var ftable = document.getElementById("flower");
			var fselects = ftable.getElementsByTagName("select");
			var frowNums = (fselects.length)/2;
			var ltable = document.getElementById("leaf");
			var lselects = ltable.getElementsByTagName("select");
			var lrowNums = lselects.length;

			for (var i = 0; i < frowNums; i++) {
				ind = i+1;
				fname[ind] = document.getElementById("flower"+ind);
				fcolor[ind] = document.getElementById("color"+ind);
				fqty[ind] = document.getElementById("qty"+ind);
			};
			for (var i = 0; i < lrowNums; i++) {
				ind = i+1;
				leafcolor[ind] = document.getElementById("leaf"+ind);
				leafqty[ind] = document.getElementById("leafqty"+ind);
			};

			if (wreath_name == "") {
				alertwindow.innerHTML = '<h1>Üres mező: Koszorú név!</h1>';
				document.getElementById('alertwindow').style.display = 'block';
				setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
				return false;
			}
			else {
				if (base_wreath_type == "") {
					alertwindow.innerHTML = '<h1>Üres mező: Koszorú alap!</h1>';
					document.getElementById('alertwindow').style.display = 'block';
					setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
					return false;
				} else {
					if (base_wreath_size == "") {
						alertwindow.innerHTML = '<h1>Üres mező: Koszorú méret!</h1>';
						document.getElementById('alertwindow').style.display = 'block';
						setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
						return false;
					} else {
						if (fname[1].value == "") {
							alertwindow.innerHTML = '<h1>Üres mező: Virág típus!</h1>';
							document.getElementById('alertwindow').style.display = 'block';
							setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
							return false;
						}
						else {
							if (fcolor[1].value == "") {
								alertwindow.innerHTML = '<h1>Üres mező: Virág szín!</h1>';
								document.getElementById('alertwindow').style.display = 'block';
								setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
								return false;
							}
							else {
								if (endprice == "") {
									alertwindow.innerHTML = '<h1>Üres mező: Értékesítési ár!</h1>';
									document.getElementById('alertwindow').style.display = 'block';
									setTimeout('document.getElementById(\"alertwindow\").style.display = \"none\"', 1500);
									return false;
								}
								else {
									return true;
								}
							}
						}
					}
				}
			}
		}

	///////////////// WREATHSEDIT.PHP VÉGE /////////////////

	///////////////// WREATHTYPEEDIT.PHP VÉGE /////////////////

	var wreathbid = document.getElementsByName("wreathbid");
	var wreathbtype = document.getElementsByName("wreathbtype");
	var wreathbsize = document.getElementsByName("wreathbsize");
	var wreathbfmin = document.getElementsByName("wreathbfmin");
	var wreathbfmax = document.getElementsByName("wreathbfmax");
	var wreathbprice = document.getElementsByName("wreathbprice");


	function editWreathType(id) {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/wreathtype/wreathtypemodform.php",
			data: $("#wbeditform"+id).serialize(),
			success: function(data){
			$("#wreathtype_popup").html(data);
			$("#wreathtype_popup").toggle();
			}
		});
	}

	function delWreathType(id) {
		if(confirm('Biztosan törli?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/wreathtype/wreathtypedel.php",
				data: $("#wbeditform"+id).serialize(),
				success: function(data){
				$("#wb"+id).html(data);
				}
			});
		}
	}
	function addWreathType() {
		$.ajax({
			type: "POST",
			url: "menu-main/menu-setting-submenu/wreathtype/newwreathtypeTR.php",
			success: function(data){
			$("#wreathtype_popup").html(data);
			$("#wreathtype_popup").toggle();
			}
		});
	}

	///////////////// WREATHTYPEEDIT.PHP VÉGE /////////////////

	///////////////// ORDER-MODIFY.PHP /////////////////

	function addWreath_modder() {
		var wtableRef = document.getElementById('ord_wreath');
		var newRow = wtableRef.insertRow(-1);
		var lastRowIndex = wtableRef.rows.length-1;
		var wreathnum = document.getElementById('wreathnum').value;

		if (lastRowIndex != 0) {
			wreathnum++;
		}

		document.getElementById('wreathnum').value = wreathnum;
		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/mod-order/wreathrow.php?wreathnum="+wreathnum,
			success: function(data){
			$(newRow).html(data);
			$.getScript("js/protea_functions.js");
			}
		});
	}
	function remWreathRow_modder() {
		if (confirm("Biztosan törli ezt a sort?")) {
			var rowCount = $('#ord_wreath tr').length;
			var wtableRef = document.getElementById('ord_wreath');
			if (rowCount > 2) {
				wtableRef.deleteRow(-1);
				var wreathnum = document.getElementById('wreathnum').value;
				if (wreathnum > 0) {
					wreathnum--;
				}
				document.getElementById('wreathnum').value = wreathnum;
			}
		}
	}

	function addOffer_modder() {
		var offtableRef = document.getElementById('ord_offer');
		var lastRowIndex = offtableRef.rows.length-1;
		var newRow = offtableRef.insertRow(-1);
		var prevId = $("#offerazonosito" + $("#offernum").val()).val();
		var newOfferId = parseInt(prevId.substr(prevId.indexOf("/") + 1)) + 1;
		newOfferId = prevId.substr(0, prevId.indexOf("/") + 1) + ((newOfferId < 10) ? "0" : "") + newOfferId;
		$('#offernum').val(parseInt($('#offernum').val())+1);

		$.ajax({
			type: "GET",
			url: "menu-main/menu-order-submenu/mod-order/offerrow.php?offernum="+$('#offernum').val(),
			success: function(data){
			$(newRow).html(data);
			$.getScript("js/protea_functions.js");
			$("#offerazonosito" + $("#offernum").val()).val(newOfferId);
			}
		});
	}
	function remOfferRow_modder() {
		var rowCount = $('#ord_offer tr').length;
		var offtableRef = document.getElementById('ord_offer');
		if (rowCount > 3) { // 9 = Az ord_offer táblában 1 fenti tr + 1 tr az első ord_offers tábla + ord_offers táblában 7 tr
			offtableRef.deleteRow(-1);
			var offernum = document.getElementById('offernum').value;
			if (offernum > 0) {
				offernum--;
			}
			document.getElementById('offernum').value = offernum;
		}
	}

	function check2_modify() {
		var dead_name = document.getElementById('dead_name').value;
		var ritual_time = document.getElementById('ritual_time').value;
		var shipment = document.getElementsByName('shipment');

		if (shipment[1].checked || shipment[2].checked) {
			if (dead_name == "") {
				alertwindow.innerHTML = "<h1>Üres mező: Elhunyt neve!</h1>";
				alertwindow.style.display = "block";
				setTimeout('alertwindow.style.display = "none";', 1000);
				return false;
			} else {
				if (ritual_time == "") {
					alertwindow.innerHTML = "<h1>Üres mező: Szertartás ideje!</h1>";
					alertwindow.style.display = "block";
					setTimeout('alertwindow.style.display = "none";', 1000);
					return false;
				} else {
					if (shipment[2].checked == true) {
						var c_location = document.getElementById('c_location').value;
						var c_address = document.getElementById('c_address').value;
						var c_funeral = document.getElementById('c_funeral').value;

						if (c_location == "") {
							alertwindow.innerHTML = "<h1>Üres mező: Temetés helyszíne!</h1>";
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (c_address == "") {
								alertwindow.innerHTML = "<h1>Üres mező: Temetés címe!</h1>";
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (c_funeral == "") {
									alertwindow.innerHTML = "<h1>Üres mező: Ravatalozó / terem!</h1>";
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								} else {
									return true;
								}
							}
						}
					} else {
						return true;
					}
				}
			}
		} else {
				if (ritual_time == "") {
					alertwindow.innerHTML = "<h1>Üres mező: Szertartás ideje!</h1>";
					alertwindow.style.display = "block";
					setTimeout('alertwindow.style.display = "none";', 1000);
					return false;
				} else {
					if (shipment[2].checked == true) {
						var c_location = document.getElementById('c_location').value;
						var c_address = document.getElementById('c_address').value;
						var c_funeral = document.getElementById('c_funeral').value;

						if (c_location == "") {
							alertwindow.innerHTML = "<h1>Üres mező: Temetés helyszíne!</h1>";
							alertwindow.style.display = "block";
							setTimeout('alertwindow.style.display = "none";', 1000);
							return false;
						} else {
							if (c_address == "") {
								alertwindow.innerHTML = "<h1>Üres mező: Temetés címe!</h1>";
								alertwindow.style.display = "block";
								setTimeout('alertwindow.style.display = "none";', 1000);
								return false;
							} else {
								if (c_funeral == "") {
									alertwindow.innerHTML = "<h1>Üres mező: Ravatalozó / terem!</h1>";
									alertwindow.style.display = "block";
									setTimeout('alertwindow.style.display = "none";', 1000);
									return false;
								} else {
									return true;
								}
							}
						}
					} else {
						return true;
					}
				}
			}
	}

	function order_mod_check() {
		if (check()) {
			if (check2_modify()) {
				if (check3()) {
					if (check4()) {
						is_evaluated = false;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function modifycheck() {
		if ($("#is_evaluated").val() == "false") {
			if (confirm("Biztos nem számolja újra az árakat?")) {
				order_mod_check();
			} else {
				return false;
			}
		} else {
			order_mod_check();
		}
	}

	function calc_modify_sum() {
		var wreath_query = new Array();
		var ribbon_query = new Array();
		var ribboncolor_query = new Array();
		var offer_query = new Array();
		var offerribbon_query = new Array();
		var offerribboncolor_query = new Array();

		var wreathNum = $('#wreathnum').val();
		var ind=1;

		for (var i = 0; i < wreathNum; i++) {
			wreath_query.push(encodeURIComponent($('#wreath'+ind).attr('id')) + '=' + encodeURIComponent($('#wreath'+ind).val()));
			if ($('#isRibbon'+ind).is(':checked')) {
				ribbon_query.push(encodeURIComponent($('#ribbon'+ind).attr('id')) + '=' + encodeURIComponent($('#ribbon'+ind).val()));
				ribboncolor_query.push(encodeURIComponent($('#ribboncolor'+ind).attr('id')) + '=' + encodeURIComponent($('#ribboncolor'+ind).val()));
			} else {
				ribbon_query.push(encodeURIComponent($('#ribbon'+ind).attr('id')) + '=' + encodeURIComponent(""));
				ribboncolor_query.push(encodeURIComponent($('#ribboncolor'+ind).attr('id')) + '=' + encodeURIComponent(""));
			}
			ind++;
		}

		var offerNum = $('#offernum').val();
		ind=1;
		for (var i = 0; i < offerNum; i++) {
			offer_query.push(encodeURIComponent($('#offer'+ind).attr('id')) + '=' + encodeURIComponent($('#offer'+ind).val()));
			ind++;
		}


			$.ajax({
				type: "GET",
				url: "menu-main/menu-order-submenu/mod-order/calc_mod_sum.php?wreathNum="+wreathNum+"&"+wreath_query.join('&')+'&'+ribbon_query.join('&')+'&'+ribboncolor_query.join('&')+ "&offerNum="+offerNum+'&'+offer_query.join('&'),
				success: function(data){
					$("#end_price").val(data);
					$("#is_evaluated").val("true"); // kiértékelés megtörtént
					calcRemainder();

					var price = document.getElementById("end_price").value;
					price = price.replace(/\s+/g, ''); //kiszedi a space karaketereket
					price = price.replace("Ft", ''); //kiszedi a "Ft"-ot
					var ship_price = document.getElementById("ship_price").value;
					ship_price = ship_price.replace(/\s+/g, ''); //kiszedi a space karaketereket
					ship_price = ship_price.replace("Ft", ''); //kiszedi a "Ft"-ot

					document.getElementById("end_price").value = addSpaces(parseInt(price) + parseInt(ship_price));
				}
			});
	}

	///////////////// ORDER-MODIFY.PHP VÉGE /////////////////

	function newShoppingListRow() {
		var wtableRef = document.getElementById('shopping_list');
		var newRow = wtableRef.insertRow(-1);
		$(newRow).attr('id', 'shopping_list_'+(parseInt($("#item_num").val())+1));
		var item_num = $("#item_num").val();

		$.ajax({
			type: "GET",
			url: "menu-main/menu-acquisition-submenu/shoppingcart/list_row.php",
			data: {
				item_num: item_num
			},
			success: function(data){
				$(newRow).html(data);
				$("#item_num").val(parseInt($("#item_num").val())+1);
			}
		});
	}

	function delActualShoppingListRow(actual_row) {
		var rowCount = $('#shopping_list tr').length;
		if (rowCount > 2) {
			$('#shopping_list_'+actual_row).remove();
			$("#item_num").val(parseInt($("#item_num").val())-1);
		}
	}

	function newShoppingCart() {
		$.ajax({
			type: "GET",
			url: "menu-main/menu-acquisition-submenu/shoppingcart/new_list.php",
			success: function(data){
				$("#newShopping_list").html(data);
				$("#newShopping_list").toggle();
			}
		});
	}

	function ShoppingCartList(id) { // bevásárló kosár módosítása
		$.ajax({
			type: "GET",
			url: "menu-main/menu-acquisition-submenu/shoppingcart/shoppingcartlist.php?id="+id,
			success: function(data){
				$('#newShopping_list').html(data);
				$('#newShopping_list').toggle();
			}
		});
	}

	function downloadShoppingCart_xls(id) {
		var d = new Date();
		var year = JSON.stringify(d.getFullYear()).substr(2, 2);
		var months = {
			"0" : "01",
			"1" : "02",
			"2" : "03",
			"3" : "04",
			"4" : "05",
			"5" : "06",
			"6" : "07",
			"7" : "08",
			"8" : "09",
			"9" : "10",
			"10" : "11",
			"11" : "12",
		}
		var month = JSON.stringify(d.getMonth());
		month = month.replace(month, months[d.getMonth()]);
		var day = (d.getDate()<10?"0"+d.getDate():d.getDate());
		var hours = (d.getHours()<10?"0"+d.getHours():d.getHours());
		var mins = (d.getMinutes()<10?"0"+d.getMinutes():d.getMinutes());
		var secs = (d.getSeconds()<10?"0"+d.getSeconds():d.getSeconds());
		var filename = year + month + day + hours + mins + secs;

		$.ajax({
			type: "GET",
			url: "menu-main/menu-acquisition-submenu/shoppingcart/export_excel.php?id="+id + "&date=" + filename,
			success: function(data){
				window.location.href="menu-main/menu-acquisition-submenu/shoppingcart/documents/"+id+"_excel_"+filename+".xls";
			}
		});
	}

	function checkShoppingList() {
		if ($('#max_date').val() == "") {
			alertwindow.innerHTML = '<h1>Üres mező: Beszerzés időpontja!</h1>';
			alertwindow.style.display = "block";
			setTimeout('alertwindow.style.display = "none";', 1000);
			return false;
		} else {
			return true;
		}
	}

	function deleteShoppingList(id) {
		if (confirm('Biztosan törli a bevásárló listát?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-acquisition-submenu/shoppingcart/del_shoppinglist.php",
				data: { id: id},
				success: function(data){
					location.reload();
				}
			});
		}
	}

	function checkWreathName() {
		$.ajax({
			url: "menu-main/menu-setting-submenu/wreaths/checkWreathName.php",
			type: "POST",
			data: {
				wreath_name: $("#wreath_name").val()
			},
			success: function(data){
				$("#wreath_name_error").html(data);
				if ( $("#wreath_name_error").html() == "") {
					$("#submit").prop( "disabled", false );
				} else {
					$("#submit").prop( "disabled", true );
				}
			}
		});
	}

	function deleteSpecialWreath(id) {
		if (confirm('Biztos törli a koszorút?')) {
			$.ajax({
				type: "POST",
				url: "menu-main/menu-setting-submenu/wreaths/del_special_wreath.php",
				data: { id: id},
				success: function(data){
					location.reload();
				}
			});
		}
	}