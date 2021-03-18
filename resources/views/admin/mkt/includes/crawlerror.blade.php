<div>
   <h2>Crawl Errors</h2>
   <div>
   	  <div class="uk-grid" id="crawlerrorNoresult" style="display:none;">
         <div class="uk-width-medium-1-1 uk-margin-bottom">
         	<div class="uk-alert" data-uk-alert>
                <a href="" class="uk-alert-close uk-close"></a>  
                @lang('rvsitebuilder/marketing::addon.Google.CreawlError')
            </div>
         </div>
      </div>
      
      <div class="uk-margin-bottom">
         <span class="uk-text-primary">Status:</span> {{ date('Y-m-d',strtotime("-1 days")) }}
      </div>
      <div class="uk-grid">
         <div class="uk-width-medium-1-1 uk-margin-bottom">
				<div class="rv-nav-crawl">
					<div class="uk-navbar-nav">
						<ul class="uk-tab" data-uk-tab="{connect:'#crawlerror'}">
							<li class="uk-active"><a href="#desktop">Desktop</a></li>
							<li><a href="#smartphone">Smartphone</a></li>
						</ul>
					</div>
				</div>
			</div>
         <div class="uk-width-medium-1-1">
            <div id="crawlerror" class="uk-switcher">
               <div id="desktop">
                  <p class="uk-margin-bottom">Content tap desktop</p>
                  <div class="uk-grid">
                     <div class="uk-width-medium-1-1 uk-margin-bottom">
						<div class="rv-nav-property-crawl">
							<div class="uk-navbar-nav">
								<ul class="uk-tab" data-uk-tab="{connect:'#content-desktop'}">
									<li class="uk-active"><a id="web_servererror"
										href="#servererror">Server error</a></li>
									<li><a id="web_soft404" href="#soft404">Soft 404</a></li>
									<li><a id="web_notfound" href="#notfound">Not found</a></li>
									<li><a id="web_authperm" href="#authperm">Auth permissions</a></li>
									<li><a id="web_notfollow" href="#notfollow">Not followed</a></li>
									<li><a id="web_other" href="#other">Other</a></li>
								</ul>
							</div>
						</div>
					</div>
                     <div class="uk-width-medium-1-1 uk-margin-bottom">
                        <div id="content-desktop" class="uk-switcher">
                           <div id="servererror">
                              <div id="desktop-servererror"></div>
                           </div>
                           <div id="soft404">
                              <div id="desktop-soft404"></div>
                           </div>
                           <div id="notfound">
                              <div id="desktop-notfound"></div>
                           </div>
                           <div id="authperm">
                              <div id="desktop-authperm"></div>
                           </div>
                           <div id="notfollow">
                              <div id="desktop-notfollow"></div>
                           </div>
                           <div id="other">
                              <div id="desktop-other"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="smartphone">
                  <p class="uk-margin-bottom">Content tap smartphone</p>
                  <div class="uk-grid">
					<div class="uk-width-medium-1-1 uk-margin-bottom">
						<div class="rv-nav-property-crawl">
							<div class="uk-navbar-nav">
								<ul class="uk-tab"
									data-uk-tab="{connect:'#content-smartphone'}">
									<li class="uk-active"><a id="smartphone_servererror"
										href="#s-servererror">Server error</a></li>
									<li><a id="smartphone_authperm" href="#s-authPerm">Auth
											Permissions</a></li>
									<li><a id="smartphone_flashcontent" href="#s-flashContent">Flash
											content</a></li>
									<li><a id="smartphone_manytooneredir"
										href="#s-manyToOneRedirect">Many To One Redirect</a></li>
									<li><a id="smartphone_notfollow" href="#s-notFollowed">Not
											followed</a></li>
									<li><a id="smartphone_notfound" href="#s-notFound">Not found</a></li>
									<li><a id="smartphone_robot" href="#s-roboted">Roboted</a></li>
									<li><a id="smartphone_soft404" href="#s-soft404">Soft 404</a></li>
									<li><a id="smartphone_other" href="#s-other">Other</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="uk-width-medium-1-1  uk-margin-bottom">
                        <div id="content-smartphone" class="uk-switcher">
                           <div id="s-servererror">
                              <div id="smartphone-servererror"></div>
                           </div>
                           <div id="s-authPerm">
                              <div id="smartphone-authperm"></div>
                           </div>
                           <div id="s-flashContent">
                              <div id="smartphone-flashcontent"></div>
                           </div>
                           <div id="s-manyToOneRedirect">
                              <div id="smartphone-manytooneredirect"></div>
                           </div>
                           <div id="s-notFollowed">
                              <div id="smartphone-notfollowed"></div>
                           </div>
                           <div id="s-notFound">
                              <div id="smartphone-notfound"></div>
                           </div>
                           <div id="s-roboted">
                              <div id="smartphone-roboted"></div>
                           </div>
                           <div id="s-soft404">
                              <div id="smartphone-soft404"></div>
                           </div>
                           <div id="s-other">
                              <div id="smartphone-other"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>
      </div>
   </div>
</div>

