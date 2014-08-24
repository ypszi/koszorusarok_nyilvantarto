<style type="text/css">
	#calendar{
		width:870px;
	}	
	#calendar tr{
		border-bottom: 1px solid #5f7f71;
	}
	#calendar tr.now{
		border-bottom: 1px solid #5f7f71;
		background-color:#cae3a1;
	}
	#calendar th{
		width: 480px;
		margin: 0px;
		padding: 2px;
		text-align: center;
		text-transform: none;
	}

	#calendar th a{
		font: normal 12px/18px "Arial";
		color: #5f7f71;
		text-decoration:none;
	}	
	
	#calendar td{
		padding: 2px;
		width: 680px;
		text-align: left;
		text-transform: none;
	}
	
	#calendar td .entry_full{
		margin: 1px 0px 0px 15px;
		text-align: left;
		text-transform: none;
	}

	#calendar td.hour{
		margin: 0;
		padding: 2px 0px 10px 0px;
		border-right: 10px solid #ffffff;
		font: normal 12px/18px "Arial";
		color: #5f7f71;
		text-align: left;
		text-transform: none;
		width: 20px;
		vertical-align: center;
	}
	
	.next_week a{
		background: url(../img/btn-bg1.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 20px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}
	.next_week a:hover{
		background: url(../img/btn-bg2.png) repeat-x 0 0px;
		padding: 5px;
		color: #fff;
		border: 0px;
		width: 85px;
		right: 12px;
		margin-top: 5px;
		height: 22px;
		border-style: outset;
		cursor: pointer;
		text-decoration: none;
		text-transform: none;
	}
	.next_week .deliver{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #ffd800;
	}
	.next_week .other{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #5f7f71;
	}
	.next_week .first{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #fb664b;
	}
	.next_week .second{
		padding: 0px 5px 0px 5px;
		border-left: 15px solid #5c96ff;
	}
	
	.selected_day{
		background-color:#e0ebdd;
	}
	
	.separate{
		width: 10px;
		border-left: 10px solid #ffffff;
	}
	
</style>

<div  id="content" style="padding: 10px; background-color: #fff; float:left; height: 1200px;">

<div class="title">
	<span class="firstWord">Napi Temetkezési</span> Naptár
</div>

<div class="title">
	<?php 

	if (isset($_GET['day'])){
		$selected_date = $_GET['day'];
	}else{
		$selected_date = 0;
	}
		
	
	echo '<span class="next_week" style="float:right;"><a href="?page=temetes&subpage=naptarinap&day='.date('Ymd',strtotime($selected_date) - 24*3600).'">elöző nap</a> | <a href="?page=temetes&subpage=naptarinap&day='.date('Ymd',strtotime($selected_date) + 24*3600).'">következő nap</a></span>';

	echo '<span class="next_week"><a href="?page=temetes">Vissza a heti naptárba</a></span>';

	?>
</div>
<div>
	<table id='calendar'>
		<tr>
<?php
		
		echo '<th style="width:20px;"></th>';
		echo '<th><a href="?page=temetes&subpage=naptarinap&day=' .date('Ymd',strtotime($selected_date)). '"><br />' .date('Y.m.d',strtotime($selected_date)) . ' ';

		switch (date('N',strtotime($selected_date))) {
		case 1:
			echo "Hétfő";
			break;
		case 2:
			echo "Kedd";
			break;
		case 3:
			echo "Szerda";
			break;
		case 4:
			echo "Csütörtök";
			break;
		case 5:
			echo "Péntek";
			break;
		case 6:
			echo "Szombat";
			break;
		case 7:
			echo "Vasárnap";
			break;
		}

		echo '</a></th>
		</tr>';
		
		$query = "SELECT name, funeral_date,note 
					FROM  death_calendar
					WHERE WEEK(funeral_date)=". (date('W',strtotime($selected_date))-1). " AND DAY(funeral_date) = ". (date('d',strtotime($selected_date)+1)) ." AND archive = 0
					ORDER BY funeral_date ASC;";
								
		$result = mysql_query($query) or die (mysql_error());

		while ($row = mysql_fetch_assoc($result)) {			
			$death[date("H",strtotime($row["funeral_date"]))] .=
				'<div style="padding:1px; width: 65px;">
					<div style="margin-left:15px; font: 3px arial,sans-serif;">
						<p style="color: #000; font-size: 12px; width:810px; font-weight: bold;">'.date("H:i",strtotime($row["funeral_date"])).' - &#8224; '.$row["name"].' <span style="color: #666; font-style:italic;">'.$row["note"].'</span></p>
					</div>
				</div>';				
		}
			
		$hours = array(7 => '07', 
				8 => '08', 
				9 => '09', 
				10 => '10', 
				11 => '11', 
				12 => '12', 
				13 => '13', 
				14 => '14', 
				15 => '15', 
				16 => '16', 
				17 => '17', 
				18 => '18', 
				19 => '19', 
				20 => '20');

			
		for ($hour = 7; $hour <= 20; $hour++) {
			if (date("G") != ($hour)){
				echo '<tr>';
			}else{
				echo '<tr class="now">';
			}

			echo '<td class="hour">'. ($hour) .'<sup>00</sup></td>';				
			echo '<td class="separate">
					'. $death[$hours[$hour]] .'
					</td>';					
			echo '</tr>';
		}		

?>
	</table>
</div>

</div>
