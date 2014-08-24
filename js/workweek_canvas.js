var DAYS = new Array("    Hétfő", "    Kedd", "   Szerda", "Csütörtök", "  Péntek", " Szombat", "Vasárnap");

var CNV_WIDTH = 490;
var CNV_HEIGHT = 320;
var COLUMN_WIDTH = 70;
var COLUMN_HEIGHT = 320;
var DAY_TOP = 12;
var DAY_LEFT = 8;
var DATE_TOP = 22;
var DATE_LEFT = 17;
var H_TIME_LEFT = 11;
var TIME_LEFT = 19;
var TIME_TOP = 43;
var LINE_TOP = 25;
var RECT_INDENT = 2;
var RECT_WIDTH = 8;
var RECT_HEIGTH = 7;
var GAP = 19;
var GAP2 = GAP + RECT_HEIGTH + 2;

var CL_BACKGROUND = "#FFF";
var CL_BORDER = "#000";
var CL_EVEN = "#FFF";
var CL_ODD = "#F4F4F4";
var CL_MARKER = "#00F";
var CL_FONT = "#000";
var CL_LINE = "#CCC";
var CL_H_TIME = "#BBB";
var CL_TIME = "#BBB";
var CL_TODAY = "#C3E5BA";
var CL_SELECTED = "#F00";

function draw(canvas) {
	var ctx = canvas.getContext("2d");
	var d, h;
	ctx.beginPath();
	ctx.lineWidth = 1;
	ctx.fillStyle = CL_BACKGROUND;
	ctx.fillRect(0, 0, CNV_WIDTH, CNV_HEIGHT);
	for (d = 0; d < 7; d++) {
		ctx.beginPath();
		ctx.fillStyle = d == canvas.weekData.day ? CL_TODAY : (d % 2 == 0 ? CL_EVEN : CL_ODD);
		ctx.fillRect(d * COLUMN_WIDTH, 0, COLUMN_WIDTH, COLUMN_HEIGHT);
		ctx.beginPath();
		ctx.fillStyle = CL_FONT;
		ctx.font="9px Verdana";
		ctx.fillText(DAYS[d], DAY_LEFT + d * COLUMN_WIDTH, DAY_TOP);
		ctx.font="bold 10px Verdana";
		ctx.fillText(canvas.weekData.dates[d], DATE_LEFT + d * COLUMN_WIDTH, DATE_TOP);
		ctx.beginPath();
		for (h = 0; h < 15; h++) {
			ctx.strokeStyle = CL_LINE;
			ctx.moveTo(2 + d * COLUMN_WIDTH, (h + 1) * GAP - 0.5 + LINE_TOP);
			ctx.lineTo(COLUMN_WIDTH - 2 + d * COLUMN_WIDTH, (h + 1) * GAP - 0.5 + LINE_TOP);
			ctx.stroke();
		}
	}
}

function drawTime(canvas) {
	var ctx = canvas.getContext("2d");
	ctx.fillStyle = CL_TIME;
	ctx.font="12px Arial";
	for (d = 0; d < 7; d++) {
		for (h = 0; h < 15; h++) {
			ctx.beginPath();
			ctx.fillText((h < 4 ? "0" : "") + (h + 6) + ":00", TIME_LEFT + d * COLUMN_WIDTH, h * GAP + TIME_TOP);
			ctx.stroke();
		}
	}
}

function drawWorkingHours(ctx, no, day, color, from, to) {
	ctx.fillStyle = color;
	for (var h = from + 2; h < to + 2; h++) {
		var b = (h % 2 == 0);
		ctx.fillRect(day * COLUMN_WIDTH + RECT_INDENT + no * (RECT_WIDTH + 2), (b ? h : h - 1) / 2 * GAP + (b ? GAP : GAP2) + 7, RECT_WIDTH, RECT_HEIGTH);
	}
}

