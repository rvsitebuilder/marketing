<div class="uk-form rv-useranalytic uk-margin-bottom">
	<h2 id="gaPerformance">Performance of your site</h2>
	<div class="rv-panel-box-shadow">
		<select id="selectDatePerformance">
			<option value="today">Today</option>
			<option value="yesterday">Yesterday</option>
			<option value="7daysAgo" selected="selected">Last 7 days</option>
			<option value="15daysAgo">Last 15 days</option>
			<option value="30daysAgo">Last 30 days</option>
			<option value="90daysAgo">Last 90 days</option>
		</select>
		<section id="PerformanceTable"></section>
		<section id="PerformanceLine"></section>
	</div>
</div>
@push('package-scripts')
<script>
gapi.analytics.ready(function() {
	 //Create the timeline chart.
	 var commonConfigTable = {
		        query: {
		        	'metrics':'ga:sessions,ga:users,ga:pageviews,ga:pageviewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:percentNewSessions',
		        	'start-date': '7daysAgo',
		            'end-date': 'yesterday'
		          },
		          chart: {
		            type: 'TABLE',
		            container: 'PerformanceTable',
		            options: {
		              width: '100%'
		              //title: 'Performance' type table ใส่ title ไม่ได้
		            },
		          }
		};
	var commonConfigLine = {
	        query: {
	        	'metrics':'ga:users,ga:sessions',
	        	'dimensions': 'ga:date',
	        	'start-date': '7daysAgo',
	            'end-date': 'today'
	          },
	          chart: {
	            type: 'LINE',
	            container: 'PerformanceLine',
	            options: {
	              width: '100%',
	            },
	          }
		};
	
  	var PerformanceTable = new gapi.analytics.googleCharts.DataChart(commonConfigTable);
    var PerformanceLine = new gapi.analytics.googleCharts.DataChart(commonConfigLine);
	
 
    var newIds = {
                      query: {
                          ids: 'ga:{{ $google_ana_web_id }}'
                      }
                }
    PerformanceTable.set(newIds).execute();
    PerformanceLine.set(newIds).execute();

	//if select date
    $('#selectDatePerformance').on('change', function() {
        var datetext = $("#selectDatePerformance :selected").text();
    	var startdate = this.value;
    	var enddate = 'yesterday';
    	if(startdate == 'today'){
        	enddate = 'today';
    	}
    	var dateRange = {
    		    'start-date': startdate,
    		    'end-date': enddate
    	};
    	
    	var PerformanceTable = new gapi.analytics.googleCharts.DataChart(commonConfigTable)
        .set({query: dateRange})
        .set(newIds)
        .execute();
    	var PerformanceLine = new gapi.analytics.googleCharts.DataChart(commonConfigLine)
        .set({query: dateRange})
        .set(newIds)
        .execute();
    	  
    })

});

//check if no data response
//can't check on response because data respon too slow (async)
//TODO if using this function it still too much recursion , what should we do ?
$('#PerformanceTable').bind("DOMSubtreeModified",function(){
	 if($('.google-visualization-table-table > tbody').html() == '') {
		 $('.google-visualization-table-table > tbody').html('<tr>'+
				 												'<td colspan="4">'+
				 												'<div class="uk-alert uk-alert-large uk-margin-top uk-margin-bottom" data-uk-alert>'+
				 												'<h5>No result found.</h5>'+
                                            						 '<p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p>'+
                                            					'</div>'+
     															'</td>'+
                                               				 '</tr>');
	 }
});
</script>
@endpush