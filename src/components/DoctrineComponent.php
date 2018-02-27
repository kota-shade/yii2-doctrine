<?php

namespace KotaShade\doctrine\components;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use yii\base\Component;
use yii\console\Exception;

class DoctrineComponent extends Component
{
    /**
     * @var EntityManager
     */
    private $em    = null;
    private $isDev = false;
    private $basePath;
    private $proxyPath;
    private $entityPath;
//    private $driver;
//    private $user;
//    private $password;
//    private $host;
//    private $dbname;

    private $dbParams=[];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->setConfig($config);
    }

    private function setConfig(array $config)
    {
        if (empty($config)) {
            throw new Exception('Не удалось получить настройки Doctrine');
        }

        foreach ($config as $key => $value) {
            $method = 'set' . ucfirst($key);
            call_user_func([$this, $method], $value);
        }

    }

    public function init()
    {
        \Yii::setAlias('Doctrine', \Yii::getAlias('@app/vendor/Doctrine'));

        $config = Setup::createAnnotationMetadataConfiguration($this->entityPath, $this->getIsDev(), null, null, false);
        $entityManager = EntityManager::create($this->dbParams, $config);
        $this->setEntityManager($entityManager);
    }

    /**
     * @return array
     */
    public function getDbParams()
    {
        return $this->dbParams;
    }

    /**
     * @param array $dbParams
     * @return $this
     */
    public function setDbParams(array $dbParams)
    {
        $this->dbParams = $dbParams;
        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @param EntityManager $entityManager
     * @return self
     */
    public function setEntityManager($entityManager)
    {
        $this->em = $entityManager;
        return $this;
    }

    public function getIsDev()
    {
        return $this->isDev;
    }

    public function setIsDev($isDev)
    {
        $this->isDev = $isDev;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getProxyPath()
    {
        return $this->proxyPath;
    }

    public function setProxyPath($proxyPath)
    {
        $this->proxyPath = $proxyPath;
    }

    public function setEntityPath(array $entityPath)
    {
        $pathApp = dirname(\Yii::getAlias('@app')) . '/';

        foreach ($entityPath as $item) {
            $this->entityPath[] = $pathApp . $item;
        }
    }

    public function getEntityPath()
    {
        return $this->entityPath;
    }

    public function setDbParam($name, $value)
    {
        $this->dbParams[$name] = $value;
    }

    public function getDbParam($name) {
        return (array_key_exists($name, $this->dbParams)) ? $this->dbParams[$name] : null;
    }
}