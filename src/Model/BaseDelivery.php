<?php

namespace App\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class BaseDelivery
 * @package App\Model
 */
class BaseDelivery extends BaseModel
{
    const ENDPOINT_BASE_URL = '';
    const ENDPOINT_LIST = '';

    /**
     * @var $client Client
     */
    private $client;
    private $list = [];

    /**
     * @param $id
     * @param bool $force
     * @return mixed|null
     */
    public function find($id, $force = false): ?self
    {
        return $this->list($force)[$id] ?? null;
    }


    /**
     * @inheritDoc
     */
    function rules(): array
    {
        return [];
    }

    /**
     * @param bool $force
     * @return array
     */
    public function list($force = false): array
    {
        try {
            if (!$this->list || !$force) {
                $request = $this->getClient()->get(static::ENDPOINT_BASE_URL . '/' . static::ENDPOINT_LIST);
                $data = json_decode($request->getBody()->getContents(), true);

                $this->list = [];
                foreach ($data as $item) {
                    $model = new static;
                    $model->load($item);
                    $this->list[$item['id']] = $model;
                }
            }
            return $this->list;
        } catch (GuzzleException $e) {
            $this->error[] = $e->getMessage();
            return [];
        }
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        if (!$this->client instanceof Client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}