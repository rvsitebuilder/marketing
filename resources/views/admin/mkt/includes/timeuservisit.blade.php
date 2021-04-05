<div class="uk-form rv-useranalytic uk-margin-bottom">
    <h2>When do your user visit?</h2>
    <div class="rv-panel-box-shadow">
        <select id="selectDateTimeUserVisit">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="7daysAgo" selected="selected">Last 7 days</option>
            <option value="15daysAgo">Last 15 days</option>
            <option value="30daysAgo">Last 30 days</option>
            <option value="90daysAgo">Last 90 days</option>
        </select>
        <section id="TimeUserVisit"></section>
    </div>
</div>
@push('package-scripts')
<script>
gapi.analytics.ready(function() {
     //Create the timeline chart.
    var commonConfigTimeUserVisit = {
            reportType: 'ga',
            query: {
              'metrics': 'ga:users',
              'dimensions': 'ga:hour',
              'start-date': '7daysAgo',
              'end-date': 'yesterday',
            },
            chart: {
              container: 'TimeUserVisit',
              type: 'COLUMN',
               options: {
                 width: '500',
                 //title: 'When do your user visit?',
                 hAxis: {
                          title: 'Time of Day',
                 },
               },
            }
    };
    var TimeUserVisit = new gapi.analytics.googleCharts.DataChart(commonConfigTimeUserVisit);
    var newIds = {
                      query: {
                          ids: 'ga:{{ $google_ana_web_id }}'
                      }
                }
    TimeUserVisit.set(newIds).execute();

    //if select date
    $('#selectDateTimeUserVisit').on('change', function() {
        var datetext = $("#selectDateTimeUserVisit :selected").text();
        var startdate = this.value;
        var enddate = 'yesterday';
        if(startdate == 'today'){
            enddate = 'today';
        }
        var dateRange = {
                'start-date': startdate,
                'end-date': enddate
        };

        var TimeUserVisit = new gapi.analytics.googleCharts.DataChart(commonConfigTimeUserVisit)
        .set({query: dateRange})
        .set(newIds)
        .execute();

    })

});
</script>
@endpush
