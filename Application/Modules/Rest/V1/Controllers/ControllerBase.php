<?php
namespace Application\Modules\Rest\V1\Controllers;

use \Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 *
 * @package    Application\Modules\Rest
 * @subpackage    Controllers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/Controllers/ControllerBase.php
 */
class ControllerBase extends Controller
{
    /**
     * Rest service
     *
     * @var \Application\Modules\Rest\Services\RestService $rest
     */
    protected $rest;

    /**
     * Is request data has been modified ?
     *
     * @var boolean
     */
    protected $notModified = false;

    /**
     * Event before routes execute
     */
    public function beforeExecuteRoute()
    {
        $this->rest =  $this->getDI()->get("RestService");
        $this->rest->getResolver()->filter($this->request)->validate();
    }

    /**
     * Send response collection put from controllers
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function afterExecuteRoute()
    {
        $this->rest->response($this->notModified);
    }

    /**
     * Garbage clean
     */
    public function afterDispatch() {
        unset($this->rest, $this->notModified);
    }
}
