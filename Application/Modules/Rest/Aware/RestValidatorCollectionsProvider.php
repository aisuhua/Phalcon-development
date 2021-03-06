<?php
namespace Application\Modules\Rest\Aware;

use Phalcon\DI\InjectionAwareInterface;

/**
 * RestValidatorCollectionsProvider. Rest API Provide validation services
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorCollectionsProvider.php
 */
abstract class RestValidatorCollectionsProvider
    implements InjectionAwareInterface {

    /**
     * Dependency injection container
     *
     * @var \Phalcon\DiInterface $di
     */
    protected $di;

    /**
     * Validators collections
     *
     * @var array $collection
     */
    protected $collection = [];

    /**
     * Rules collections
     *
     * @var \StdClass $rules
     */
    protected $rules;

    /**
     * Request service
     *
     * @var \Phalcon\Http\Request $request
     */
    protected $request;

    /**
     * Response data
     *
     * @var array $response
     */
    protected $response;

    /**
     * Setup validators
     *
     * @param \Phalcon\DI\FactoryDefault $di
     */
    public function __construct(\Phalcon\DI\FactoryDefault $di) {

        $this->setCollection($di->get('RestConfig')->api->requestResolvers->toArray())
            ->setDi($di)
            ->setRules($di->get('RestRules'));
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\DiInterface $di
     * @return RestValidatorCollectionsProvider
     */
    public function setDi($di)
    {
        $this->di = $di;

        return $this;
    }

    /**
     * Get dependency container
     *
     * @return \Phalcon\DiInterface
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Get dispatcher instance
     *
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function getDispatcher()
    {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * Get request instance
     *
     * @return \Phalcon\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get response
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set response data
     *
     * @return array $response
     */
    public function setResponse(array $response)
    {
        return $this->response = $response;
    }

    /**
     * Set request instance
     *
     * @return \Phalcon\Http\Request
     */
    public function setRequest(\Phalcon\Http\Request $request)
    {
        return $this->request = $request;
    }

    /**
     * Get api config
     *
     * @return \Phalcon\Config
     */
    protected function getConfig()
    {
        return $this->getDi()->get('RestConfig')->api;
    }

    /**
     * Get api rules
     *
     * @return \Phalcon\Config
     */
    public function getRules()
    {
        return (object)$this->rules;
    }

    /**
     * Set validation rules for dispatched route
     *
     * @param array $rules
     * @return RestValidatorCollectionsProvider
     */
    protected function setRules(array $rules)
    {
        $dsp = $this->getDispatcher();
        if(isset($rules[$dsp->getControllerName()][$dsp->getActionName()]) === true) {

            $this->rules = $rules[$dsp->getControllerName()][$dsp->getActionName()];
        }

        return $this;
    }

    /**
     * Set collection of validate rules
     *
     * @param array $collection
     * @return RestValidatorCollectionsProvider
     */
    protected function setCollection(array $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection of validate rules
     *
     * @return array
     */
    protected function getCollection()
    {
        return $this->collection;
    }

    /**
     * Filter requested params
     *
     * @param array $params
     * @param array $filters
     * @return mixed
     */
    abstract protected function filterParams(array $params, array $filters);

    /**
     * Set requested params
     *
     * @param \Phalcon\Http\Request $request
     */
    abstract protected function setParams(\Phalcon\Http\Request $request);

    /**
     * Get filtered params
     *
     * @return array
     */
    abstract protected function getParams();

    /**
     * Request validator
     */
    abstract protected function validate();

    /**
     * Response resolver (validator)
     *
     * @param mixed $responseData
     */
    abstract protected function resolve($responseData);
}