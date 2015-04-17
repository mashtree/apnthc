<?php

/**
 * Autoloader is a class loader without caching.
 *
 * @example
 *
 *     include_once('coughphp/extras/Autoloader.class.php');
 *     Autoloader::addClassPath('app_path/classes/');
 *     Autoloader::addClassPath('shared_path/classes/');
 *     Autoloader::register();
 *
 * @tutorial
 *
 *  NAMESPACE  CLASS              PATH
 *  ---------  -----------------  ---------------------------------
 *             AuthController     app/controllers/AuthController.php
 *  Auth       RegisterController app/controllers/Auth/RegisterController.php
 *  Lighter    Console            libs/Lighter/Console.php
 *
 * @package default
 * @author Anthony Bush, Wayne Wight
 * @copyright 2006-2008 Academic Superstore. This software is open source protected by the FreeBSD License.
 * @version 2008-09-22
 *
 */

class Autoloader {

    protected static $classPaths = array();
    protected static $classFileSuffix = '.php';

    // @depreciated
    protected static $cacheFilePath = null;
    protected static $cachedPaths = null;
    protected static $excludeFolderNames = '/^CVS|\..*$/'; // CVS directories and directories starting with a dot (.).
    protected static $hasSaver = false;

    /**
     * Sets the paths to search in when looking for a class.
     *
     * @param array $paths
     * @return void
     * */
    public static function setClassPaths($paths) {
        self::$classPaths = $paths;
    }

    /**
     * Adds a path to search in when looking for a class.
     *
     * @param string $path
     * @return void
     * */
    public static function addClassPath($path) {
        self::$classPaths[] = $path;
    }

    /**
     * Set the full file path to the cache file to use.
     * @deprecated
     * */
    public static function setCacheFilePath($path) {
        return TRUE;
    }

    /**
     * Sets the suffix to append to a class name in order to get a file name
     * to look for
     *
     * @param string $suffix - $className . $suffix = filename.
     * @return void
     * */
    public static function setClassFileSuffix($suffix) {
        self::$classFileSuffix = $suffix;
    }

    /**
     * Class resolving is using is_file
     * It will never look into use .svn , .git , etc
     *
     * @deprecated
     * */
    public static function excludeFolderNamesMatchingRegex($regex) {
        return FALSE;
    }

    /**
     * Returns true if the class file was found and included, false if not.
     *
     * @return boolean
     * */
    public static function loadClass($className) {
        foreach (self::$classPaths as $classPath) {
            $file = $classPath
                .str_replace('\\', DIRECTORY_SEPARATOR , $className)
                .self::$classFileSuffix
                ;
            if (is_file($file)) {
                require_once($file);
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @depreciated
     */

    protected static function getCachedPath($className) {
        return FALSE;
    }

    /**
     * @depreciated
     */

    protected static function loadCachedPaths() {
        return FALSE;
    }

    /**
     * @depreciated
     * */
    public static function saveCachedPaths() {
        return FALSE;
    }

    /**
     * @deprecated
     */

    protected static function searchForClassFile($className, $directory) {
        return FALSE;
    }

    public static function register() {
        // nullify any existing autoloads
        spl_autoload_register(null, false);
        // autoloader
        spl_autoload_register(array('Autoloader', 'loadClass'));
    }

}
