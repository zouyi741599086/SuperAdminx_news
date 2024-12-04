<?php
namespace Webman\saiadmin;

class Install
{
    const WEBMAN_PLUGIN = true;

    /**
     * @var array
     */
    protected static $pathRelation = [
        //'plugin/saiadmin' => 'plugin/saiadmin'
    ];

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        //static::installByRelation();
        //static::addMethod();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        //self::uninstallByRelation();
    }

}
