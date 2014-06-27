<?php

namespace Quartz\Component\FormValidator\tests\units;

/**
 * Description of Tester
 *
 * @author paul
 */
class Tester extends \mageekguy\atoum\test
{
    /**
     *
     * @var \Silex\Application
     */
    protected $app;

    /**
     *
     * @var \Logging\Logger
     */
    protected $logger;

    /**
     *
     * @var \Quartz\Connection\Connection
     */
    protected $conn = null;
    
    public function __construct(\mageekguy\atoum\adapter $adapter = null, \mageekguy\atoum\annotations\extractor $annotationExtractor = null, \mageekguy\atoum\asserter\generator $asserterGenerator = null, \mageekguy\atoum\test\assertion\manager $assertionManager = null, \closure $reflectionClassFactory = null)
    {
        parent::__construct($adapter, $annotationExtractor, $asserterGenerator, $assertionManager, $reflectionClassFactory);
        $self = $this;
        
        $this->getAssertionManager()->setHandler('fail', function($dummy = null) use(&$self){
            return $self->assert('force fail')->boolean(false)->isTrue();
        });
        
        $this->getAssertionManager()->setHandler('pass', function($dummy = null) use(&$self){
            return $self->assert('force pass')->boolean(true)->isTrue();
        });
        
        $this->logger = new \Psr\Log\NullLogger();
    }

    public function beforeTestMethod($method)
    {
        if( class_exists('\Ongoo\Core\Configuration') )
        {
            $this->app = \Ongoo\Core\Configuration::getInstance()->get('application');
            if( $this->app )
            {
                $this->logger = $this->app['logger'];
                $this->logger->set('test_method', $method);
                $this->logger->debug(str_repeat("\n", 3));
                $this->logger->debug(str_repeat("-", 10));
                $this->logger->debug("Start testing $method");
            }
        }
        if( class_exists('\Quartz\Object\Entity') )
        {
            $this->conn = $this->app['orm']->getConnection('default');
        }
    }
    
    public function interpolate($message, $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val)
        {
            $replace['{' . $key . '}'] = $this->flattern($val, 1);
        }

        $message = str_replace('\\{', '${__accolade__}', $message);
        $message = str_replace('\\}', '{__accolade__}$', $message);
        $replace['${__accolade__}'] = '{';
        $replace['{__accolade__}$'] = '}';

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
    
    public function flattern($item, $level = 0)
    {
        if (is_null($item))
        {
            return 'null';
        } elseif($item instanceof \DateTime)
        {
            return "\\datetime('" . $item->format('Y-m-d H:i:s') . "')";
        } elseif($item instanceof \DateInterval)
        {
            return "\\dateinterval('" . $item->format('P%yY%mM%dDT%hH%iI%sS') . "')";
        } elseif (is_numeric($item))
        {
            return $item;
        } elseif (is_string($item))
        {
            return "'$item'";
        } elseif (is_bool($item))
        {
            return $item ? 'true' : 'false';
        } elseif ($item instanceof \Closure)
        {
            return '{closure}';
        } elseif (is_resource($item))
        {
            return '' . $item;
        } elseif (is_object($item))
        {
            $flat = $this->flattern(get_object_vars($item), $level - 1);
            return preg_replace('#^array\((.*)\)$#', get_class($item) . '{\1}', $flat);
        } elseif (is_array($item))
        {
            if ($level >= 0)
            {
                $self = &$this;

                $values = array();
                $iterator = 0;
                array_walk($item, function($value, $key) use(&$values, &$self, $level, &$iterator)
                        {
                            $sK = '';
                            if (!is_numeric($key) || $key != $iterator++)
                            {
                                $sK = is_numeric($key) ? $key : "'$key'";
                                $sK .= ' => ';
                            }
                            $values[] = $sK . $self->flattern($value, $level-1);
                        });

                return 'array(' . implode(', ', $values) . ')';
            } else
            {
                return 'array(...)';
            }
        }
        else {
            return "\raw($item)";
        }
    }
    public function debug($object)
    {
        $this->logger->debug($object);
        return $this;
    }

    public function assert($assertion, $context = array())
    {
        
        $message = $this->interpolate($assertion, $context);
        $this->notice(date('Y-m-d H:i:s') . ": $message");
        return parent::assert($message);
    }

    public function log($object)
    {
        $this->logger->debug($object);
        return $this;
    }

    public function warning($object)
    {
        $this->logger->warning($object);
        return $this;
    }

    public function error($object)
    {
        $this->logger->warning($object);
        return $this;
    }

    public function notice($object)
    {
        $this->logger->notice($object);
        return $this;
    }
}
