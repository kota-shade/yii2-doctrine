<?php

namespace KotaShade\doctrine\console;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use yii\console\Controller;
use Yii;
use KotaShade\doctrine\components\DoctrineComponent;
use yii\base\Module;

class DoctrineController extends Controller
{
    public $option;

    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        /** @var DoctrineComponent $doctrine */
        $doctrine = Yii::$app->get('doctrine');
        $em = $doctrine->getEntityManager();
        $platform = $em->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

    public function actionIndex()
    {
        $this->env();
        \Yii::setAlias('Symfony', \Yii::getAlias('@app/vendor/Symfony'));

        $entityManager = \Yii::$app->doctrine->getEntityManager();
        $helperSet = ConsoleRunner::createHelperSet($entityManager);

        ConsoleRunner::run($helperSet, []);
    }

    public function options($actionID)
    {
        return ['option'];
    }

    public function optionAliases()
    {
        return ['o' => 'option'];
    }

    /**
     * переписываем значения глобальных
     * переменных для возможности запуска консольного скрипта
     * для введения опции нужно ввести -o=опция/алиас доктрины
     */
    private function env()
    {
        $args = $_SERVER['argv'];

        unset ($args[0]);
        unset($_SERVER['argv']);

        foreach ($args as $arg) {
            $_SERVER['argv'][] = $arg;
        }

        if (isset($this->option)) {
            $_SERVER['argv'][2] =  str_replace('-o=','' , $_SERVER['argv'][2]);
        }
    }
}