@push('package-scripts')
<script>
    google.charts.load('current', {'packages':['table']});

    //count error type
 	$("#smartphone_servererror").text($("#smartphone_servererror").text()+' ('+{{$mobile_servererror_count}}+')');
	$("#smartphone_other").text($("#smartphone_other").text()+' ('+{{$mobile_other_count}}+')');
    $("#smartphone_soft404").text($("#smartphone_soft404").text()+' ('+{{$mobile_soft404_count}}+')');
    $("#smartphone_robot").text($("#smartphone_robot").text()+' ('+{{$mobile_robot_count}}+')');
    $("#smartphone_notfound").text($("#smartphone_notfound").text()+' ('+{{$mobile_notfound_count}}+')');
    $("#smartphone_notfollow").text($("#smartphone_notfollow").text()+' ('+{{$mobile_notfollow_count}}+')');
    $("#smartphone_authperm").text($("#smartphone_authperm").text()+' ('+{{$mobile_authperm_count}}+')');
    $("#smartphone_flashcontent").text($("#smartphone_flashcontent").text()+' ('+{{$mobile_flashcontent_count}}+')');
    $("#smartphone_manytooneredir").text($("#smartphone_manytooneredir").text()+' ('+{{$mobile_manytooneredir_count}}+')');
    $("#web_servererror").text($("#web_servererror").text()+' ('+{{$web_servererror_count}}+')');
    $("#web_soft404").text($("#web_soft404").text()+' ('+{{$web_soft404_count}}+')');
    $("#web_notfound").text($("#web_notfound").text()+' ('+{{$web_notfound_count}}+')');
    $("#web_authperm").text($("#web_authperm").text()+' ('+{{$web_authperm_count}}+')');
    $("#web_notfollow").text($("#web_notfollow").text()+' ('+{{$web_notfollow_count}}+')');
    $("#web_other").text($("#web_other").text()+' ('+{{$web_other_count}}+')');

    //if no data crawlerror then display infobox who data is null
    var sumoferror = {{$mobile_servererror_count}}+{{$mobile_other_count}}+{{$mobile_soft404_count}}+
    				 {{$mobile_robot_count}}+{{$mobile_notfound_count}}+{{$mobile_notfollow_count}}+
    				 {{$mobile_authperm_count}}+{{$mobile_flashcontent_count}}+{{$mobile_manytooneredir_count}}+
    				 {{$web_servererror_count}}+{{$web_soft404_count}}+{{$web_notfound_count}}+
    				 {{$web_authperm_count}}+{{$web_notfollow_count}}+{{$web_other_count}};
    if(sumoferror == 0) {
    	$("#crawlerrorNoresult").show();
    }
    
    
    
    //create table
    google.charts.setOnLoadCallback(drawTable_desktop_notfound);
    google.charts.setOnLoadCallback(drawTable_desktop_servererror);
    google.charts.setOnLoadCallback(drawTable_desktop_soft404);
    google.charts.setOnLoadCallback(drawTable_desktop_authperm);
    google.charts.setOnLoadCallback(drawTable_desktop_notfollow);
    google.charts.setOnLoadCallback(drawTable_desktop_other);
    google.charts.setOnLoadCallback(drawTable_smartphone_servererror);
    google.charts.setOnLoadCallback(drawTable_smartphone_authperm);
    google.charts.setOnLoadCallback(drawTable_smartphone_flashcontent);
    google.charts.setOnLoadCallback(drawTable_smartphone_manytooneredirect);
    google.charts.setOnLoadCallback(drawTable_smartphone_notfollowed);
    google.charts.setOnLoadCallback(drawTable_smartphone_notfound);
    google.charts.setOnLoadCallback(drawTable_smartphone_roboted);
    google.charts.setOnLoadCallback(drawTable_smartphone_soft404);
    google.charts.setOnLoadCallback(drawTable_smartphone_other);

    function drawTable_smartphone_other() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_other as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "Report is coming soon. The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-other'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}

    function drawTable_smartphone_soft404() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_soft404 as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-soft404'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
        
  	}

    function drawTable_smartphone_roboted() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_robot as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-roboted'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
        
  	}

    function drawTable_smartphone_notfound() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_notfound as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-notfound'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
        
  	}

    function drawTable_smartphone_notfollowed() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_notfollow as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-notfollowed'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
        
  	}
    
    function drawTable_smartphone_manytooneredirect() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_manytooneredir as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-manytooneredirect'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_smartphone_flashcontent() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_flashcontent as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-flashcontent'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_smartphone_authperm() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_authperm as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-authperm'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_smartphone_servererror() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($mobile_servererror as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('smartphone-servererror'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_other() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_other as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-other'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_notfollow() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_notfollow as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-notfollow'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_authperm() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_authperm as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-authperm'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_soft404() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_soft404 as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-soft404'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_servererror() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_servererror as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-servererror'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
    function drawTable_desktop_notfound() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'URL');
        data.addColumn('number', 'Response Code');
        data.addColumn('date', 'Last detected');
        
        data.addRows([
        
          @forelse($web_notfound as $item)
          [ decodeURI("{{ $item['pageUrl'] }}") ,  {{ $item['responseCode'] }} , new Date("{{ $item['lastCrawled'] }}")  ],
          @empty
          [ "The new Google API and Google Analytics setup would take a few days to bring Google Analytics report here. Please check again later." ,  null , null ],
          @endforelse
        
        ]);
        
        var table = new google.visualization.Table(document.getElementById('desktop-notfound'));
        
        table.draw(data, {showRowNumber: true, 
                          width: '100%', 
                          height: '100%',
                          page: 'enable',
                          pageSize: '30'
                          });
  	}
  	
</script>
@endpush
