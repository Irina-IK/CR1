
<!--
//LOADS FILES ***********************************************************************************************
	-->
<?php require_once('../private/start.php'); ?>
<?php include('../private/header.php'); ?>
<?php $page_title = 'RentVsCrime'; ?>


<!--
PAGE FORM *************** ***********************************************************************************
-->	
<form name="state_form">

	<!--
	//STATES**********************PHP RETRIEVES LIST OF STATES **********************************************
	--> 
	<?php
		//Sets up current state -> location
		$rent_state_set = find_all_states();
		echo  "<select  name='location'  onchange='this.form.submit()'>";
		while($output = mysqli_fetch_assoc($rent_state_set)) {
			echo "<option ". (($_GET['location'] == $output["state"]) ? 'selected ' : '') ."value=\"".$output["state"]."\">".$output["state"]."</option>";
		}	
		echo "</select>";
		mysqli_free_result($rent_state_set);
	?>
	
	<p>
	</p>
	
	<!--
	//COUNTIES***************RETRIEVES LIST OF COUNTIES ******************************************************
	--> 
	<?php
	
		$counties = [];
		//Retrieves current state (location) from STATES
		(isset($_GET["location"])) ? $location=$_GET["location"] : $location = 'Alabama';
		echo  "<select  name='county' onchange='this.form.submit()'>";
		$rent_county_set = find_all_counties($location);
		while($output = mysqli_fetch_assoc($rent_county_set)) {
			array_push($counties, (strval($output["county"]).(' County, ').$location));
			echo "<option ". (($_GET['county'] == $output["county"]) ? 'selected ' : '') ."value=\"".$output["county"]."\">".$output["county"]."</option>";
		}	
		echo "</select>";
		mysqli_free_result($rent_county_set);	
	?>
	
	<p>
	</p>
	
	<!--
	//COSTS  AND CRIME ****************************************************************************************
	-->
	<?php
		
		(isset($_GET["county"])) ? $county=$_GET["county"] : $county = 'Autauga';
		$state_and_prices = [];
		
		$prices = [];
		$crime = [];
		
		$studio = 'studio';
		$one_bedroom = '1bedroom';
		$two_bedroom = '2bedroom';
		$three_bedroom = '3bedroom';
		$four_bedroom = '4bedroom';
		$size = $studio;
		
		$median_total = 'tot_pop';
		$median_persons = 'per_pop';
		$median_property = 'prop_pop';
		$crime_type = $median_total;

		$state_and_prices = find_all_counties_and_prices($location);
		
		//Retrieves cost and crime rate*************************************************************************
		while($output = mysqli_fetch_assoc($state_and_prices)) {
			array_push($prices, strval($output[$size]));
			array_push($crime, strval($output[$crime_type]));
		}	
		
		$median_cost;
		
		//MEDIAN RENT COST *************************************************************************************
		$median = find_state_rent_median($size);
		while($output = mysqli_fetch_assoc($median)) {
			$median_cost = reset($output);
		}	
		
		$median_crime;

		//MEDIAN CRIME ******************************************************************************************
		$median = find_crime_median($crime_type);
		while($output = mysqli_fetch_assoc($median)) {
			$median_crime = reset($output);
		}	
	?>
	
	<!--
	STATE
	-->
	<div id="current_state" style="display: none;">
		<?php
			$output = $location;
			echo htmlspecialchars($output);
		?>
	</div>
	
	<!--
	COUNTIES
	-->
	<script type='text/javascript'>
		var records = <?php echo json_encode($counties) ?>
	</script>
	
	
	<!--
	PRICES
	-->
	<script type='text/javascript'>	
		var studios = <?php echo json_encode($prices) ?>
	</script>
	

	<!--
	CRIMES
	-->
	<script type='text/javascript'>
		var crimes = <?php echo json_encode($crime) ?>
	</script>
	
	
	<!--
	MEDIAN CRIMES
	-->
	<script type='text/javascript'>
		var coefficient = <?php echo json_encode($median_crime) ?>
	</script>
	
	<!--
	MEDIAN RENT
	-->
	<script type='text/javascript'>
		var med_rent = <?php echo json_encode($median_cost) ?>
	</script>
	
	
	<!--
	//CREATES THE MAP ****************************************************************************************
	-->
	<script
			type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Al8ecsEHDXOhWSENUHqgx_OQMoOJUehJLfHwmvSl3cwEKK0tqQU_HTiXdUANN2KL' async defer>
	</script>	

	<!--
	//LOADS THE MAP *******************************************************************************************	
	-->		
	<div id="myMap" style="position:relative;width:800px;height:600px;">
	</div>
	
</form>
<!--
END OF FORM *************** ***********************************************************************************
-->	


<?php include('../private/footer.php'); ?>
