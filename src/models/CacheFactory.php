<?php
/**
 * Created by PhpStorm.
 * User: kota
 * Date: 27.02.18
 * Time: 13:42
 */

namespace KotaShade\doctrine\models;

use Doctrine\Common\Cache as CacheNS;
use Yii;

/**
 * create cache driver
 *
 * Class CacheFactory
 * @package KotaShade\doctrine\models
 */
class CacheFactory
{
    public function __invoke($driverName, array $params=[])
    {
        $cache = null;
        switch($driverName)
        {
            case CacheNS\FilesystemCache::class:

                if (array_key_exists('directory', $params)) {
                    $directory = Yii::getAlias($params['directory']);
                } else {
                    $directory = Yii::$app->getRuntimePath() . '/doctrine';
                }
                $ext = isset($params['extension'])? $params['extension']: \Doctrine\Common\Cache\FilesystemCache::EXTENSION;
                $umask = isset($params['umask'])? $params['umask'] : 0002;
                $cache = new CacheNS\FilesystemCache($directory, $ext, $umask);
                break;
            case CacheNS\MemcacheCache::class:
                //TODO
                break;
            case CacheNS\MemcachedCache::class:
                //TODO
                break;
            default:
                $cache = new $driverName();
        }

        return $cache;
    }
}