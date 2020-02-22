
<?php
  
  //STATES*STATES*STATES*STATES*STATES*STATES*STATES*STATES*STATES*STATES*
  function find_all_states() {
    global $db;
    $sql = "SELECT DISTINCT state FROM crime_rent ";
    $sql .= "ORDER BY state ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
  //COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*
  function find_all_counties($state_input) {
    global $db;
    $sql = "SELECT county FROM crime_rent WHERE state = '$state_input'";
	$sql .= "ORDER BY state ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
   //COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*COUNTIES*
  function find_all_counties_and_prices($state_input) {
    global $db;
    $sql = "SELECT * FROM crime_rent WHERE state='$state_input' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
  //STATES_AND_COUNTIES_COST_ALL_RENT
   function find_all_states_and_counties($state_input, $county_input) {
    global $db;
    $sql = "SELECT * FROM crime_rent WHERE state='$state_input' and county='$county_input'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
 
  
  //MEDIAN_RENT*MEDIAN_RENT*MEDIAN_RENT*MEDIAN_RENT*MEDIAN_RENT*MEDIAN_RENT*
   function find_state_rent_median($size) {
    global $db;
    $sql = "
	SELECT AVG(dd.$size) as median_val
		FROM (
		SELECT crime_rent.$size, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM crime_rent, (SELECT @rownum:=0) r
		  WHERE crime_rent.$size is NOT NULL ORDER BY crime_rent.$size
		) as dd
		WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );
	";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
	//MEDIAN_CRIME*MEDIAN_CRIME*MEDIAN_CRIME*MEDIAN_CRIME*MEDIAN_CRIME*MEDIAN_CRIME*MEDIAN_CRIME*
	function find_crime_median($crime_type) {
    global $db;
    $sql = "
	SELECT AVG(dd.$crime_type) as median_val
		FROM (
		SELECT crime_rent.$crime_type, @rownum:=@rownum+1 as `row_number`, @total_rows:=@rownum
		  FROM crime_rent, (SELECT @rownum:=0) r
		  WHERE crime_rent.$crime_type is NOT NULL ORDER BY crime_rent.$crime_type
		) as dd
		WHERE dd.row_number IN ( FLOOR((@total_rows+1)/2), FLOOR((@total_rows+2)/2) );
	";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
?>
