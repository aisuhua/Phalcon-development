<?php
namespace Application\Modules\Rest\Validators;
use Application\Modules\Rest\Exceptions\NotAcceptableException;

/**
 * Class IsAcceptable. Check if requested data is acceptable by api
 *
 * @package Application\Modules\Rest
 * @subpackage Validators
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Modules/Rest/Validators/IsAcceptable.php
 */
class IsAcceptable {

    /**
     * Check if requested data is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param array $config
     * @throws NotAcceptableException
     */
    public function __construct(\Phalcon\Http\Request $request, array $config) {

        if($this->isValidContentType($request, $config) === false) {
            throw new NotAcceptableException();
        }

        if($this->isValidLanguage($request, $config) === false) {
            throw new NotAcceptableException();
        }
    }

    /**
     * Check if requested content-type is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param array $config
     * @return bool
     */
    private function isValidContentType(\Phalcon\Http\Request $request, array $config) {

        $format = $request->get('format', 'lower', null);

        if(is_null($format) === true) {
            $format = strtolower($request->getBestAccept());
        }

        return in_array($format, $config['accept-content']);
    }

    /**
     * Check if requested locale (language) is acceptable by api
     *
     * @param \Phalcon\Http\Request $request
     * @param array $config
     * @return bool
     */
    private function isValidLanguage(\Phalcon\Http\Request $request, array $config) {

        $locale = $request->get('locale', 'lower', null);

        if(is_null($locale) === true) {

            $locale = strtolower(substr($request->getBestLanguage(), 0, 2));
        }

        return in_array($locale, $config['accept-language']);
    }
}