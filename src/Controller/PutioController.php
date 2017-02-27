<?php

namespace Gpenverne\PutioDriveBundle\Controller;

use Gpenverne\PutioDriveBundle\Factory\PutioApiFactory;
use Gpenverne\PutioDriveBundle\Service\UrlGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PutioController
{
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var PutioApiFactory
     */
    private $putioDrive;

    /**
     * @param UrlGenerator    $urlGenerator
     * @param PutioApiFactory $putioDrive
     */
    public function __construct(
        UrlGenerator $urlGenerator,
        PutioApiFactory $putioDrive
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->putioDrive = $putioDrive;
    }

    /**
     * @return RedirectResponse
     */
    public function redirectAction()
    {
        $url = $this->urlGenerator->getRedirectUrl();

        return new RedirectResponse($url);
    }

    /**
     * @return JsonResponse
     */
    public function callbackAction()
    {
        $data = [
            'token' => $this->putioDrive->getToken(),
        ];

        return new JsonResponse(json_encode($data));
    }
}
