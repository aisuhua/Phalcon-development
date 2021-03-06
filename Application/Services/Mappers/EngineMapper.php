<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Engines;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Application\Modules\Rest\DTO\EngineDTO;

/**
 * Class EngineMapper. Actions above application engine
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/EngineMapper.php
 */
class EngineMapper extends AbstractModelCrud {

    /**
     * Logo directory
     *
     * @const
     */
    const LOGO_DIR = 'files/logo';

    /**
     * Get instance of polymorphic object
     *
     * @return Engines
     */
    public function getInstance() {
        return new Engines();
    }

    /**
     * Define used engine
     *
     * @return \Application\Models\Engines $engine
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     */
    public function define() {

        $request = $this->getDi()->get('request');
        $engine   =   $this->getInstance()->findFirst("host = '".$request->getHttpHost()."'");

        if($engine === false) {
            throw new NotFoundException([
                'HOST_NOT_FOUND'  =>  'Not found used host: '.$request->getHttpHost()
            ]);
        }

        return $engine;
    }

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @throws \Application\Modules\Rest\Exceptions\NotFoundException
     * @return \Application\Modules\Rest\DTO\EngineDTO
     */
    public function read(array $credentials = [], array $relations = []) {

        $result = $this->getInstance()->find($credentials);

        if($result->count() > 0) {

            $transfer = new EngineDTO();

            if(empty($relations) === false) {
                foreach($relations as $rel => $params) {
                    $transfer->{'set' . ucfirst($rel)}($this->getRelated($params));
                }
            }

            if($result->count() === 1) {

                if(isset($result->getFirst()->logo) === true) {
                    $result->getFirst()->logo = $this->setLogoDir($result->getFirst()->logo);
                }

                $row = $result->getFirst();
                if(!$row instanceof \Phalcon\Mvc\Model\Row) {
                    $currency = $row->getCurrency();
                    if(isset($currency) === true) {
                        $transfer->setCurrencies($currency);
                    }
                    $banners = $row->getBanners();

                    if(isset($banners) === true) {
                        $transfer->setBanners($banners);
                    }
                }
            }

            return $transfer->setEngines($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Setup logo full path
     *
     * @param string $logo
     * @return string
     */
    private function setLogoDir($logo) {

        $request = $this->getDi()->get('request');

        return
            $request->getScheme().'://'.$request->getHttpHost().DIRECTORY_SEPARATOR.
            self::LOGO_DIR.DIRECTORY_SEPARATOR.$logo;
    }
}