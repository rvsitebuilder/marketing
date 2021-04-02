<?php

// BACKEND CONTROLLER WITH MODEL,EVENT-LISTENER

namespace Rvsitebuilder\Marketing\Http\Controllers\Admin;

use App;
use Exception;
use Google_Service_Analytics;
use Google_Service_Webmasters;
use Google_Service_Webmasters_SearchAnalyticsQueryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Rvsitebuilder\Marketing\Models\Authorisation;

class MktController extends Controller
{
    protected $webURL;

    public function __construct()
    {
        $this->webURL = url('/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleAnalytic',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleAnalytic',
            ]);
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.index')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'google_access_token' => $googleSettingData['google_access_token'],
                'google_refresh_token' => $googleSettingData['google_refresh_token'],
                'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
                'google_user_email' => $googleSettingData['google_user_email'],
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.index', [
            'google_access_token' => $googleSettingData['google_access_token'],
            'google_refresh_token' => $googleSettingData['google_refresh_token'],
            'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
            'google_user_email' => $googleSettingData['google_user_email'],
        ]);
    }

    public function anaembed3rdcompare(Request $request)
    {
        $googleSettingData = $this->getGoogleSettingData();

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.anaembed3rdcompare')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'google_access_token' => $googleSettingData['google_access_token'],
                'google_refresh_token' => $googleSettingData['google_refresh_token'],
                'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
                'google_user_email' => $googleSettingData['google_user_email'],
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.anaembed3rdcompare', [
            'google_access_token' => $googleSettingData['google_access_token'],
            'google_refresh_token' => $googleSettingData['google_refresh_token'],
            'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
            'google_user_email' => $googleSettingData['google_user_email'],
        ]);
    }

    public function useranalytic(Request $request)
    {
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleAnalytic',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleAnalytic',
            ]);
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.useranalytic', [
                'google_access_token' => $googleSettingData['google_access_token'],
                'google_refresh_token' => $googleSettingData['google_refresh_token'],
                'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
                'google_user_email' => $googleSettingData['google_user_email'],
            ])->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'google_access_token' => $googleSettingData['google_access_token'],
                'google_refresh_token' => $googleSettingData['google_refresh_token'],
                'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
                'google_user_email' => $googleSettingData['google_user_email'],
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.useranalytic', [
            'google_access_token' => $googleSettingData['google_access_token'],
            'google_refresh_token' => $googleSettingData['google_refresh_token'],
            'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
            'google_user_email' => $googleSettingData['google_user_email'],
        ]);
    }

    public function webreferral(Request $request)
    {
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleAnalytic',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleAnalytic',
            ]);
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.webreferral')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'google_access_token' => $googleSettingData['google_access_token'],
                'google_refresh_token' => $googleSettingData['google_refresh_token'],
                'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
                'google_user_email' => $googleSettingData['google_user_email'],
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.webreferral', [
            'google_access_token' => $googleSettingData['google_access_token'],
            'google_refresh_token' => $googleSettingData['google_refresh_token'],
            'google_ana_web_id' => $googleSettingData['google_ana_web_id'],
            'google_user_email' => $googleSettingData['google_user_email'],
        ]);
    }

    public function seo(Request $request)
    {
        //check google setting
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleAnalytic',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleAnalytic',
            ]);
        }

        //check url error
        if (preg_match('/localhost/i', $this->webURL) || $this->webURL == '') {
            if ($this->webURL == '') {
                $domainblank = '1';
            }
            if ($request->ajax()) {
                $view = view('rvsitebuilder/marketing::admin.mkt.domainnameerror')->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'domainname' => $this->webURL,
                    'domainblank' => isset($domainblank) ? $domainblank : '0',
                ]);
            }

            return view('rvsitebuilder/marketing::admin.mkt.domainnameerror', [
                'domainname' => $this->webURL,
                'domainblank' => isset($domainblank) ? $domainblank : '0',
            ]);
        }

        $last7day = date('Y-m-d', strtotime('-7 days'));
        $yesterday = date('Y-m-d', strtotime('-1 days'));

        //query search analytic
        $client = $this->_getGoogleClient();
        $webmastersService = new Google_Service_Webmasters($client);
        $searchanalytics = $webmastersService->searchanalytics;

        //get query analytic from searchconsole
        $grequest = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $grequest->setStartDate($last7day);
        $grequest->setEndDate($yesterday);
        $grequest->setDimensions(['query']);
        $grequest->setSearchType('web');
        $qsearch = $searchanalytics->query($this->webURL, $grequest);
        $queryrows = $qsearch->getRows();

        //get page analytic from searchconsole
        $grequest2 = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $grequest2->setStartDate($last7day);
        $grequest2->setEndDate($yesterday);
        $grequest2->setDimensions(['page']);
        $grequest2->setSearchType('web');
        $qsearch2 = $searchanalytics->query($this->webURL, $grequest2);
        $pagerows = $qsearch2->getRows();

        //get top page visitor from google analytics
        $analytics = new Google_Service_Analytics($client);
        $optParams['dimensions'] = 'ga:landingScreenName';
        $optParams['sort'] = '-ga:pageviews';
        $pagevisitrows = $analytics->data_ga->get(
            'ga:' . $googleSettingData['google_ana_web_id'],
            $last7day,
            $yesterday,
            'ga:pageValue,ga:pageviews',
            $optParams
        );
        $visitrows = $pagevisitrows->getRows();

        //solution for error no data on blade file
        if (!\is_array($visitrows)) {
            $visitrows = [];
        }
        if (!\is_array($queryrows)) {
            $queryrows = [];
        }
        if (!\is_array($pagerows)) {
            $pagerows = [];
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.seo')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'queryrow' => $queryrows,
                'pagerow' => $pagerows,
                'visitrow' => $visitrows,
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.seo', [
            'queryrow' => $queryrows,
            'pagerow' => $pagerows,
            'visitrow' => $visitrows,
        ]);
    }

    public function crawlerror(Request $request)
    {
        //check google setting
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleSearchconsole',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleSearchconsole',
            ]);
        }
        //check url error
        if (preg_match('/localhost/i', $this->webURL) || $this->webURL == '') {
            if ($this->webURL == '') {
                $domainblank = '1';
            }
            if ($request->ajax()) {
                $view = view('rvsitebuilder/marketing::admin.mkt.domainnameerror')->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'domainname' => $this->webURL,
                    'domainblank' => isset($domainblank) ? $domainblank : '0',
                ]);
            }

            return view('rvsitebuilder/marketing::admin.mkt.domainnameerror', [
                'domainname' => $this->webURL,
                'domainblank' => isset($domainblank) ? $domainblank : '0',
            ]);
        }

        //query search analytic
        $client = $this->_getGoogleClient();
        $webmastersService = new Google_Service_Webmasters($client);
        $crawlerror = $webmastersService->urlcrawlerrorssamples;

        $siteUrl = $this->webURL;
        //crawlerror web
        $web_authperm = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'authPermissions', 'web');
        $web_notfollow = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'notFollowed', 'web');
        $web_notfound = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'notFound', 'web');
        $web_other = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'other', 'web');
        $web_servererror = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'serverError', 'web');
        $web_soft404 = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'soft404', 'web');

        //crawlerror smartphoneonly
        $mobile_authperm = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'authPermissions', 'smartphoneOnly');
        $mobile_flashcontent = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'flashContent', 'smartphoneOnly');
        $mobile_manytooneredir = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'manyToOneRedirect', 'smartphoneOnly');
        $mobile_notfollow = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'notFollowed', 'smartphoneOnly');
        $mobile_notfound = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'notFound', 'smartphoneOnly');
        $mobile_other = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'other', 'smartphoneOnly');
        $mobile_robot = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'roboted', 'smartphoneOnly');
        $mobile_servererror = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'serverError', 'smartphoneOnly');
        $mobile_soft404 = $crawlerror->listUrlcrawlerrorssamples($siteUrl, 'soft404', 'smartphoneOnly');

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.crawlerror')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'web_authperm' => $web_authperm,
                'web_notfollow' => $web_notfollow,
                'web_notfound' => $web_notfound,
                'web_other' => $web_other,
                'web_servererror' => $web_servererror,
                'web_soft404' => $web_soft404,
                'mobile_authperm' => $mobile_authperm,
                'mobile_flashcontent' => $mobile_flashcontent,
                'mobile_manytooneredir' => $mobile_manytooneredir,
                'mobile_notfollow' => $mobile_notfollow,
                'mobile_notfound' => $mobile_notfound,
                'mobile_other' => $mobile_other,
                'mobile_robot' => $mobile_robot,
                'mobile_servererror' => $mobile_servererror,
                'mobile_soft404' => $mobile_soft404,

                'web_authperm_count' => $web_authperm->count(),
                'web_notfollow_count' => $web_notfollow->count(),
                'web_notfound_count' => $web_notfound->count(),
                'web_other_count' => $web_other->count(),
                'web_servererror_count' => $web_servererror->count(),
                'web_soft404_count' => $web_soft404->count(),
                'mobile_authperm_count' => $mobile_authperm->count(),
                'mobile_flashcontent_count' => $mobile_flashcontent->count(),
                'mobile_manytooneredir_count' => $mobile_manytooneredir->count(),
                'mobile_notfollow_count' => $mobile_notfollow->count(),
                'mobile_notfound_count' => $mobile_notfound->count(),
                'mobile_other_count' => $mobile_other->count(),
                'mobile_robot_count' => $mobile_robot->count(),
                'mobile_servererror_count' => $mobile_servererror->count(),
                'mobile_soft404_count' => $mobile_soft404->count(),
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.crawlerror', [
            'web_authperm' => $web_authperm,
            'web_notfollow' => $web_notfollow,
            'web_notfound' => $web_notfound,
            'web_other' => $web_other,
            'web_servererror' => $web_servererror,
            'web_soft404' => $web_soft404,
            'mobile_authperm' => $mobile_authperm,
            'mobile_flashcontent' => $mobile_flashcontent,
            'mobile_manytooneredir' => $mobile_manytooneredir,
            'mobile_notfollow' => $mobile_notfollow,
            'mobile_notfound' => $mobile_notfound,
            'mobile_other' => $mobile_other,
            'mobile_robot' => $mobile_robot,
            'mobile_servererror' => $mobile_servererror,
            'mobile_soft404' => $mobile_soft404,

            'web_authperm_count' => $web_authperm->count(),
            'web_notfollow_count' => $web_notfollow->count(),
            'web_notfound_count' => $web_notfound->count(),
            'web_other_count' => $web_other->count(),
            'web_servererror_count' => $web_servererror->count(),
            'web_soft404_count' => $web_soft404->count(),
            'mobile_authperm_count' => $mobile_authperm->count(),
            'mobile_flashcontent_count' => $mobile_flashcontent->count(),
            'mobile_manytooneredir_count' => $mobile_manytooneredir->count(),
            'mobile_notfollow_count' => $mobile_notfollow->count(),
            'mobile_notfound_count' => $mobile_notfound->count(),
            'mobile_other_count' => $mobile_other->count(),
            'mobile_robot_count' => $mobile_robot->count(),
            'mobile_servererror_count' => $mobile_servererror->count(),
            'mobile_soft404_count' => $mobile_soft404->count(),
        ]);
    }

    public function ajaxtopkeyword(Request $request): JsonResponse
    {
        $params = $request->input();

        $datequery = $this->setdate($params);

        //query search analytic
        $client = $this->_getGoogleClient();
        $webmastersService = new Google_Service_Webmasters($client);
        $searchanalytics = $webmastersService->searchanalytics;

        //get query analytic from searchconsole
        $grequest = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $grequest->setStartDate($datequery['startdate']);
        $grequest->setEndDate($datequery['enddate']);
        $grequest->setDimensions(['query']);
        $grequest->setSearchType('web');
        $qsearch = $searchanalytics->query($this->webURL, $grequest);
        $queryrows = $qsearch->getRows();

        return response()->json([
            'status' => 'Completed',
            'row' => $queryrows,
        ]);
    }

    public function ajaxtoplanding(Request $request): JsonResponse
    {
        $params = $request->input();

        $datequery = $this->setdate($params);

        //query search analytic
        $client = $this->_getGoogleClient();
        $webmastersService = new Google_Service_Webmasters($client);
        $searchanalytics = $webmastersService->searchanalytics;

        //get page analytic from searchconsole
        $grequest = new Google_Service_Webmasters_SearchAnalyticsQueryRequest();
        $grequest->setStartDate($datequery['startdate']);
        $grequest->setEndDate($datequery['enddate']);
        $grequest->setDimensions(['page']);
        $grequest->setSearchType('web');
        $qsearch = $searchanalytics->query($this->webURL, $grequest);
        $queryrows = $qsearch->getRows();

        return response()->json([
            'status' => 'Completed',
            'row' => $queryrows,
        ]);
    }

    public function ajaxtoppageuservisit(Request $request): JsonResponse
    {
        $params = $request->input();

        $googleSettingData = $this->getGoogleSettingData();

        $client = $this->_getGoogleClient();
        $analytics = new Google_Service_Analytics($client);
        $optParams['dimensions'] = 'ga:landingScreenName';
        $optParams['sort'] = '-ga:pageviews';
        $pagevisitrows = $analytics->data_ga->get(
            'ga:' . $googleSettingData['google_ana_web_id'],
            $params['startdate'],
            $params['enddate'],
            'ga:pageValue,ga:pageviews',
            $optParams
        );
        $visitrows = $pagevisitrows->getRows();

        return response()->json([
            'status' => 'Completed',
            'row' => $visitrows,
        ]);
    }

    public function sitespeed(Request $request)
    {
        $googleSettingData = $this->getGoogleSettingData();
        if (!$googleSettingData['google_setting_completed']) {
            if ($request->ajax()) {
                $view = view($googleSettingData['viewpage'])->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'leftmenu' => $view['leftmenu'],
                    'location_href' => '#googleAnalytic',
                ]);
            }

            return view($googleSettingData['viewpage'], [
                'location_href' => '#googleAnalytic',
            ]);
        }

        $last7day = date('Y-m-d', strtotime('-7 days'));
        $yesterday = date('Y-m-d', strtotime('-1 days'));

        //get top page visitor from google analytics
        $client = $this->_getGoogleClient();
        $analytics = new Google_Service_Analytics($client);
        $optParams['dimensions'] = 'ga:landingScreenName';
        $optParams['sort'] = '-ga:avgPageLoadTime';
        $pagespeedrows = $analytics->data_ga->get(
            'ga:' . $googleSettingData['google_ana_web_id'],
            $last7day,
            $yesterday,
            'ga:avgPageLoadTime,ga:pageviews,ga:bounceRate,ga:exitRate',
            $optParams
        );
        $sitespeed = $pagespeedrows->getRows();

        //if no data set to empty array for fix blade file error
        if (!\is_array($sitespeed)) {
            $sitespeed = [];
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.sitespeed')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'sitespeed' => $sitespeed,
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.sitespeed', [
            'sitespeed' => $sitespeed,
        ]);
    }

    public function ajaxsitespeed(Request $request): JsonResponse
    {
        $params = $request->input();

        $googleSettingData = $this->getGoogleSettingData();

        $client = $this->_getGoogleClient();
        $analytics = new Google_Service_Analytics($client);
        $optParams['dimensions'] = 'ga:landingScreenName';
        $optParams['sort'] = '-ga:avgPageLoadTime';
        $pagespeedrows = $analytics->data_ga->get(
            'ga:' . $googleSettingData['google_ana_web_id'],
            $params['startdate'],
            $params['enddate'],
            'ga:avgPageLoadTime,ga:pageviews,ga:bounceRate,ga:exitRate',
            $optParams
        );
        $pagespeed = $pagespeedrows->getRows();

        return response()->json([
            'status' => 'Completed',
            'row' => $pagespeed,
        ]);
    }

    public function robots(Request $request)
    {
        //robot have no api so need not to check google setting but check tools on google search console
        //website url must be add and verify with google search console bedore use tools robot test
        //if add and verity on website url by email AA@gmail.com then can't login with BB@gmail.com for using this tools

        $robotcontent = '';
        $userPath = $this->_getUserPath();

        if (File::exists($userPath['public_html'] . '/robots.txt')) {
            $robotcontent = File::get($userPath['public_html'] . '/robots.txt');
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mkt.robots')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'leftmenu' => $view['leftmenu'],
                'robot_content' => $robotcontent,
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mkt.robots', [
            'robot_content' => $robotcontent,
        ]);
    }

    public function ajaxrobotsave(Request $request): JsonResponse
    {
        $params = $request->input();

        $userPath = $this->_getUserPath();
        $bytes_written = File::put($userPath['public_html'] . '/robots.txt', $params['robotcontent']);

        //$bytes_written will return among character on file
        if ($bytes_written) {
            return response()->json([
                'status' => 'Completed',
                'robot_content' => File::get($userPath['public_html'] . '/robots.txt'),
            ]);
        }

        return response()->json([
            'status' => 'Incomplete',
            'robot_content' => File::get($userPath['public_html'] . '/robots.txt'),
        ]);
    }

    protected function getGoogleSettingData(): array
    {
        $GoogleSettingData = [];
        $GoogleSettingData['google_ana_acc_id'] = 0;
        $GoogleSettingData['google_ana_track_id'] = 0;
        $GoogleSettingData['google_ana_web_id'] = 0;
        $GoogleSettingData['google_access_token'] = 0;
        $GoogleSettingData['google_refresh_token'] = 0;
        $GoogleSettingData['google_setting_completed'] = 0;
        $GoogleSettingData['google_user_email'] = 0;
        $GoogleSettingData['viewpage'] = 'rvsitebuilder/marketing::admin.mkt.neversettinggoogle';

        //get google analytic account id/google analytic track ID/user email form db
        //TODO mkt_GA_Acc_ID mkt_GA_Track_ID googleUserProp maybe not need to use
        $googleAnaAccID = config('rvsitebuilder.core.db.mkt_GA_Acc_ID');
        $googleTrackID = config('rvsitebuilder.core.db.mkt_GA_Track_ID');
        $googleWebproID = config('rvsitebuilder.core.db.mkt_GA_Profile_id');

        $googleUserProp = Authorisation::where('name', '=', 'default')->first();

        //if never authen before must be return first if not getgoogleclient will be error
        if (empty($googleUserProp->name) || empty($googleUserProp->access_token)) {
            return $GoogleSettingData;
        }

        //get google auth
        try {
            $client = $this->_getGoogleClient();
        } catch (Exception $e) {
            $client = null;
        }
        if ($client) {
            $tokendata = $client->getAccessToken();
            $access_token = $tokendata['access_token'];
            $refresh_token = $tokendata['refresh_token'];
        }

        //verify google is setting completed
        $gsettingcompleted = 0;
        if ($googleAnaAccID != '' && $googleTrackID != '' && $access_token != '' && $refresh_token != '' && $googleWebproID != '') {
            $gsettingcompleted = 1;
        }

        $GoogleSettingData['google_ana_acc_id'] = $googleAnaAccID;
        $GoogleSettingData['google_ana_track_id'] = $googleTrackID;
        $GoogleSettingData['google_ana_web_id'] = $googleWebproID;
        $GoogleSettingData['google_access_token'] = $access_token;
        $GoogleSettingData['google_refresh_token'] = $refresh_token;
        $GoogleSettingData['google_setting_completed'] = $gsettingcompleted;
        $GoogleSettingData['google_user_email'] = $googleUserProp->google_email;
        $GoogleSettingData['viewpage'] = 'rvsitebuilder/marketing::admin.mktsetting.googleapi';

        return $GoogleSettingData;
    }

    protected function _getGoogleClient()
    {
        //get access token from db
        try {
            //$client = \Academe\GoogleApi\Helper::getApiClient(\Academe\GoogleApi\Helper::getCurrentUserAuth('default'));
            //dd(\Lib\Vendor\GoogleAPI\Helper::getCurrentUserAuth('default'));
            $client = \Lib\Vendor\GoogleAPI\Helper::getApiClient(\Lib\Vendor\GoogleAPI\Helper::getCurrentUserAuth('default'));
        } catch (Exception $e) {
            // Invalid credentials, or any other error in the API request.
            $client = null;
        }
        //check if access token is expired
        if ($client->isAccessTokenExpired()) {
            //refresh access_token again
            $refreshTokenSaved = $client->getRefreshToken();
            // update access token
            $client->fetchAccessTokenWithRefreshToken($refreshTokenSaved);
            //update to db
            $dbtemp = $client->getAccessToken();
            $date = date_create();
            Authorisation::where('name', '=', 'default')->update([
'access_token' => $dbtemp['access_token'],
]);
            Authorisation::where('name', '=', 'default')->update([
'created_time' => date_timestamp_get($date),
]);
            Authorisation::where('name', '=', 'default')->update([
'expires_in' => $dbtemp['expires_in'],
]);
        }

        return $client;
    }

    protected function setdate($params): array
    {
        $datequery['startdate'] = date('Y-m-d', strtotime('-7 days'));
        $datequery['enddate'] = date('Y-m-d', strtotime('-1 days'));

        if ($params['startdate'] == 'today') {
            $datequery['startdate'] = date('Y-m-d');
            $datequery['enddate'] = date('Y-m-d');
        }
        if ($params['startdate'] == 'yesterday') {
            $datequery['startdate'] = date('Y-m-d', strtotime('-1 days'));
            $datequery['enddate'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (is_numeric($params['startdate'])) {
            $date = $params['startdate'];
            $datequery['startdate'] = date('Y-m-d', strtotime("-${date} days"));
            $datequery['enddate'] = date('Y-m-d', strtotime('-1 days'));
        }
        //debug echo $startdate.' '.$enddate;

        return $datequery;
    }

    protected function _getUserPath(): array
    {
        $user = posix_getpwuid(posix_getuid());
        $userPath['home'] = App::environmentPath();

        if ($user['name'] == 'root' || $user['name'] == 'test1') {
            $userPath['public_html'] = App::environmentPath() . '/html';
        } else {
            $userPath['public_html'] = App::environmentPath() . '/public_html';
        }

        return $userPath;
    }
}
