<?php

namespace validation\models;

require_once "models/InputData.php";

/**
 * Class InputDataMobile
 *
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 * @package validation\models
 */
class InputDataMobile extends InputData
{
    public const KEY_PHONE_NUMBER = 'PhoneNumber';

    /**
     * @var string
     */
    public string $phonenumber;
}
