<?php
namespace ansec\sdk\sso\help;

class TokenInfo {

    private $access_token;
    private $refresh_token;
    private $token_type;
    private $expires;
    private $expires_in;
    private $state;
    private $appid;
    private $appinfo;

    public function __construct($token_info) {
        if ($token_info) {
            $reflect = new \ReflectionClass($this);
            $props = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);
            foreach ($props as $prop) {
                $prop_name = $prop->getName();
                if (isset($token_info[$prop_name]))
                    $this->$prop_name = $token_info[$prop_name];
            }
        }
    }

	/**
     * @return the $access_token
     */
    public function getAccess_token ()
    {
        return $this->access_token;
    }

	/**
     * @return the $refresh_token
     */
    public function getRefresh_token ()
    {
        return $this->refresh_token;
    }

	/**
     * @return the $token_type
     */
    public function getToken_type ()
    {
        return $this->token_type;
    }

	/**
     * @return the $expires
     */
    public function getExpires ()
    {
        return $this->expires;
    }

	/**
     * @return the $expires_in
     */
    public function getExpires_in ()
    {
        return $this->expires_in;
    }

	/**
     * @return the $state
     */
    public function getState ()
    {
        return $this->state;
    }
	/**
     * @return the $appid
     */
    public function getAppid ()
    {
        return $this->appid;
    }

	/**
     * @return the $appinfo
     */
    public function getAppinfo ()
    {
        return $this->appinfo;
    }

}