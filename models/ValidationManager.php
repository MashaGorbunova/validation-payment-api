<?php

namespace app\models;

require_once "models/ValidationParams.php";
require_once "models/HttpException.php";

/**
 * Class ValidationManager
 *
 * @version 1.0
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 */
class ValidationManager
{
    /**
     * Validation credit card params
     *
     * @param array $data
     *
     * @throws HttpException
     */
    public function validateCreditCard(array $data)
    {
        if (isset($data[InputDataCreditCard::KEY_CREDIT_CARD_NUMBER])) {
            $isValid = ValidationParams::checkCardNumber($data[InputDataCreditCard::KEY_CREDIT_CARD_NUMBER]);
            if (!$isValid) {
                $this->notValidException(InputDataCreditCard::KEY_CREDIT_CARD_NUMBER);
            }
        }

        if (isset($data[InputDataCreditCard::KEY_EXPIRATION_DATE])) {
            $isValid = ValidationParams::checkExpirationDate($data[InputDataCreditCard::KEY_EXPIRATION_DATE]);
            if (!$isValid) {
                $this->notValidException(InputDataCreditCard::KEY_EXPIRATION_DATE);
            }
        }

        if (isset($data[InputDataCreditCard::KEY_CVV2])) {
            $isValid = ValidationParams::checkCVV2($data[InputDataCreditCard::KEY_CVV2]);
            if (!$isValid) {
                $this->notValidException(InputDataCreditCard::KEY_CVV2);
            }
        }

        if (isset($data[InputDataCreditCard::KEY_EMAIL])) {
            $isValid = ValidationParams::checkEmail($data[InputDataCreditCard::KEY_EMAIL]);
            if (!$isValid) {
                $this->notValidException(InputDataCreditCard::KEY_EMAIL);
            }
        }
    }

    /**
     * Validation mobile params
     *
     * @param array $data
     *
     * @throws HttpException
     */
    public function validateMobile(array $data)
    {
        if (isset($data[InputDataMobile::KEY_PHONE_NUMBER])) {
            $isValid = ValidationParams::checkPhoneNumber($data[InputDataMobile::KEY_PHONE_NUMBER]);
            if (!$isValid) {
                $this->notValidException(InputDataMobile::KEY_PHONE_NUMBER);
            }
        }
    }

    /**
     * Get exception if not valid params
     *
     * @param string $param
     *
     * @throws HttpException
     */
    protected function notValidException(string $param)
    {
        throw new HttpException($param . ' is not valid.', 400);
    }
}
