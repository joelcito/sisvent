<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;

class AuthControllerOneDrive extends Controller
{
    public function redirectToProvider()
    {
        $oauthClient = new GenericProvider([
            'clientId'                => env('MS_GRAPH_CLIENT_ID'),
            'clientSecret'            => env('MS_GRAPH_CLIENT_SECRET'),
            'redirectUri'             => env('MS_GRAPH_REDIRECT_URI'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . env('MS_GRAPH_TENANT_ID') . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . env('MS_GRAPH_TENANT_ID') . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'                  => 'Files.ReadWrite offline_access'
        ]);

        $authorizationUrl = $oauthClient->getAuthorizationUrl();
        session(['oauth2state' => $oauthClient->getState()]);

        // dd($authorizationUrl, session('oauth2state'));

        return redirect()->away($authorizationUrl);
    }

    public function handleProviderCallback(Request $request)
    {
        $oauthClient = new GenericProvider([
            'clientId'                => env('MS_GRAPH_CLIENT_ID'),
            'clientSecret'            => env('MS_GRAPH_CLIENT_SECRET'),
            'redirectUri'             => env('MS_GRAPH_REDIRECT_URI'),
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . env('MS_GRAPH_TENANT_ID') . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . env('MS_GRAPH_TENANT_ID') . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'                  => 'Files.ReadWrite offline_access'
        ]);

        // dd(
        //     $request->input('state'),
        //     $request->input('state'),
        //     session('oauth2state')
        // );

        if (empty($request->input('state')) || ($request->input('state') !== session('oauth2state'))) {
            session()->forget('oauth2state');
            return redirect('/')->with('error', 'Invalid OAuth state');
        }

        try {
            $accessToken = $oauthClient->getAccessToken('authorization_code', [
                'code' => $request->input('code')
            ]);

            session(['accessToken' => $accessToken->getToken()]);

            return redirect('/onedrive/upload');
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            return redirect('/')->with('error', 'Failed to get access token: ' . $e->getMessage());
        }
    }
}
