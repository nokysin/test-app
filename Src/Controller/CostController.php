<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 29.09.2018
 * Time: 00:53
 */

namespace Src\Controller;

use Core\BaseController;
use Core\Http\Response\Response;
use Src\Model\Cost;

/**
 * Class CostController
 * @package Src\Controller
 */
class CostController extends BaseController
{
    /**
     * @return string
     */
    public function listAction()
    {
        /** @var \Src\Repository\CostRepository $repository */
        $repository = $this->getRepository(Cost::class);

        $costs = $repository->findAll();

        if (count($costs) > 0) {
            return $this->response($costs);
        } else {
            return $this->responseNotFound();
        }
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function viewAction(array $params)
    {

        /** @var \Src\Repository\CostRepository $repository */
        $repository = $this->getRepository(Cost::class);

        $id = array_key_exists('id', $params) ? $params['id'] : false;

        $cost = $repository->findById($id);

        if (!empty($cost)) {
            return $this->response($cost);
        } else {
            return $this->responseNotFound();
        }
    }
}