<?php
namespace Kit\TablePrefixBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;

class TablePrefixSubscriber implements EventSubscriber
{

    protected $prefix = '';

    protected $exclude = [];

    protected $include = [];
    /**
     * @var \Symfony\Bridge\Monolog\Logger $logger
     */
    protected $logger;

    public function __construct($prefix, array $exclude = [], array $include = [], $logger = null)
    {
        $this->prefix = $prefix;
        $this->exclude = $exclude;
        $this->include = $include;
        $this->logger = $logger;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        if (empty($this->prefix)) return ;
        $classMetadata = $eventArgs->getClassMetadata();
        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            // if we are in an inheritance hierarchy, only apply this once
            return ;
        }
        $tableName = $classMetadata->getTableName();
        // if excelude
        if(!empty($this->exclude) && in_array($tableName, $this->exclude)){
            return ;
        }
        if(empty($this->include) || in_array($tableName, $this->include)){
            $classMetadata->setTableName($this->prefix . $tableName);
            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
                // Check if "joinTable" exists, it can be null if this field is the reverse side of a ManyToMany relationship
                if($mapping['type'] == ClassMetadata::MANY_TO_MANY && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name'])) {
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $classMetadata->associationMappings[$fieldName]['joinTable']['name'];;
                }
            }
        }
        return ;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Doctrine\Common\EventSubscriber::getSubscribedEvents()
     */
    public function getSubscribedEvents()
    {
        return [
            'loadClassMetadata'
        ];
    }
}