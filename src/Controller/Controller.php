<?php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use \Psr\Container\ContainerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;

class Controller
{
    use LocatorAwareTrait;

    protected $container;
    /**
     * Token
     *
     * @var \App\Core\Token
     */
    protected $token;
    /**
     * Logger
     *
     * @var \Monolog\Logger
     */
    protected $logger;
    /**
     * Connection
     *
     * @var \Cake\Database\Connection $connection
     */
    protected $connection;

    /**
     * Constructor
     *
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->token = $container->get('token');
        $this->logger = $container->get('logger');
        $this->connection = ConnectionManager::get('default');
        
    }

    /**
     * Get table
     *
     * @param string $name
     * @return \Cake\ORM\Table
     */
    protected function getTable(string $name): Table
    {
        return $this->getTableLocator()->get($name);
    }

    /**
     * Get config
     *
     * @param array $configList
     * @return array
     */
    protected function getConfig(array $configList = []): array
    {
        $conditions = [];

        if ($configList[0] !== '*') {
            foreach ($configList as $config) {
                $conditions['OR'][] = ['name' => $config];
            }
        }

        $configOptions = $this->getTable('Config')
            ->find()
            ->where($conditions)
            ->all()
            ->toArray();

        if (empty($configOptions)) {
            throw new \Exception('Error on loading configuration list');
        }

        $options = [];

        foreach ($configOptions as $configOption) {
            $options[$configOption['name']] =  $configOption['value'];
        }

        return $options;
    }
}
