<?php
namespace ansec\sdk\sso\help;

use GuzzleHttp\Client;

class Http {

    public function __construct($server_info) {
        $this->schema = isset($server_info['schema']) && $server_info['schema']? $server_info['schema']:'http';
        $this->host = isset($server_info['host']) && $server_info['host']? $server_info['host']:'localhost';
        $this->port = isset($server_info['port']) && $server_info['port']? $server_info['port']:80;

        $this->client = new Client(['base_uri'=>$this->schema . "://" . $this->host . ":" . $this->port . "/"]);
    }

    public function sendGetRequest($route, $params=[], $header=[]) {
        $res = $this->client->request('POST', $route, [
	       'form_params' => $params,
           'headers' => $header,
           'debug' => true
        ]);

        $content_type = $res->getHeaderLine('content-type');
        if (strpos($content_type, 'application/json') !== false) {
            return json_decode($res->getBody(), true);
        }

        return $res->getBody();
    }


    private $schema;
    private $host;
    private $port;

    private $client;
}