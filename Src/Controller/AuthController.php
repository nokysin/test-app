<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 30.09.2018
 * Time: 14:50
 */

namespace Src\Controller;

use Core\BaseController;
use Core\Http\Response\Response;
use Core\Security\TokenGenerator;

/**
 * Class AuthController
 * @package Src\Controller
 */
class AuthController extends BaseController
{

    /**
     * @param array $params
     */
    public function tokenAction()
    {
        $login    = $this->getParam('login');
        $password = $this->getParam('password');

        /** @var \Src\Repository\UserRepository $repository */
        $repository = $this->getRepository(User::class);

        /** @var \Src\Model\User $user */
        $user = $repository->findByLoginAndPassword($login, $password);

        if (!empty($user)) {
            $tokenGenerator = new TokenGenerator($user->getLogin());
            $token          = $tokenGenerator->generateToken();

            return $this->response(['token' => $token]);
        } else {

            return $this->response([
                'code'    => Response::HTTP_METHOD_NOT_ALLOWED,
                'message' => Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED],
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }
}