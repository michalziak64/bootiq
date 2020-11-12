<?php

namespace App\Model;

/**
 * Class Ulozenka
 * @package App\Model
 * @property string $name
 * @property double $lat
 */
class Ulozenka extends BaseDelivery
{
    const ENDPOINT_BASE_URL = 'https://www.ulozenka.cz';
    const ENDPOINT_LIST = 'gmap';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'odkaz', 'transport_id', 'shortcut', 'pic'], 'string'],
            [['lat', 'lng'], 'double'],
            [['register', 'destination', 'active', 'public'], 'int'],
            [['openingHours'], 'array'],
            [['announcements'], 'string']
        ];
    }
}