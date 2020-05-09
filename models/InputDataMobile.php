<?php

namespace app\models;

require_once "models/InputData.php";

/**
 * Class InputDataMobile
 *
 * @version 1.0
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 */
class InputDataMobile extends InputData
{
    public const KEY_PHONE_NUMBER = 'PhoneNumber';

    /**
     * @var string
     */
    public string $phonenumber;
}
