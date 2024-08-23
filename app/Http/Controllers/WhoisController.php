<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WhoisController extends Controller
{
    public function lookup(Request $request)
    {
        $domain = $request->input('domain');
        
        $apiKey = env('WHOIS_API_KEY');
        $client = new Client();
        
        $response = $client->get("http://www.whoisxmlapi.com/whoisserver/WhoisService", [
            'query' => [
                'apiKey' => $apiKey,
                'domainName' => $domain,
                'outputFormat' => 'json',
            ],
            'timeout' => 30,
        ]);



        $data = json_decode($response->getBody()->getContents(), true);

        
            $result = [
                'domain_name' => $data['WhoisRecord']['domainName'] ?? null,
                'registrar' => $data['WhoisRecord']['registrarName'] ?? null,
                'registration_date' => $data['WhoisRecord']['createdDate'] ?? null,
                'expiration_date' => $data['WhoisRecord']['expiresDate'] ?? null,
                'estimated_domain_age' => $data['WhoisRecord']['estimatedDomainAge'] ?? null,
                'hostnames' => $data['WhoisRecord']['nameServers']['hostNames'] ?? [],
                'contact_information' => [
                    'registrant_name' => $data['WhoisRecord']['registrant']['name'] ?? null,
                    'technical_contact_name' => $data['WhoisRecord']['technicalContact']['name'] ?? null,
                    'administrative_contact_name' => $data['WhoisRecord']['administrativeContact']['name'] ?? null,
                    'contact_email' => $data['WhoisRecord']['contactEmail'] ?? null,
                ]
            ];
      
        

        return response()->json($result);
    }




    public function lookup2(Request $request)
    {
        $domain = $request->input('domain');
        $showInfo = $request->input('showinfo');
        $apiKey = env('WHOIS_API_KEY');
        $client = new Client();
        
        $response = $client->get("http://www.whoisxmlapi.com/whoisserver/WhoisService", [
            'query' => [
                'apiKey' => $apiKey,
                'domainName' => $domain,
                'outputFormat' => 'json',
            ],
            'timeout' => 30,
        ]);



        $data = json_decode($response->getBody()->getContents(), true);

        if( $showInfo == 1 ){
            $result = [
                'domain_information' => [
                'domain_name' => $data['WhoisRecord']['domainName'] ?? null,
                'registrar' => $data['WhoisRecord']['registrarName'] ?? null,
                'registration_date' => $data['WhoisRecord']['createdDate'] ?? null,
                'expiration_date' => $data['WhoisRecord']['expiresDate'] ?? null,
                'estimated_domain_age' => $data['WhoisRecord']['estimatedDomainAge'] ?? null,
                'hostnames' => $data['WhoisRecord']['nameServers']['hostNames'] ?? [],
                ]
            ];
        }elseif( $showInfo == 2 ){
            $result = [
                'contact_information' => [
                    'registrant_name' => $data['WhoisRecord']['registrant']['name'] ?? null,
                    'technical_contact_name' => $data['WhoisRecord']['technicalContact']['name'] ?? null,
                    'administrative_contact_name' => $data['WhoisRecord']['administrativeContact']['name'] ?? null,
                    'contact_email' => $data['WhoisRecord']['contactEmail'] ?? null,
                ]
            ];
        }else{
            $result = [
                'domain_name' => $data['WhoisRecord']['domainName'] ?? null,
                'registrar' => $data['WhoisRecord']['registrarName'] ?? null,
                'registration_date' => $data['WhoisRecord']['createdDate'] ?? null,
                'expiration_date' => $data['WhoisRecord']['expiresDate'] ?? null,
                'estimated_domain_age' => $data['WhoisRecord']['estimatedDomainAge'] ?? null,
                'hostnames' => $data['WhoisRecord']['nameServers']['hostNames'] ?? [],
                'contact_information' => [
                    'registrant_name' => $data['WhoisRecord']['registrant']['name'] ?? null,
                    'technical_contact_name' => $data['WhoisRecord']['technicalContact']['name'] ?? null,
                    'administrative_contact_name' => $data['WhoisRecord']['administrativeContact']['name'] ?? null,
                    'contact_email' => $data['WhoisRecord']['contactEmail'] ?? null,
                ]
            ];
        }
        

        return response()->json($result);
    }
}
