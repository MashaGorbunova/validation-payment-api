<?php

namespace validation\models;

/**
 * Class ValidationData
 *
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 * @package validation\models
 */
class ValidationParams
{
    /**
     * Check if expiration date more than current date
     *
     * @param string $date
     *
     * @return bool
     */
    public static function checkExpirationDate(string $date): bool
    {
        if (!preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $date)) {
            return false;
        }

        $expirationDate = strtotime($date);
        $currentDate = time();

        return $currentDate < $expirationDate;
    }

    /**
     * Check if cvv2 code is 3 number
     *
     * @param int $cvv2
     *
     * @return bool
     */
    public static function checkCVV2(int $cvv2): bool
    {
        return (bool)preg_match('/^\d{3}$/', $cvv2);
    }

    /**
     * Check if email has required format
     *
     * @param string $email
     *
     * @return bool
     */
    public static function checkEmail(string $email): bool
    {
        return (bool)preg_match('/^[\d|\D]+\@\w+\.\w+$/', $email);
    }

    /**
     * Check sum for card number
     *
     * @param string $cardNumber
     *
     * @return bool
     */
    public static function checkCardNumber(string $cardNumber): bool
    {
        if (!preg_match('/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/', $cardNumber)) {
            return false;
        }

        $card = str_replace(' ', '', $cardNumber);
        $checkSum = 0;

        for($i = 0; $i < strlen($card); $i++) {
            if (($i % 2) === 0) {
                $value = $card[$i];
            } else {
                $value = ($card[$i] * 2 > 9) ? ($card[$i] * 2 - 9) : $card[$i] * 2;
            }
            $checkSum += $value;
        }

        return (($checkSum % 10) === 0);
    }

    /**
     * Check phone number format
     *
     * @param string $phoneNumber
     *
     * @return bool
     */
    public static function checkPhoneNumber(string $phoneNumber): bool
    {
        return (bool)preg_match('/^\+\d.\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phoneNumber);
    }
}
