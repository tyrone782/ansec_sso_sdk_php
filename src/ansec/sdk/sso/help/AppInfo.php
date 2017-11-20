<?php
namespace ansec\sdk\sso\help;

class AppInfo {
    private $id;
    private $appid;
    private $url;
    private $logo;
    private $appname;
    private $state;
    private $appdeveloper;
    private $appdesc;
    private $apptype;
    private $admin_index_url;
    private $app_index_url;
    private $pc_index_url;
    private $comefrom;
    private $code;
    private $version;
    private $sortid;
    private $createstaffid;
    private $functiontype;
    private $principal_name;
    private $principal_telephone;
    private $principal_phone;
    private $principal_backup_telephone;
    private $principal_email;
    private $create_time;
    private $update_time;

    public function __construct($token_info) {
        if ($token_info) {
            $reflect = new \ReflectionClass($this);
            $props = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);
            $transformParams = $this->transformParams();
            foreach ($props as $prop) {
                $prop_name = $prop->getName();
                if (isset($token_info[$prop_name])) {
                    if (isset($transformParams[$prop_name])) {
                        $array = $transformParams[$prop_name];
                        if ($array['type'] === 'class') {//类映射
                            $class = $array['value'];
                            if (class_exists($class)) {
                                $this->$prop_name = new $class($token_info[$prop_name]);
                            } else {
                                throw new \Exception("class {$class} not defined");
                            }
                        } else if ($array['type'] === 'property') {//属性映射
                            if (isset($token_info[$array['value']])) {
                                $this->$prop_name = $token_info[$array['value']];
                            } else {
                                throw new \Exception("property {$array['value']} not found");
                            }
                        }
                        continue;
                    }
                    $this->$prop_name = $token_info[$prop_name];
                }
            }
        }
    }

    protected function transformParams() {
        return [];
    }

	/**
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

	/**
     * @return the $appid
     */
    public function getAppid ()
    {
        return $this->appid;
    }

	/**
     * @return the $url
     */
    public function getUrl ()
    {
        return $this->url;
    }

	/**
     * @return the $logo
     */
    public function getLogo ()
    {
        return $this->logo;
    }

	/**
     * @return the $appname
     */
    public function getAppname ()
    {
        return $this->appname;
    }

	/**
     * @return the $state
     */
    public function getState ()
    {
        return $this->state;
    }

	/**
     * @return the $appdeveloper
     */
    public function getAppdeveloper ()
    {
        return $this->appdeveloper;
    }

	/**
     * @return the $appdesc
     */
    public function getAppdesc ()
    {
        return $this->appdesc;
    }

	/**
     * @return the $apptype
     */
    public function getApptype ()
    {
        return $this->apptype;
    }

	/**
     * @return the $admin_index_url
     */
    public function getAdminIndexUrl ()
    {
        return $this->admin_index_url;
    }

	/**
     * @return the $app_index_url
     */
    public function getAppIndexUrl ()
    {
        return $this->app_index_url;
    }

	/**
     * @return the $pc_index_url
     */
    public function getPcIndexUrl ()
    {
        return $this->pc_index_url;
    }

	/**
     * @return the $comefrom
     */
    public function getComefrom ()
    {
        return $this->comefrom;
    }

	/**
     * @return the $code
     */
    public function getCode ()
    {
        return $this->code;
    }

	/**
     * @return the $version
     */
    public function getVersion ()
    {
        return $this->version;
    }

	/**
     * @return the $sortid
     */
    public function getSortid ()
    {
        return $this->sortid;
    }

	/**
     * @return the $createstaffid
     */
    public function getCreatestaffid ()
    {
        return $this->createstaffid;
    }

	/**
     * @return the $functiontype
     */
    public function getFunctiontype ()
    {
        return $this->functiontype;
    }

	/**
     * @return the $principal_name
     */
    public function getPrincipalName ()
    {
        return $this->principal_name;
    }

	/**
     * @return the $principal_telephone
     */
    public function getPrincipalTelephone ()
    {
        return $this->principal_telephone;
    }

	/**
     * @return the $principal_phone
     */
    public function getPrincipalPhone ()
    {
        return $this->principal_phone;
    }

	/**
     * @return the $principal_backup_telephone
     */
    public function getPrincipalBackupTelephone ()
    {
        return $this->principal_backup_telephone;
    }

	/**
     * @return the $principal_email
     */
    public function getPrincipalEmail ()
    {
        return $this->principal_email;
    }

	/**
     * @return the $create_time
     */
    public function getCreateTime ()
    {
        return $this->create_time;
    }

	/**
     * @return the $update_time
     */
    public function getUpdateTime ()
    {
        return $this->update_time;
    }




}