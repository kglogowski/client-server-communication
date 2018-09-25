<?php

namespace CSC\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getTokenAction(Request $request): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $response = $this->get('csc.security.response.processor.access_token')->process($request);

        return $response;
    }

    /**
     * @return Response
     */
    public function getActiveUserAction(): Response
    {
        $response = $this->get('csc.security.response.processor.active_user')->process();

        return $response;
    }

    /**
     * @return Response
     */
    public function clearTokenAction(): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $response = $this->get('csc.security.response.processor.clear_token')->process();

        return $response;
    }
}