<?php
namespace ansec\sdk\sso;

use ansec\sdk\sso\help\Http;
use ansec\sdk\sso\help\TokenInfo;

class SystemAuthority {

    public function __construct($schema, $host, $port, $app_id, $app_key, $save_file_path = "/tmp/ansce_sso_system.info") {
        $this->_http = new Http([
                'schema' => $schema,
                'host' => $host,
                'port' => $port
                ]);
        $this->_app_id = $app_id;
        $this->_app_key = $app_key;

        $this->_save_file_path = $save_file_path . "~" . $app_id;

        $this->_loadTokenInfo();
    }

    /**
     * 请求token
     */
    public function requestToken() {
        $response = $this->_http->sendGetRequest('api/systoken', [
	            'aid' => $this->_app_id,
                'code' => md5($this->_app_id . $this->_app_key),
                'grant_type' => 'proxy',
                'state' => 1
        ]);

        if (isset($response['data'])) {
            $this->_token_info = new TokenInfo($response['data']);
            if ($this->_token_info && $this->_token_info->getState() == 1)
                $this->_saveTokenInfo();
        }
    }

    /**
     * 刷新Token
     */
    public function refreshToken() {
        $response = $this->handlerRequest('api/refresh', [
            'refreshtoken' => $this->_token_info->getRefresh_token()
        ]);
        if (isset($response['data'])) {
            $this->_token_info = new TokenInfo($response['data']);
            $this->_saveTokenInfo();
        }
    }

    /**
     * 获取系统信息
     *
     * @return Ambigous <>|NULL
     */
    public function getSystemInfo() {
        $response = $this->handlerRequest('api/checksystoken', []);
        if (isset($response['data']['appinfo'])) {
            return $response['data']['appinfo'];
        }
        return null;
    }

    /**
     * 获取指定token的系统信息
     *
     * @param unknown $token
     * @return NULL|array
     */
    public function getSystemInfoFromToken($token) {
        $response = $this->_http->sendGetRequest('api/checksystoken', [], [
                'systemtoken' => $token
                ]);
        if (isset($response['returncode']) && $response['returncode'] == 200) {
            return @$response['data']['appinfo'];
        }
        return null;
    }


    /**
     * token是否有效
     *
     * @return boolean
     */
    public function isTokenAvailability() {
        if ($this->_token_info) {
            if ($this->_token_info->getExpires() > time())
                return true;
        }
        return false;
    }

    /**
     * 统一处理需要token的请求
     *
     * @param unknown $route
     * @param unknown $params
     *
     * @return NULL|mixed
     */
    private function handlerRequest($route, $params) {
        if (!$this->isTokenAvailability()) {
            $this->requestToken();
        }
        if ($this->isTokenAvailability()) {
            $response = $this->_http->sendGetRequest($route, $params, [
	           'systemtoken' => $this->_token_info->getAccess_token()
            ]);
            if (isset($response['returncode']) && $response['returncode'] == 403) {
                //Token不正确
                return $this->handlerRequest($route, $params);
            }
            return $response;
        }
        return null;
    }

    private function _loadTokenInfo() {
        if (file_exists($this->_save_file_path)) {
            $string = file_get_contents($this->_save_file_path);
            if ($string) {
                try {
                    $this->_token_info = unserialize($string);
                } catch (\Exception $e) {

                }
            }
        }
    }

    private function _saveTokenInfo() {
        if ($this->_token_info) {
            file_put_contents($this->_save_file_path, serialize($this->_token_info));
        }
    }

    private $_http;
    private $_app_id;
    private $_app_key;
    private $_save_file_path;
    private $_token_info;
}