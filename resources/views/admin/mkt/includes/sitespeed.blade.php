<div class="uk-form rv-useranalytic uk-margin-bottom">
<h2 id="gaSiteSpeed">Site speed</h2>
<select id="selectDateSiteSpeed">
  <option value="today">Today</option>
  <option value="yesterday">Yesterday</option>
  <option value="7daysAgo" selected="selected" >Last 7 days</option>
  <option value="15daysAgo">Last 15 days</option>
  <option value="30daysAgo">Last 30 days</option>
  <option value="90daysAgo">Last 90 days</option>
</select>
<section id="Sitespeed"></section>
</div>

@push('package-scripts')
<script>
	
    google.charts.load('current', {'packages':['table']});
    
    google.charts.setOnLoadCallback(drawTableSiteSpeed);
    
    function drawTableSiteSpeed() {
        var data = new google.visualization.DataTable();
        
        data.addColumn('string', 'Landing Screen');
        data.addColumn('string', 'PageSpeed Insights');
        data.addColumn('string', 'Avg. Page Load Time (sec)');
        data.addColumn('number', 'Pageviews');
        data.addColumn('string', 'Bounce Rate');
        data.addColumn('string', '%Exit');

        @forelse($sitespeed as $item)
        	var pagespeedInsight = '<div align="center"><a href="javascript:void(0)" onclick="window.open(\'https://developers.google.com/speed/pagespeed/insights/?url={{$item[0]}}\',\'popup\',\'width=800,height=800\'); return false;"><i class="uk-icon uk-icon-external-link"></i> Info</a></div>';
            data.addRows([
                  //decodeURI() must be  decode or using raw data
                  [ decodeURI("{{ $item[0] }}") , pagespeedInsight ,  parseFloat({{ $item[1] }}).toFixed(2) , {{ $item[2] }} , parseFloat({{ $item[3] }}).toFixed(2)+'%', parseFloat({{ $item[4] }}).toFixed(2)+'%' ],
            ]);
        @empty
        	data.addRows([
			  	  [ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null , null , null ,null ],
			]);
        @endforelse

		//set text align
		for (i = 0; i < data.getNumberOfRows(); i++) { 
			for (j = 2; j < data.getNumberOfColumns(); j++) {
				data.setProperty(i, j, 'style', 'text-align: right;');
			}
        }
              
        var table = new google.visualization.Table(document.getElementById('Sitespeed'));
        
        table.draw(data, {allowHtml: true, showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30',cssClassNames:''});
  	}

    function drawTablePageSpeedWithSelectDate(datarow) {
    	
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Landing Screen');
        data.addColumn('string', 'PageSpeed Insights');
        data.addColumn('string', 'Avg. Page Load Time (sec)');
        data.addColumn('string', 'Pageviews');
        data.addColumn('string', 'Bounce Rate');
        data.addColumn('string', '%Exit');

		if ($.isEmptyObject(datarow)) {
			data.addRows([
				[ '<div class="uk-alert uk-alert-large" data-uk-alert><h5>Report is coming soon.</h5><p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p></div>' ,  null , null , null , null ,null ],
     		]);
		} else {
            $.each (datarow, function (i,datarow) {
            	var pagespeedInsight = '<div align="center"><a href="javascript:void(0)" onclick="window.open(\'https://developers.google.com/speed/pagespeed/insights/?url='+datarow[0]+'\',\'popup\',\'width=800,height=800\'); return false;"><i class="uk-icon uk-icon-external-link"></i> Info</a></div>';
                data.addRows([
            			//console.log(datarow.keys[0]+' '+datarow.clicks+' '+datarow.impressions+' '+datarow.ctr+' '+datarow.position);
                		[  decodeURI(datarow[0]) , pagespeedInsight , parseFloat(datarow[1]).toFixed(2) , datarow[2] , parseFloat(datarow[3]).toFixed(2)+'%'  , parseFloat(datarow[4]).toFixed(2)+'%' ],
             	]);
            });
		}

		//set text align
		for (i = 0; i < data.getNumberOfRows(); i++) { 
			for (j = 2; j < data.getNumberOfColumns(); j++) {
				data.setProperty(i, j, 'style', 'text-align: right;');
			}
        }
        
        var table = new google.visualization.Table(document.getElementById('Sitespeed'));
        
        table.draw(data, {allowHtml: true, showRowNumber: true, width: '100%', height: '100%',page: 'enable',pageSize: '30'});
  	}

    //if select date
    $('#selectDateSiteSpeed').on('change', function() {
        var datetext = $("#selectDateSiteSpeed :selected").text();
    	var startdate = this.value;
    	var enddate = 'yesterday';
    	if(startdate == 'today'){
        	enddate = 'today';
    	}
        var data = {'startdate': startdate,'enddate': enddate};
      	var url = '{!! route("admin.marketing.mkt.ajaxsitespeed") !!}';
      	doAnAjax(url,data,'get', function(error, data) {
      		google.charts.setOnLoadCallback(drawTablePageSpeedWithSelectDate(data.row));
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
