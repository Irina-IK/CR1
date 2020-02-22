

<!--
	//MAP OPTIONS **********************************************************************************
	-->


<script type='text/javascript'>		
    function GetMap() {
		
		//Set up map style
		 var myStyle = {
            "elements": {
                "water": { "fillColor": "#95B1EE" },
				"mapElement": { "fillColor": "#ebf1fa" },
                "waterPoint": { "iconColor": "#12458c" },
                "transportation": { "strokeColor": "#5c595a" },
                "road": { "fillColor": "#383637" },
                "structure": { "fillColor": "#ffffff" },
                "runway": { "fillColor": "#ff7fed" },
                "area": { "fillColor": "#ebf1fa" },
                "political": { "borderStrokeColor": "#fe6850", "borderOutlineColor": "#55ffff" },
                "point": { "iconColor": "#ffffff", "fillColor": "#FF6FA0", "strokeColor": "#DB4680" },
                "transit": { "fillColor": "#AA6DE0" }
            },
            "version": "1.0" 
        };

		var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
			center: new Microsoft.Maps.Location(47.624527, -122.355255),
			customMapStyle: myStyle,
			
			zoom: 20
		});
		
		//Current State
		var div = document.getElementById("current_state");
		var myData = div.textContent;
		
		
		//Put county bounds in a give state
		Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
			var searchManager = new Microsoft.Maps.Search.SearchManager(map);
			var requestOptions = {
				bounds: map.getBounds(),
				where: myData,
				callback: function (answer, userData) {
					map.setView({ bounds: answer.results[0].bestView });
					
				}
			};	 
		searchManager.geocode(requestOptions);
		});
			
        //Breaking map in counties
        var geoDataRequestOptions = {
            entityType: 'AdminDivision2'
        };
				
        //Load the Bing Spatial Data Services module.
        Microsoft.Maps.loadModule(['Microsoft.Maps.SpatialDataService', 'Microsoft.Maps.SpatialMath'], function () {
	
			
	
			var counter = 0;
            //Use the GeoData API manager to get the boundaries of the zip codes.
            Microsoft.Maps.SpatialDataService.GeoDataAPIManager.getBoundary(
                records,
                geoDataRequestOptions,
                map,
                function (data) {
					
                    //Called once for each county.
                    if (data.results && data.results.length > 0) {
						
						
						var name = data.location;
						var apartment = 'studio';
						
						//Index in county array
						var cost = records.indexOf(name);
						
						//Cost from cost array based on index
						var apt = studios[cost];
						
						//Crime median
						var crime_med = coefficient;
						
						//Crime/population
						var tot_pop = crimes[cost];
						
						//Crime %
						var compare_crime = (tot_pop/crime_med)*100;
						
						//Rent median
						var rent_med = med_rent;
						
						//Rent %
						var compare_rent = (apt/rent_med)*100;
							
					
					
						//Changing colors for county
						for (var i = 0, len = data.results[0].Polygons.length; i < len; i++) {
							
							if (tot_pop == ''){
								data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(151, 156, 155, 0.1)',
								strokeColor: 'black',
								strokeThickness: 1});
							}
							
							else {
								if ( compare_crime > 300){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(132, 20, 5, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});}
								else if (compare_crime > 250){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(186, 28, 7, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});
								}
								else if ( compare_crime > 200){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(246, 45, 18, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});}
								else if (compare_crime > 175){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(249, 110, 92, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});
								}
								else if (compare_crime > 150){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(252, 162, 150, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});
								}
								else if ( compare_crime > 125){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(253, 197, 190, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});}
								else if ( compare_crime > 100){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(254, 232, 229, 0.8)',
									strokeColor: 'black',
									strokeThickness:  1});}
								else if ( compare_crime < 10){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(19, 117, 101, 0.8)',
									strokeColor: 'black',
									strokeThickness: 1});}
								else if ( compare_crime < 25){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(22, 135, 117, 0.8)',
									strokeColor: 'black',
									strokeThickness: 1});}
								else if ( compare_crime < 50){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(32, 176, 153, 0.8)',
									strokeColor: 'black',
									strokeThickness: 1});}
								else if ( compare_crime < 75){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(47, 224, 196, 0.8)',
									strokeColor: 'black',
									strokeThickness: 1});}
								else if ( compare_crime < 95){
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(161, 247, 220, 0.8)',
									strokeColor: 'black',
									strokeThickness: 1});}
								else {
									data.results[0].Polygons[i].setOptions({ fillColor: 'rgba(253, 253, 253, 0.5)',
									strokeColor: 'black',
									strokeThickness: 1});
								}
							}
							
						}
						var polygon = data.results[0].Polygons;
						
						//Changing color for 'house' pushpin
						var fillColor;
						
						if (compare_rent > 300) {
							fillColor = 'rgba(133, 7, 10, 1)';
						}
						else if (compare_rent > 250) {
							fillColor = 'rgba(143, 14, 17, 1)';
						}
						else if (compare_rent > 200) {
							fillColor = 'rgba(158, 25, 28, 1)';
						}
						else if (compare_rent > 175) {
							fillColor = 'rgba(173, 38, 41, 1)';
						}
						else if (compare_rent > 150) {
							fillColor = 'rgba(189, 58, 61, 1)';
						}
						else if (compare_rent > 125){
							fillColor = 'rgba(204, 86, 88, 1)';
						}
						else if (compare_rent > 100){
							fillColor = 'rgba(214, 111, 113, 1)';
						}
						else if (compare_rent < 50) {
							fillColor = 'rgba(6, 92, 76, 1)';
						}
						else if (compare_rent < 75){
							fillColor = 'rgba(23, 115, 98, 1)';
						}
						else if (compare_rent < 99){
							fillColor = 'rgba(52, 140, 124, 1)';
						}
						else if (compare_rent <= 100){
							fillColor = 'rgba(160, 232, 220, 1)';
						}
						else {
							fillColor = 'rgba(0, 0, 0, 0.5)';
						}

							
						
						map.entities.push(polygon);
						
						
						//House pushpin
						centroid = new Microsoft.Maps.Pushpin(Microsoft.Maps.SpatialMath.Geometry.centroid(polygon), {	icon: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="37" viewBox="0 0 30 37" xml:space="preserve"><polygon style="fill:{color};stroke-width:1;stroke:#000000;" points="1,1 29,1 29,29 20,29 15,37 10,29 1,29 1,1"/><image x="4" y="4" width="22" height="22" xlink:href="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2232%22%20height%3D%2232%22%20viewBox%3D%220%200%20512%20512%22%20xml%3Aspace%3D%22preserve%22%3E%3Cg%20transform%3D%22translate(0%2C448)%22%3E%3Cpath%20style%3D%22fill%3A%23ffffff%3Bfill-opacity%3A1%3Bstroke%3A%7BsymbolColor%3Bstroke-width%3A12%3Bstroke-linecap%3Abutt%3Bstroke-linejoin%3Around%3Bstroke-miterlimit%3A4%3Bstroke-opacity%3A1%3Bstroke-dasharray%3Anone%22%20d%3D%22m%2016%2C256%20240%2C-192%2096%2C72%200%2C-32%2048%2C0%200%2C72%2096%2C80%20-48%2C0%200%2C192%20-120%2C0%200%2C-160%20-96%2C0%200%2C160%20-168%2C0%200%2C-192%20z%22%20transform%3D%22translate(0%2C-448)%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E"/><text x="15" y="20" style="font-size:16px;font-family:arial;fill:#ffffff;" text-anchor="middle">{text}</text></svg>',	anchor: new Microsoft.Maps.Point(15, 37),	color: fillColor,	text: ''});
						
						
						map.entities.push(centroid);
						centroid.metadata = {
							title: name,
							description: compare_rent.toString()
						};
						
						var infobox = new Microsoft.Maps.Infobox(centroid, {
							visible: false
						});
						
						map.entities.push(infobox);
						
						/*
						Microsoft.Maps.Events.addHandler(centroid, 'mouseover', function (e) {
							e.target.setOptions({ text: name });
						});
						Microsoft.Maps.Events.addHandler(centroid, 'mouseout', function (e) {
							e.target.setOptions({ text: "" });
						});
						Microsoft.Maps.Events.addHandler(centroid, 'mousedown', function (e) {
							e.target.setOptions({ text: "" });
						});
						*/
						
						Microsoft.Maps.Events.addHandler(centroid, 'click', function (e) {
							 //Make sure the infobox has metadata to display.
							if (e.target.metadata) {
								//Set the infobox options with the metadata of the pushpin.
								infobox.setOptions({
									location: e.target.getLocation(),
									title: e.target.metadata.title,
									description: e.target.metadata.description,
									visible: true
								});
							}
						});
						counter = counter + 1;
                    }
				}, function errCallback(networkStatus, statusMessage) {
					console.log(networkStatus);
					console.log(statusMessage);
                });
        });		
	}
	  
</script>