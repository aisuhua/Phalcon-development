<?php
namespace Application\Modules\Rest\Aware;

/**
 * RestServiceInterface. Implementing rules necessary intended for REST API Service
 *
 * @package Application\Modules\Rest
 * @subpackage Aware
 * @since      PHP >=5.4
 * @version    1.0
 * @author     Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright  Stanislav WEB
 * @filesource /Application/Modules/Rest/Aware/RestValidatorInterface.php
 */
interface RestServiceInterface {

    /**
     * Mex success response code for detect
     */
    const CODE_NOT_MODIFIED     = 304;

    /**
     * Initialize validator to this service
     *
     * @param \Application\Modules\Rest\Services\RestValidatorCollectionService $validator
     */
    public function __construct(\Application\Modules\Rest\Services\RestValidatorCollectionService $validator);

    /**
     * Set response header
     *
     * @param array $params
     */
    public function setHeader(array $params);

    /**
     * Set user app messages content.
     *
     * @param string|array $message
     * @return \Application\Modules\Rest\Services\RestService
     */
    public function setMessage($message);

    /**
     * Get user app messages content.
     *
     * @return array
     */
    public function getMessage();

    /**
     * Get get user preferred / selected locale
     *
     * @return string
     */
    public function getLocale();

    /**
     * Set current  / created resource uri
     *
     * @param array $response
     * @return \Application\Modules\Rest\Services\RestService
     */
    public function setResourceUri(array $response);

    /**
     * Get resource uri
     *
     * @return string
     */
    public function getResourceUri();

    /**
     * Get request params
     *
     * @return array
     */
    public function getParams();

    /**
     * Get related mappers
     *
     * @return array
     */
    public function getRelations();

    /**
     * Set response content length
     *
     * @param string $content
     */
    public function setContentLength($content);

    /**
     * Send response to client
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response();
}