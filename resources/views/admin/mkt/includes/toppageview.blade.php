<div class="uk-form rv-useranalytic uk-margin-bottom">
	<h2 id="gaTopPageUserVisit">What page do your user visits</h2>
	<select id="selectDateTopPageUserVisit">
		<option value="today">Today</option>
		<option value="yesterday">Yesterday</option>
		<option value="7daysAgo" selected="selected">Last 7 days</option>
		<option value="15daysAgo">Last 15 days</option>
		<option value="30daysAgo">Last 30 days</option>
		<option value="90daysAgo">Last 90 days</option>
	</select>
	<div id="TopPageVisit"></div>
</div>
@push('package-scripts')
<script>
    google.charts.load('current', {'packages':['table']});
    
    //create table
    google.charts.setOnLoadCallback(drawTableTopPageUserVisit);
    
    function drawTableTopPageUserVisit() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Page');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Page Values');
        
        data.addRows([
        
          @forelse($visitrow as $item)
          [ "{{ $item[0] }}" ,  {{ $item[2] }} , {v: {{ $item[1] }} , f: "${{ $item['1'] }}" } ],
          @empty
          [ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('TopPageVisit'));
        
        table.draw(data, {allowHtml:true,showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30'});
  	}

    function drawTableTopPageVisitWithSelectDate(datarow) {
    	//console.log(datarow);
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Page');
        data.addColumn('number', 'Page Views');
        data.addColumn('number', 'Page Values');

		if ($.isEmptyObject(datarow)) {
			data.addRows([
        		[ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null ],
     		]);
		} else {
            $.each (datarow, function (i,datarow) {
                data.addRows([
                		[ datarow[0] , parseInt(datarow[2]) , {v: parseInt(datarow[1]) , f: "$"+parseFloat(datarow[1]).toFixed(1)} ],
             	]);
            });
		}
        
        var table = new google.visualization.Table(document.getElementById('TopPageVisit'));
        
        table.draw(data, {allowHtml:true,showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30'});
  	}

  //if select date
    $('#selectDateTopPageUserVisit').on('change', function() {
        var datetext = $("#selectDateTopPageUserVisit :selected").text();
    	var startdate = this.value;
    	var enddate = 'yesterday';
    	if(startdate == 'today'){
        	enddate = 'today';
    	}
        var data = {'startdate': startdate,'enddate': enddate};
      	var url = '{!! route("admin.marketing.mkt.ajaxtoppageuservisit") !!}';
      	doAnAjax(url,data,'get', function(error, data) {
      		google.charts.setOnLoadCallback(drawTableTopPageVisitWithSelectDate(data.row));
		});	
    	  
    });

    function doAnAjax(url,data,type,callback) {
    	$.ajax({
    		url : url,
    		data : data,
    		cache : false,
    		type : type,
    		error : function() {
    			callback("error", null);
    		},
    		success : function(data) {
    			callback(null, data);
    		}
    	});
	}
  	
</script>
@endpush