<?php

namespace validation\models;

require_once "models/InputData.php";

/**
 * Class InputDataCreditCard
 *
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 */
class InputDataCreditCard extends InputData
{
    public const KEY_CREDIT_CARD_NUMBER = 'CreditCardNumber';
    public const KEY_EXPIRATION_DATE = 'ExpirationDate';
    public const KEY_CVV2 = 'CVV2';
    public const KEY_EMAIL = 'Email';
    /**
     * @var string
     */
    public string $creditcardnumber;

    /**
     * @var string
     */
    public string $expirationdate;

    /**
     * @var int
     */
    public int $cvv2;

    /**
     * @var string
     */
    public string $email;
}
