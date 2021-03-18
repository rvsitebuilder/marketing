<div class="uk-form rv-useranalytic uk-margin-bottom">
<h2 id="gaTopkeyword">Top Keyword</h2>
<select id="selectDateSearchAnalytic">
  <option value="today">Today</option>
  <option value="yesterday">Yesterday</option>
  <option value="7" selected="selected" >Last 7 days</option>
  <option value="15">Last 15 days</option>
  <option value="30">Last 30 days</option>
  <option value="90">Last 90 days</option>
</select>
<div id="SearchAnalyticQueryData"></div>
</div>
@push('package-scripts')
<script>
    google.charts.load('current', {'packages':['table']});
    
    //create table
    google.charts.setOnLoadCallback(drawTableTopkeyword);
    
    function drawTableTopkeyword() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Query');
        data.addColumn('number', 'Click');
        data.addColumn('number', 'Impressions');
        data.addColumn('number', 'CTR');
        data.addColumn('number', 'Position');
        data.addRows([
       	  @forelse($queryrow as $item)
          [ "{{ $item['keys'][0] }}" ,  {{ $item['clicks'] }} , {{ $item['impressions'] }} , {v: {{ $item['ctr'] }} , f: "{{ $item['ctr'] }}%" } , {{ $item['position'] }} ],
          @empty
          [ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null , null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('SearchAnalyticQueryData'));
        
        table.draw(data, {allowHtml:true,showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30'});
  	}

    function drawTableTopkeywordWithSelectDate(datarow) {
	
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Query');
        data.addColumn('number', 'Click');
        data.addColumn('number', 'Impressions');
        data.addColumn('number', 'CTR');
        data.addColumn('number', 'Position');

		if ($.isEmptyObject(datarow)) {
			data.addRows([
        		[ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null , null , null ],
     		]);
		} else {
            $.each (datarow, function (i,datarow) {
                data.addRows([
            			//console.log(datarow.keys[0]+' '+datarow.clicks+' '+datarow.impressions+' '+datarow.ctr+' '+datarow.position);
                		[ datarow.keys[0] ,  datarow.clicks , datarow.impressions , {v: datarow.ctr , f: datarow.ctr+"%"}  , datarow.position ],
             	]);
            });
		}
        
        var table = new google.visualization.Table(document.getElementById('SearchAnalyticQueryData'));
        
        table.draw(data, {allowHtml:true,showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30'});
  	}


    //if select date
    $('#selectDateSearchAnalytic').on('change', function() {
        var datetext = $("#selectDateSearchAnalytic :selected").text();
    	var startdate = this.value;
    	var enddate = 'yesterday';
    	if(startdate == 'today'){
        	enddate = 'today';
    	}
        var data = {'startdate': startdate,'enddate': enddate};
      	var url = '{!! route("admin.marketing.mkt.ajaxtopkeyword") !!}';
      	doAnAjax(url,data,'get', function(error, data) {
      		google.charts.setOnLoadCallback(drawTableTopkeywordWithSelectDate(data.row));
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