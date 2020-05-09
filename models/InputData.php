<?php

namespace validation\models;

require_once "models/HttpException.php";

/**
 * Class InputData
 *
 * @author Maria Gorbunova <m.gorbunova@ukr.net>
 * @package validation\models
 */
class InputData
{
    /**
     * Init body params
     *
     * @throws HttpException
     */
    public function initBodyParams(): void
    {
        if (!empty($_POST)) {
            $this->setParams($_POST);
        }
        $postdata = file_get_contents("php://input");

        if (!empty($postdata)) {
            $data = json_decode($postdata, true);

            if ($data === null) {
                $this->setParamsFromXml($postdata);
            } else {
                $this->setParams($data);
            }
        }
    }

    /**
     * Set params from xml
     *
     * @param string $data
     *
     * @throws HttpException
     */
    protected function setParamsFromXml(string $data): void
    {
        $p = xml_parser_create();
        xml_parse_into_struct($p, $data, $values, $index);
        xml_parser_free($p);

        $inputParams = [];

        foreach ($values as $key => $item) {
            $inputParams[$item['tag']] = $item['value'];
        }
        $this->checkRequiredParams($inputParams);

        foreach ($values as $key => $item) {
            $classVar = strtolower($item['tag']);
            $this->$classVar = $item['value'];
        }
    }

    /**
     * Set input params
     *
     * @param array $data
     *
     * @throws HttpException
     */
    protected function setParams(array $data): void
    {
        $this->checkRequiredParams($data);

        foreach ($data as $key => $value) {
            $classVar = strtolower($key);
            $this->$classVar = $value;
        }
    }

    /**
     * Check required params
     *
     * @param array $data
     *
     * @throws HttpException
     */
    protected function checkRequiredParams(array $data): void
    {
        $params = get_class_vars(static::class);
        $dataLowKey = array_change_key_case($data);

        foreach ($params as $key => $value) {
            if (!isset($dataLowKey[$key])) {
                $key = ucwords($key);
                throw new HttpException("Parameter $key is required.", 400);
            }
        }
    }
}
