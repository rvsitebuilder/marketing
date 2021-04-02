<?php

// BACKEND CONTROLLER WITH MODEL,EVENT-LISTENER

namespace Rvsitebuilder\Marketing\Http\Controllers\Admin;

use App;
use Exception;
use Google_Service_Analytics;
use Google_Service_Exception;
use Google_Service_SiteVerification;
use Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequest;
use Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequestSite;
use Google_Service_SiteVerification_SiteVerificationWebResourceResource;
use Google_Service_SiteVerification_SiteVerificationWebResourceResourceSite;
use Google_Service_Webmasters;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Lib\Util\ENVHelper;
use Rvsitebuilder\Core\Models\CoreConfig;
use Rvsitebuilder\Marketing\Models\Authorisation;

class MktSettingController extends Controller
{
    public function googleapi(Request $request)
    {
        //check google client authen and setup google service
        //check client_id and client_service is set complete
        //if config can't get client_id or client_secret route to google auth setup

        if (!$this->_chkGoogleConfig() && !$this->_chkAuthened()) {
            if ($request->ajax()) {
                $view = view('rvsitebuilder/marketing::admin.mktsetting.googleapisetup')->renderSections();

                return response()->json([
                    'content' => $view['content'],
                    'clientid' => config('googleapi.client_id'),
                    'clientsecret' => config('googleapi.client_secret'),
                ]);
            }

            return view('rvsitebuilder/marketing::admin.mktsetting.googleapisetup', [
                'clientid' => config('googleapi.client_id'),
                'clientsecret' => config('googleapi.client_secret'),
            ]);
        }

        //if authened and have config
        $authen = 'Incomplete';
        $clientid = '';
        $clientsecret = '';
        $buttontxt = 'Setup';
        $useremail = '';

        if ($this->_chkGoogleConfig() && $this->_chkAuthened()) {
            $authen = 'Completed';
            $clientid = config('googleapi.client_id');
            $clientsecret = config('googleapi.client_secret');
            $buttontxt = 'Edit';
            $gachk = Authorisation::where('name', '=', 'default')->first();
            $useremail = $gachk->google_email;
        }

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mktsetting.googleapi')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'googlesettingdata' => $authen,
                'clientid' => $clientid,
                'clientsecret' => $clientsecret,
                'buttontxt' => $buttontxt,
                'useremail' => $useremail,
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mktsetting.googleapi', [
            'googlesettingdata' => $authen,
            'clientid' => $clientid,
            'clientsecret' => $clientsecret,
            'buttontxt' => $buttontxt,
            'useremail' => $useremail,
        ]);
    }

    public function googleapisetup(Request $request)
    {
        $jsorigin = url('/');
        $mktcallbaackurl = url('/') . '/admin/marketing/mktsetting/gapi/oauth2callback';
        $logincallbackurl = config('services.google.redirect');

        if ($request->ajax()) {
            $view = view('rvsitebuilder/marketing::admin.mktsetting.googleapisetup')->renderSections();

            return response()->json([
                'content' => $view['content'],
                'clientid' => config('googleapi.client_id'),
                'clientsecret' => config('googleapi.client_secret'),
                'jsorigin' => $jsorigin,
                'mktcallbackurl' => $mktcallbaackurl,
                'logincallbackurl' => $logincallbackurl,
            ]);
        }

        return view('rvsitebuilder/marketing::admin.mktsetting.googleapisetup', [
            'clientid' => config('googleapi.client_id'),
            'clientsecret' => config('googleapi.client_secret'),
            'jsorigin' => $jsorigin,
            'mktcallbackurl' => $mktcallbaackurl,
            'logincallbackurl' => $logincallbackurl,
        ]);
    }

    public function clientsetup(Request $request): JsonResponse
    {
        $params = $request->input();

        //params is array only
        $env_update = ENVHelper::setEnv($params);

        //setup key google social login
        if (isset($params['GA_API_CLIENT_ID'])) {
            ENVHelper::setEnv([
                'GOOGLE_CLIENT_ID' => $params['GA_API_CLIENT_ID'],
            ]);
        }
        if (isset($params['GA_API_CLIENT_SECRET'])) {
            ENVHelper::setEnv([
                'GOOGLE_CLIENT_SECRET' => $params['GA_API_CLIENT_SECRET'],
            ]);
        }

        if ($env_update) {
            return response()->json([
                'status' => 'update Success',
            ]);
        }

        return response()->json([
            'status' => 'update Failed',
        ]);
    }

    public function googleAnalyticAccountSetup(): JsonResponse
    {
        //chk google analytic account config
        $gaaccid = config('rvsitebuilder.core.db.mkt_GA_Acc_ID');
        $gatrackid = config('rvsitebuilder.core.db.mkt_GA_Track_ID');
        $gaproid = config('rvsitebuilder.core.db.mkt_GA_Profile_id');
        if ($gaaccid == '' || $gatrackid == '' || $gaproid == '') {
            return response()->json([
                'status' => 'Incomplete',
                'message' => 'You not setup Google Analytics Tracker ID (config in db mkt_GA_Track_ID,mkt_GA_Acc_ID,mkt_GA_Profile_id)',
            ]);
        }

        //get google oauth
        try {
            $client = $this->_getGoogleClient();
            $service = new Google_Service_Analytics($client);
            $accounts = $service->management_accountSummaries->listManagementAccountSummaries();
        } catch (Exception $e) {
            // Invalid credentials, or any other error in the API request.
            $client = null;
        }

        if ($client) {
            if (empty($accounts->getItems())) {
                return response()->json([
                    'status' => 'Incomplete',
                    'message' => "You don't have Google Analytics account. Please register at https://www.google.com/analytics/. ",
                ]);
            }
            foreach ($accounts->getItems() as $item) {
                if ($item['id'] == $gaaccid) {
                    //get webproperty by account ID
                    $webproperties = $service->management_webproperties->listManagementWebproperties($gaaccid);
                    if (empty($webproperties->getItems())) {
                        return response()->json([
                            'status' => 'Incomplete',
                            'message' => 'Your website is not registered in Google Analytics yet. Please register at https://www.google.com/analytics/.',
                            'คุณไม่มี web property ใดๆ ที่เคยสร้างไว้เลย (Google Analytic Account ID ' . $gaaccid . ')',
                        ]);
                    }
                    foreach ($webproperties->getItems() as $webitem) {
                        if ($webitem['websiteUrl'] == url('/')) {
                            //saveconfig
                            CoreConfig::updateOrCreate(
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Acc_ID',
                                ],
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Acc_ID',
                                    'value' => $gaaccid,
                                ]
                            );
                            CoreConfig::updateOrCreate(
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Track_ID',
                                ],
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Track_ID',
                                    'value' => $webitem['id'],
                                ]
                            );
                            CoreConfig::updateOrCreate(
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Profile_id',
                                ],
                                [
                                    'key' => 'rvsitebuilder.core.mkt_GA_Profile_id',
                                    'value' => $webitem['defaultProfileId'],
                                ]
                            );

                            return response()->json([
                                'status' => 'Complete',
                                'message' => 'Google Analytic Account ID ' . $item['id'] . ' , Google Analytic Track ID ' . $webitem['id'] . ' , Google Analytic Profile ID ' . $webitem['defaultProfileId'],
                                'gaid' => $gaaccid,
                                'tracid' => $webitem['id'],
                                'weburl' => $webitem['websiteUrl'],
                            ]);
                        }
                    }

                    return response()->json([
                        'status' => 'Incomplete',
                        'message' => 'None of Website URLs in your Google Analytics account is matched with your website created RVsitebuilder CMS (' . url('/') . ') (Google Analytic Account ID ' . $gaaccid->value,
                        'gaid' => $gaaccid,
                    ]);
                }
            }

            return response()->json([
                'status' => 'Incomplete',
                'message' => 'None of your Google Analytics accounts recorded in Database (' . $gaaccid . ') is matched with Google Analytics Account of this Email Address.',
            ]);
        }

        return response()->json([
            'status' => 'Incomplete',
            'message' => "You're allowing an Email Address which is not found in Google Analytics accounts. Please check Email Address or Google API connection again.",
        ]);
    }

    public function googleAnalyticIDSetup(Request $request): JsonResponse
    {
        $params = $request->input();

        //get google oauth
        try {
            $client = $this->_getGoogleClient();
            $service = new Google_Service_Analytics($client);
            $accounts = $service->management_accountSummaries->listManagementAccountSummaries();
        } catch (Exception $e) {
            // Invalid credentials, or any other error in the API request.
            $client = null;
        }

        if ($client) {
            if (empty($accounts->getItems())) {
                return response()->json([
                    'status' => 'Incomplete',
                    'message' => "You don't have Google Analytics account. Please register at https://www.google.com/analytics/.",
                ]);
            }
            foreach ($accounts->getItems() as $item) {
                //get webproperty by account ID
                $webproperties = $service->management_webproperties->listManagementWebproperties($item['id']);
                if (empty($webproperties->getItems())) {
                    return response()->json([
                        'status' => 'Incomplete',
                        'message' => 'คุณไม่มี web property ใดๆ ที่เคยสร้างไว้เลย (Google Analytic Account ID ' . $item['id'] . ')',
                    ]);
                }
                foreach ($webproperties->getItems() as $webitem) {
                    //must be check account item website url (websiteUrl)  if user set id another site not from rvsitebuilder it be reject
                    if ($webitem['websiteUrl'] == url('/') && $params['GAID'] == $webitem['id']) {
                        //saveconfig
                        CoreConfig::updateOrCreate(
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Acc_ID',
                            ],
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Acc_ID',
                                'value' => $item['id'],
                            ]
                        );
                        CoreConfig::updateOrCreate(
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Track_ID',
                            ],
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Track_ID',
                                'value' => $params['GAID'],
                            ]
                        );
                        CoreConfig::updateOrCreate(
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Profile_id',
                            ],
                            [
                                'key' => 'rvsitebuilder.core.mkt_GA_Profile_id',
                                'value' => $webitem['defaultProfileId'],
                            ]
                        );

                        return response()->json([
                            'status' => 'Complete',
                            'message' => 'Google Analytic Account ID ' . $item['id'] . ' , Google Analytic Track ID ' . $webitem['id'] . ' , Google Analytic Profile ID ' . $webitem['defaultProfileId'],
                            'gaid' => $item['id'],
                            'tracid' => $webitem['id'],
                            'weburl' => $webitem['websiteUrl'],
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 'Incomplete',
                'message' => 'This Website URL from Google Analytics Track ID (' . $params['GAID'] . ')is not macthed with Website URL created by RVsitebuilder CMS. (' . url('/') . ')',
            ]);
        }

        return response()->json([
            'status' => 'Incomplete',
            'message' => "You're allowing an Email Address which is not found in Google Analytics accounts. Please check Email Address or Google API connection again.",
        ]);
    }

    public function googleAnalyticAddGoogleAnaJS(): JsonResponse
    {
        $gatrackid = config('rvsitebuilder.core.db.mkt_GA_Track_ID');
        $gaaccid = config('rvsitebuilder.core.db.mkt_GA_Acc_ID');
        $gaproid = config('rvsitebuilder.core.db.mkt_GA_Profile_id');
        if ($gatrackid == '' || $gaaccid == '' || $gaproid == '') {
            return response()->json([
                'status' => 'Incomplete',
                'message' => 'Google Analytics is not set.',
            ]);
        }

        return response()->json([
            'status' => 'Complete',
            'message' => 'Google Analytics is completely connected. (GoogleAnalaticAccID=' . $gaaccid . ',GoogleAnalyticTrackID=' . $gatrackid . ',GoogleAnalyticProfileID=' . $gaproid . ')',
        ]);
    }

    public function addSiteUrlSearchConsole(): JsonResponse
    {
        //get google oauth
        $siteadd = 'Incomplete';
        $siteverify = 'Incomplete';
        try {
            $client = $this->_getGoogleClient();
            $service = new Google_Service_Webmasters($client);
            //getSiteEntry is mean get all site no metter it's verify or not
            foreach ($service->sites->listSites()->getSiteEntry() as $item) {
                //if added
                if ($item['siteUrl'] == url('/') . '/') {
                    $siteadd = 'Complete';

                    //if verify
                    if ($item['permissionLevel'] != 'siteUnverifiedUser') {
                        $siteverify = 'Complete';

                        return response()->json([
                            'siteadd' => $siteadd,
                            'siteverify' => $siteverify,
                            'sitename' => url('/'),
                        ]);
                    }
                }
            }

            return response()->json([
                'siteadd' => $this->_googleSearchConsoleSiteAdd(url('/')),
                'siteverify' => $this->_googleSearchConsoleSiteVerify(url('/')),
                'sitename' => url('/'),
            ]);
        } catch (Exception $e) {
            // Invalid credentials, or any other error in the API request.
            $client = null;
        }

        return response()->json([
            'siteadd' => $siteadd,
            'siteverify' => $siteverify,
            'sitename' => url('/'),
        ]);
    }

    public function userinfomation(Request $request): void
    {
        //debug check user information
        $line = '_______________________________________________________________________________________________________________';
        try {
            //$client = \Academe\GoogleApi\Helper::getApiClient(\Academe\GoogleApi\Helper::getCurrentUserAuth('default'));
            $client = \Lib\Vendor\GoogleAPI\Helper::getApiClient(\Lib\Vendor\GoogleAPI\Helper::getCurrentUserAuth('default'));
            echo 'Object Dump<br>';
            echo '<pre>';
            print_r($client);
            echo '</pre>' . $line . '<br>';
            $service = new Google_Service_Analytics($client);
            $accounts = $service->management_accountSummaries->listManagementAccountSummaries();
        } catch (Exception $e) {
            // Invalid credentials, or any other error in the API request.
            $client = null;
        }

        if ($client) {
            echo 'This all google Analytic account<br>';
            if (empty($accounts->getItems())) {
                echo '$accounts->getItems() array empty,this account not have google analytics account<br>';
            }
            echo '<pre>';
            print_r($accounts->getItems());
            echo '</pre>';
            foreach ($accounts->getItems() as $item) {
                // You wouldn't really echo anything in Laravel...
                echo 'Account: ' . $item['name'] . ' (' . $item['id'] . ') ' . '<br />';
            }

            //get google analytic account id
            $gaaccid = config('rvsitebuilder.core.db.mkt_GA_Acc_ID');

            if ($gaaccid != '') {
                echo 'Account web properties<br>';
                $webproperties = $service->management_webproperties->listManagementWebproperties($gaaccid->value);
                foreach ($webproperties->getItems() as $item) {
                    // You wouldn't really echo anything in Laravel...
                    echo 'Account: ' . $item['accountId'] . ' id ' . $item['id'] . ' websiteurl ' . $item['websiteUrl'] . '<br />';
                }

                echo $line . '<br>';
            }
        }
        echo 'account current Access Token<br>';
        echo '<pre>';
        print_r($client->getAccessToken());
        echo '</pre>' . $line . '<br>';
        echo 'account current refresh Token<br>';
        echo '<pre>';
        print_r($client->getRefreshToken());
        echo '</pre>' . $line . '<br>';
        echo 'token is expired<br>';
        echo '<pre>';
        echo $client->isAccessTokenExpired();
        echo '</pre>' . $line . '<br>';

        //refresh access_token in case access_token expire /reset access_token by using refresh_token
        //$client2 = \Academe\GoogleApi\Helper::getApiClient(\Academe\GoogleApi\Helper::getCurrentUserAuth('default'));
        $client2 = \Lib\Vendor\GoogleAPI\Helper::getApiClient(\Lib\Vendor\GoogleAPI\Helper::getCurrentUserAuth('default'));
        echo 'ถ้า expired = 1  \Academe\GoogleApi\Helper::getApiClient จะทำการ ขอ access_token ใหม่ โดยใช้ refresh_token และ save ลง db ให้ด้วยนะ<br>';
        echo '<pre>';
        print_r($client2->getAccessToken());
        echo '</pre>' . $line . '<br>';
    }

    public function getGoogleClientValue(Request $request): JsonResponse
    {
        $authen = '0';
        if ($this->_chkAuthened()) {
            $authen = '1';
        }

        return response()->json([
            'clientid' => config('googleapi.client_id'),
            'clientsecret' => config('googleapi.client_secret'),
            'authened' => $authen,
        ]);
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

    protected function _chkAuthened(): bool
    {
        //check data db is exist
        $gachk = Authorisation::where('name', '=', 'default')->first();
        if (!$gachk) {
            return false;
        }

        //check authen
        try {
            //$client = \Academe\GoogleApi\Helper::getApiClient(\Academe\GoogleApi\Helper::getCurrentUserAuth('default'));
            $client = \Lib\Vendor\GoogleAPI\Helper::getApiClient(\Lib\Vendor\GoogleAPI\Helper::getCurrentUserAuth('default'));
        } catch (Exception $e) {
            $client = null;
        }
        if ($client) {
            return true;
        }

        return false;
    }

    protected function _chkGoogleConfig(): bool
    {
        $clientid = config('googleapi.client_id');
        $clientsecret = config('googleapi.client_secret');
        if ($clientid == '' || $clientsecret == '') {
            return false;
        }

        return true;
    }

    protected function _googleSearchConsoleSiteAdd($siteUrl)
    {
        try {
            $client = $this->_getGoogleClient();
            $service = new Google_Service_Webmasters($client);
            //ref https://developers.google.com/webmaster-tools/search-console-api-original/v3/sites/add  will not return if add success so we not know if add is success
            if ($service->sites->add($siteUrl)) {
                return 'Complete';
            }
        } catch (Google_Service_Exception $exception) {
            $verify = [
                'error' => $exception->getErrors()[0]['message'],
            ];

            return 'Incomplete ' . $errors;
        }
    }

    protected function _googleSearchConsoleSiteVerify($siteUrl): string
    {
        //1 get file token
        $token = $this->getTokenFile($siteUrl);

        //2 touch token file
        if ($token->method == 'FILE' && $token->token != '') {
            $envPath = $this->_getUserPath();
            $file = $envPath['public_html'] . '/' . $token->token;
            $content = 'google-site-verification: ' . $token->token;
            File::put($file, $content);
        }

        //3 send site verify API to google
        $verify = $this->verifySite($siteUrl);

        return 'Complete';
    }

    protected function verifySite($siteUrl): string
    {
        $client = $this->_getGoogleClient();

        $site = new Google_Service_SiteVerification_SiteVerificationWebResourceResourceSite();
        $site->setIdentifier($siteUrl);
        $site->setType('SITE');

        $request = new Google_Service_SiteVerification_SiteVerificationWebResourceResource();
        $request->setSite($site);

        //Verify sent
        $service = new Google_Service_SiteVerification($client);

        $webResource = $service->webResource;

        try {
            $verify = $webResource->insert('FILE', $request);
        } catch (Google_Service_Exception $exception) {
            $verify = [
                'error' => $exception->getErrors()[0]['message'],
            ];
        }

        if ($verify->id && strpos(urldecode($verify->id), $siteUrl) !== false) {
            return 'Complete';
        }

        return 'Incomplete';
    }

    protected function getTokenFile($siteUrl)
    {
        $client = $this->_getGoogleClient();

        $site = new Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequestSite();
        $site->setIdentifier($siteUrl);
        $site->setType('SITE');

        $request = new Google_Service_SiteVerification_SiteVerificationWebResourceGettokenRequest();
        $request->setSite($site);
        $request->setVerificationMethod('FILE');

        //get token
        $service = new Google_Service_SiteVerification($client);
        $webResource = $service->webResource;
        return $webResource->getToken($request);
    }

    protected function _getGoogleClient()
    {
        //get access token from db
        try {
            //$client = \Academe\GoogleApi\Helper::getApiClient(\Academe\GoogleApi\Helper::getCurrentUserAuth('default'));
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
}
