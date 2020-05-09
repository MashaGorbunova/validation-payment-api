<?php

namespace validation\controllers;

use validation\models\HttpException;
use validation\models\InputDataCreditCard;
use validation\models\InputDataMobile;
use validation\models\ValidationManager;

require_once "models/ValidationParams.php";
require_once "models/InputDataCreditCard.php";
require_once "models/InputDataMobile.php";
require_once "models/HttpException.php";
require_once "models/ValidationManager.php";

/**
 * Class ValidationController
 *
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 * @package validation\controllers
 */
class ValidationController
{
    /**
     * Action for endpoint CreditCard for POST method
     *
     * @return array
     */
    public function actionCreditCard(): array
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new HttpException('Page not found.', 404);
            }

            if (file_get_contents('token.txt') !== $this->getBearerToken()) {
                throw new HttpException('Access denied.', 403);
            }
            $inputData = new InputDataCreditCard();
            $inputData->initBodyParams();

            $data = [
                InputDataCreditCard::KEY_CREDIT_CARD_NUMBER => $inputData->creditcardnumber,
                InputDataCreditCard::KEY_EXPIRATION_DATE => $inputData->expirationdate,
                InputDataCreditCard::KEY_CVV2 => $inputData->cvv2,
                InputDataCreditCard::KEY_EMAIL => $inputData->email
            ];
            $validationManager = new ValidationManager();
            $validationManager->validateCreditCard($data);

        } catch (HttpException $exception) {
            header("HTTP/1.1 {$exception->getCode()} Error");
            print $exception->getMessage();
            exit($exception->getCode());
        }

        return ['Valid' => true];
    }

    /**
     * Action for endpoint Mobile for POST method
     *
     * @return array
     */
    public function actionMobile(): array
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new HttpException('Page not found.', 404);
            }

            if (file_get_contents('token.txt') !== $this->getBearerToken()) {
                throw new HttpException('Access denied.', 403);
            }
            $inputData = new InputDataMobile();
            $inputData->initBodyParams();

            $data = [
                InputDataMobile::KEY_PHONE_NUMBER => $inputData->phonenumber
            ];
            $validationManager = new ValidationManager();
            $validationManager->validateMobile($data);

        } catch (HttpException $exception) {
            header("HTTP/1.1 {$exception->getCode()} Error");
            print $exception->getMessage();
            exit($exception->getCode());
        } catch (\Error $exception) {
            header("HTTP/1.1 500 Error");
            print $exception->getMessage();
            exit(500);
        }

        return ['Valid' => true];
    }

    /**
     * Action for endpoint Token for GET method
     *
     * @return array
     *
     * @throws HttpException
     */
    public function actionToken(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            throw new HttpException('Page not found.', 404);
        }

        $uniqId = uniqid('payment_', true);
        $timestamp = time();
        $date = date('Y-m-d', $timestamp);
        $token = md5($uniqId . $date . $timestamp);

        file_put_contents('token.txt', $token);

        return ['SecureToken' => $token];
    }

    /**
     * Get token
     *
     * @return string
     */
    protected function getBearerToken(): ?string
    {
        $token = '';
        $headerArray = apache_request_headers();
        if (isset($headerArray['Authorization'])) {
            $data = explode(' ', $headerArray['Authorization']);
            $token = $data[1] ?? '';
        }

        return $token;
    }
}
