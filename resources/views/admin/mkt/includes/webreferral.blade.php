<div class="uk-form rv-useranalytic uk-margin-bottom">
<h2 id="gaWebreferral">Who link to your site</h2>
<select id="selectDatewebReferral">
  <option value="today">Today</option>
  <option value="yesterday">Yesterday</option>
  <option value="7daysAgo" selected="selected" >Last 7 days</option>
  <option value="15daysAgo">Last 15 days</option>
  <option value="30daysAgo">Last 30 days</option>
  <option value="90daysAgo">Last 90 days</option>
</select>
<section id="webReferral"></section>
</div>

@push('package-scripts')
<script>
gapi.analytics.ready(function() {
	 //Create the timeline chart.
	var commonConfigWebreferral = {
    	 reportType: 'ga',
    	 query: {
             'metrics': 'ga:impressions,ga:CTR,ga:sessions,ga:bounceRate,ga:pageviewsPerSession,ga:goalCompletionsAll,ga:goalValueAll,ga:searchGoalConversionRateAll',
             'dimensions': 'ga:fullReferrer',
             'start-date': '7daysAgo',
             'end-date': 'yesterday',
             'sort':	'-ga:sessions',
           },
           chart: {
             container: 'webReferral',
             type: 'TABLE',
              options: {
                width: '100%',
                //title: 'Who link to your site', TABLE can't be set title
                page: 'enable',
                pageSize: '30',
                showRowNumber: true
              },
           }
	};
    var webReferral = new gapi.analytics.googleCharts.DataChart(commonConfigWebreferral);
    var newIds = {
                      query: {
                          ids: 'ga:{{ $google_ana_web_id }}'
                      }
                }
    webReferral.set(newIds).execute();

    //if select date
    $('#selectDatewebReferral').on('change', function() {
        var datetext = $("#selectDatewebReferral :selected").text();
    	var startdate = this.value;
    	var enddate = 'yesterday';
    	if(startdate == 'today'){
        	enddate = 'today';
    	}
    	var dateRange = {
    		    'start-date': startdate,
    		    'end-date': enddate
    	};
    	
    	var webReferral = new gapi.analytics.googleCharts.DataChart(commonConfigWebreferral)
        .set({query: dateRange})
        .set(newIds)
        .execute();
    	  
    })
	
});

//check if no data response
//can't check on response because data respon too slow (async)
//TODO if using this function it still too much recursion , what should we do ?
$('#webReferral').bind("DOMSubtreeModified",function(){
	 if($('.google-visualization-table-table > tbody').html() == '') {
		 $('.google-visualization-table-table > tbody').html('<tr>'+
                                            					'<td colspan="6">'+
                                            						'<div class="uk-alert uk-alert-large" data-uk-alert>'+
                                            						'<h5>Report is coming soon.</h5>'+
                                            						 '<p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p>'+
                                            					'</div>'+
                                            						'</td>'+
                                               				 '</tr>');
	 }
});
</script>
@endpush