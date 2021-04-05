<div class="uk-form rv-useranalytic uk-margin-bottom">
    <h2 id="gaCountry">Where are your users</h2>
    <div class="rv-panel-box-shadow">
        <select id="selectDateCountry">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="7daysAgo" selected="selected">Last 7 days</option>
            <option value="15daysAgo">Last 15 days</option>
            <option value="30daysAgo">Last 30 days</option>
            <option value="90daysAgo">Last 90 days</option>
        </select>
        <section id="SessionCountry"></section>
    </div>
</div>
@push('package-scripts')
<script>
gapi.analytics.ready(function() {
     //Create the timeline chart.
    var commonConfigCountry = {
            reportType: 'ga',
            query: {
              'metrics': 'ga:sessions',
              'dimensions': 'ga:country',
              'start-date': '7daysAgo',
              'end-date': 'yesterday',
              'sort': '-ga:sessions'
            },
            chart: {
              container: 'SessionCountry',
              type: 'GEO',
               options: {
                 width: '400',
                 //title: 'Where are your users' chart แบบ GEO ใส่ title ไม่ได้
               },
            }
    };
    var SessionCountry = new gapi.analytics.googleCharts.DataChart(commonConfigCountry);
    var newIds = {
                      query: {
                          ids: 'ga:{{ $google_ana_web_id }}'
                      }
                }
    SessionCountry.set(newIds).execute();

      //if select date
    $('#selectDateCountry').on('change', function() {
        var datetext = $("#selectDateCountry :selected").text();
        var startdate = this.value;
        var enddate = 'yesterday';
        if(startdate == 'today'){
            enddate = 'today';
        }
        var dateRange = {
                'start-date': startdate,
                'end-date': enddate
        };

        var SessionCountry = new gapi.analytics.googleCharts.DataChart(commonConfigCountry)
        .set({query: dateRange})
        .set(newIds)
        .execute();

    })

});
</script>
@endpush