function canvasOnMouseMove(event) {
	var ctx = this.getContext("2d");
	var rect = this.getBoundingClientRect();
	var x = event.pageX - rect.left - 0.5;
	var y = event.pageY - rect.top;
	var d = Math.floor(x / COLUMN_WIDTH);
	if (this.weekData.last != d) {
		ctx.beginPath();
		ctx.lineWidth = 2;
		ctx.strokeStyle = this.weekData.last == this.weekData.selected ? CL_SELECTED : (this.weekData.last == this.weekData.day ? CL_TODAY : (this.weekData.last % 2 == 0 ? CL_EVEN : CL_ODD));
		ctx.rect(1 + this.weekData.last * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
		ctx.stroke();
		if (this.weekData.selected != d) {
			ctx.beginPath();
			ctx.strokeStyle = CL_MARKER;
			ctx.rect(1 + d * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
			ctx.stroke();
		}
		this.weekData.last = d;
	}
}

function fake(canvas, day) {
	var cnv = document.getElementById(canvas);
	var ctx = cnv.getContext("2d");
	ctx.beginPath();
	ctx.strokeStyle = CL_SELECTED;
	ctx.rect(1 + day * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
	ctx.stroke();
	cnv.weekData.selected = day;
	setShop = cnv.weekData.shop;
	setWeek = cnv.weekData.weekNum;
	setDay = day;
	lastCanvas = canvas;
	$("#store_top").html(shops[setShop]);
	$("#store_bot").html(shops[setShop]);
	$("#week_top").html(setWeek + ".");
	$("#week_bot").html(setWeek + ".");
	$("#day_top").html(DAYS[setDay].replace(/\s+/g, ''));
	$("#day_bot").html(DAYS[setDay].replace(/\s+/g, ''));
}

function canvasOnMouseClick(event) {
	var ctx = this.getContext("2d");
	var rect = this.getBoundingClientRect();
	var x = event.pageX - rect.left - 0.5;
	var y = event.pageY - rect.top;
	var d = Math.floor(x / COLUMN_WIDTH);
	if (this.weekData.selected != d) {
		clearSelections();
		ctx.beginPath();
		ctx.strokeStyle = CL_SELECTED;
		ctx.rect(1 + d * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
		ctx.stroke();
		this.weekData.selected = d;
		setShop = this.weekData.shop;
		setWeek = this.weekData.weekNum;
		setDay = this.weekData.selected;
		lastCanvas = this.id;
		$("#store_top").html(shops[setShop]);
		$("#store_bot").html(shops[setShop]);
		$("#week_top").html(setWeek + ".");
		$("#week_bot").html(setWeek + ".");
		$("#day_top").html(DAYS[setDay].replace(/\s+/g, ''));
		$("#day_bot").html(DAYS[setDay].replace(/\s+/g, ''));
	} else {
		ctx.beginPath();
		ctx.lineWidth = 2;
		ctx.strokeStyle = CL_MARKER;
		ctx.rect(1 + this.weekData.selected * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
		ctx.stroke();
		this.weekData.last = d;
		this.weekData.selected = -1;
		setShop = -1;
		setWeek = -1;
		setDay = -1;
		$("#store_top").html("-");
		$("#store_bot").html("-");
		$("#week_top").html("-");
		$("#week_bot").html("-");
		$("#day_top").html("-");
		$("#day_bot").html("-");
	}
}

function canvasOnMouseOut(event) {
	var ctx = this.getContext("2d");
	var rect = this.getBoundingClientRect();
	ctx.beginPath();
	ctx.lineWidth = 2;
	ctx.strokeStyle = this.weekData.last == this.weekData.selected ? CL_SELECTED : (this.weekData.last == this.weekData.day ? CL_TODAY : (this.weekData.last % 2 == 0 ? CL_EVEN : CL_ODD));
	ctx.rect(1 + this.weekData.last * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
	ctx.stroke();
	this.weekData.last = -1;
}

function initialize() {
	for (var i = 0; i < 6; i++) {
		var cnv = document.getElementById("canvas" + i);
		cnv.addEventListener("mousemove", canvasOnMouseMove);
		cnv.addEventListener("mouseout", canvasOnMouseOut);
		cnv.addEventListener("click", canvasOnMouseClick);
		cnv.weekData = new construct_WeekData(i % 2 == actualWeek ? dayOfWeek : -1, i % 2 == 0 ? week1 : week2, i % 2 == 0 ? initweek : initweek + 1, Math.floor(i / 2));
		draw(cnv);
		var wPerDay = new Array(0, 0, 0, 0, 0, 0, 0);
		for (var j = 0; j < intervals.length; j++) {
			if (i == intervals[j].week) {
				drawWorkingHours(cnv.getContext("2d"), wPerDay[intervals[j].day], intervals[j].day, intervals[j].color, intervals[j].from, intervals[j].to);
				wPerDay[intervals[j].day]++;
			}
		}
		drawTime(cnv);
	}
	var ctx = document.getElementById("legend").getContext("2d");
	var last = 10;
	for (var i = 0; i < users.length; i++) {
		ctx.beginPath();
		ctx.fillStyle = "#" + users[i].color;
		ctx.fillRect(last, 10, 10, 10);
		ctx.beginPath();
		ctx.fillStyle = CL_TIME;
		ctx.font = "12px Arial";
		ctx.fillText(users[i].name, 15 + last, 19);
		last += users[i].name.length > 5 ? 90 : 50;
	}
}

function clearSelections() {
	for (var i = 0; i < 6; i++) {
		var cnv = document.getElementById("canvas" + i);
		var ctx = cnv.getContext("2d");
		ctx.beginPath();
		ctx.lineWidth = 2;
		ctx.strokeStyle = cnv.weekData.selected == cnv.weekData.day ? CL_TODAY : (cnv.weekData.selected % 2 == 0 ? CL_EVEN : CL_ODD);
		ctx.rect(1 + cnv.weekData.selected * COLUMN_WIDTH, 1, COLUMN_WIDTH - 2, COLUMN_HEIGHT - 2);
		ctx.stroke();
		cnv.weekData.selected = -1;
	}
}

function construct_WeekData(day, dates, weekNum, shop) {
	this.last = -1;
	this.day = day;
	this.selected = -1;
	this.dates = dates;
	this.weekNum = weekNum;
	this.shop = shop;
}

function construct_User(name, color) {
	this.name = name;
	this.color = color;
}

function construct_Interval(week, day, color, from, to) {
	this.week = week;
	this.day = day;
	this.color = color;
	this.from = from;
	this.to = to;
}

function changeWeek(amount) {
	var week = document.getElementById("week_num");
	week.value = parseInt(week.value) + amount;
}

function syncTime(id, sender) {
	document.getElementById(id).value = sender.value;
}

function syncWorker(id, sender) {
	document.getElementById(id).selectedIndex = sender.selectedIndex;
}

function setShort() {
	$("#begin_time_top").val("07:00");
	$("#end_time_top").val("16:00");
	$("#begin_time_bot").val("07:00");
	$("#end_time_bot").val("16:00");
}

function setLong() {
	$("#begin_time_top").val("07:00");
	$("#end_time_top").val("20:00");
	$("#begin_time_bot").val("07:00");
	$("#end_time_bot").val("20:00");
}

function sendChange(del) {
	if (setShop > -1) {
		if (!del || del && confirm('Biztos törölni szeretné?')) {
			$("#delete").val(del ? 1 : 0);
			$("#user_id").val($("#user_id_top").val());
			$("#begin_time").val($("#begin_time_top").val());
			$("#end_time").val($("#end_time_top").val());
			$("#store_id").val(setShop);
			$("#week").val(setWeek);
			$("#day").val(setDay);
			$("#last_canvas").val(lastCanvas);
			$("#scroll_top").val(Math.max(document.body.scrollTop, document.documentElement.scrollTop));
			$("#interval_form").submit();
		}
	} else {
		alert("Nincs kiválasztott munkanap!");
	}
}