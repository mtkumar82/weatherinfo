<style type="text/css">

.paging-nav {
  text-align: right;
  padding-top: 2px;
}

.paging-nav a {
  margin: auto 1px;
  text-decoration: none;
  display: inline-block;
  padding: 1px 7px;
  background: #91b9e6;
  color: white;
  border-radius: 3px;
}

.paging-nav .selected-page {
  background: #187ed5;
  font-weight: bold;
}

.paging-nav,
#tableData {
  width: 400px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
}
</style>
<div class="main-page">
	
				
					<div class="grid-bottom widget-shadow" style="position:relative;">
						<div class="container">
            <tasks></tasks>
        </div>		   <template id="tasks-template">
						<!--<table class="table table-bordered table-striped no-margin grd_tble" id="tableData" style="width:100%;">
							<thead>
								<tr>
									<th>Date</th>
									<th>City Name</th>
									<th>Weather State</th>
									<th></th>
									<th>Temp</th>
									<th>Min Temp</th>
									<th>Max Temp</th>
									<th>Wind Speed</th>
									<th>Humidity</th>															
								</tr>
							</thead>
							
							<tbody  >
							<template class="list-group" v-for="weatherdata in list">
								<tr class="list-group-item" v-for="task in weatherdata.consolidated_weather" >
									<td>{{ task.applicable_date }}</td>	
									<td>{{ weatherdata.title}}</td>
									<td>{{ task.weather_state_name }} </td>
									<td><img src="https://www.metaweather.com/static/img/weather/{{ task.weather_state_abbr }}.svg" style="width:32px"/></td>
									<td>{{ task.the_temp }}	</td>									
									<td> {{ task.min_temp }}</td>									
									<td>{{ task.max_temp }}</td> 
									<td> {{ task.wind_speed }}</td>
									<td>{{ task.humidity }}</td>												
								</tr>
								</template>
							</tbody>
							
						</table> -->

						<ul v-for="weatherdata in list">
						
						Weather report for <b>{{ weatherdata.title}}</b>
						<br>
						<br>
						<li class="list-group-item" v-for="task in weatherdata.consolidated_weather">
						
							<p>Weather State: {{ task.weather_state_name }} &nbsp; &nbsp;<img src="https://www.metaweather.com/static/img/weather/{{ task.weather_state_abbr }}.svg" style="width:32px"/></p>
							<p>Temp: {{ task.the_temp }}</p>
							<p>Min Temp: {{ task.min_temp }}</p>
							<p>Max Temp: {{ task.max_temp }}</p>
							<p>Wind Speed: {{ task.wind_speed }}</p>
							<p>Humidity: {{ task.humidity }}</p>
							<p>Date: {{ task.applicable_date }}</p>
						</li></ul>
						 </template>
					</div>
					<div class="clearfix"> </div>
				</div>
				</div>
				<script type="text/javascript">				

				jQuery(document).ready( function() {
					jQuery('#tableData').DataTable();					
				});					
				</script>

				 <script>
		
		var store = {
			state: {
				tempData: []
			}
		};

            Vue.component('tasks', {
                template: '#tasks-template',
                data: function() {
                    return {
                        //list: [],
						list:store.state.tempData
                    };
                },
                created: function() {
					var countryName= ['Istanbul', 'Berlin', 'London', 'Helsinki', 'Dublin', 'Vancouver'];
					for(var i=0; i< 6; i++){
					   this.getAllWoeid(countryName[i]);
					}
                    //this.fetchTaskList();
                },
                methods: {
					//2344116
                    fetchTaskList: function(woeidCode) {
                        this.$http.get('weather.php?command=location&woeid='+woeidCode, function(tasks) {				store.state.tempData.push(tasks);	
                        //this.list = tasks;
                        }.bind(this));
                    },
					getAllWoeid: function(countryname){
					   this.$http.get('weather.php?command=search&keyword='+countryname, function(cdata) {
						  this.fetchTaskList(cdata[0].woeid);
                        }.bind(this));
					}
                }
            })
            new Vue({
                el: 'body'
            });

			/*
			  items:[
					{header:"Date"},
					{header:"City Name"},
					{header:"Weather State"},
					{header:"IMG"},
					{header:"Temp"},
					{header:"Min Temp"},
					{header:"Max Temp"},
					{header:"Wind Speed"},
					{header:"Humidity"}
				]
			*/
        </script>