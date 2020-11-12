<?php

namespace App\Controller;

use App\Model\Ulozenka;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @Route("/api")
 */
class ApiController
{
    /**
     * @var $ulozenka Ulozenka
     */
    private $ulozenka;
    public function __construct()
    {
        $this->ulozenka = new Ulozenka();
    }

    /**
     * @Route("/get/{id}", name="Get", methods="GET", format="json")
     * @param int $id
     * @return JsonResponse
     */
    public function getGetAction($id): JsonResponse
    {
        $model = $this->ulozenka->find($id);

        return new JsonResponse($model ?? [
                'title' => 'Not Found',
                'status' => 404,
                'message' => 'Unable to find requested resource.'
            ]);
    }

    /**
     * @Route("/list", name="List", methods="GET", format="json")
     * @return JsonResponse
     */
    public function getListAction(): JsonResponse
    {
        return new JsonResponse($this->ulozenka->list() ?? [
                'title' => 'Not Found',
                'status' => 404,
                'message' => 'Unable to find requested resource.'
            ]);
    }
}