<div class="uk-form rv-useranalytic uk-margin-bottom">
    <h2>Visitors</h2>
    <div class="rv-panel-box-shadow">
        <select id="selectDateVisitors">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="7daysAgo" selected="selected">Last 7 days</option>
            <option value="15daysAgo">Last 15 days</option>
            <option value="30daysAgo">Last 30 days</option>
            <option value="90daysAgo">Last 90 days</option>
        </select>
        <section id="Visitors"></section>
    </div>
</div>
@push('package-scripts')
<script>
gapi.analytics.ready(function() {
     //Create the timeline chart.
    var commonConfigVisitors = {
            reportType: 'ga',
            query: {
              'metrics': 'ga:users',
              'dimensions': 'ga:userType',
              'start-date': '7daysAgo',
              'end-date': 'yesterday',
            },
            chart: {
              container: 'Visitors',
              type: 'PIE',
               options: {
                 width: '400',
                 //title: 'Visitors',
                 pieHole: 0.3,
               },
            }
    };
    var Visitors = new gapi.analytics.googleCharts.DataChart(commonConfigVisitors);
    var newIds = {
                      query: {
                        ids: 'ga:{{ $google_ana_web_id }}'
                      }
                }
    Visitors.set(newIds).execute();

    //if select date
    $('#selectDateVisitors').on('change', function() {
        var datetext = $("#selectDateVisitors :selected").text();
        var startdate = this.value;
        var enddate = 'yesterday';
        if(startdate == 'today'){
            enddate = 'today';
        }
        var dateRange = {
                'start-date': startdate,
                'end-date': enddate
        };

        var Visitors = new gapi.analytics.googleCharts.DataChart(commonConfigVisitors)
        .set({query: dateRange})
        .set(newIds)
        .execute();

    })

});

//check if no data response
//can't check on response because data respon too slow (async)
//TODO if using this function it still too much recursion , what should we do ?
$('#Visitors').bind("DOMSubtreeModified",function(){
     if($('#Visitors').text().match(/(No data|ไม่มีข้อมูล)/ig)) {
         $('#Visitors').html('<div class="uk-grid">'+
                              '<div class="uk-width-medium-1-3">'+
                                  '<div class="uk-alert uk-alert-large" data-uk-alert>'+
                                      '<a href="" class="uk-alert-close uk-close"></a>'+
                                      '<h5>Report is coming soon.</h5>'+
                                      '<p>The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later.</p>'+
                                  '</div>'+
                                  '</div>'+
                              '</div>');
         return;
     }
});
</script>
@endpush
