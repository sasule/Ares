<?php

namespace Sasule\Ares\Query;


use Nette\Object;
use Sasule\Ares\IObject;

/**
 * Class KeyPart<p>
 * Represents "Key part" of Query
 * @package Sasule\Ares\Query
 */
class KeyPart extends Object implements IObject
{

        const ID = "Klicove_polozky";

        /** @var  string */
        protected $identificationNumber;
        /** @var  string */
        protected $birthNumber;
        /** @var  string */
        protected $companyName;

        /** @var string */
        protected static $ID_IDENTIFICATION_NUMBER = "ICO";
        /** @var string */
        protected static $ID_BIRTH_NUMBER = "Rodne_cislo";
        /** @var string */
        protected static $ID_COMPANY_NAME = "Obchodni_firma";

        /**
         * @param string $identificationNumber
         * @param string $companyName
         * @param string $birthNumber
         */
        public function __construct($identificationNumber = null, $companyName = null, $birthNumber = null)
        {
                $this->birthNumber = $birthNumber;
                $this->companyName = $companyName;
                $this->identificationNumber = $identificationNumber;
        }


        /**
         * @param string $birthNumber
         * @return $this
         */
        public function setBirthNumber($birthNumber)
        {
                $this->birthNumber = $birthNumber;
                return $this;
        }

        /**
         * @return string
         */
        public function getBirthNumber()
        {
                return $this->birthNumber;
        }

        /**
         * @param string $identificationNumber
         * @return $this
         */
        public function setIdentificationNumber($identificationNumber)
        {
                $this->identificationNumber = $identificationNumber;
                return $this;
        }

        /**
         * @return string
         */
        public function getIdentificationNumber()
        {
                return $this->identificationNumber;
        }

        /**
         * @param string $companyName
         * @return $this
         */
        public function setCompanyName($companyName)
        {
                $this->companyName = $companyName;
                return $this;
        }

        /**
         * @return string
         */
        public function getCompanyName()
        {
                return $this->companyName;
        }

        /**
         * Returns as array for request
         * @return array
         * @throws InvalidKeyPartException
         */
        public function toRequestArray()
        {
                $ret = array();


                if ($this->identificationNumber !== NULL and strlen($this->identificationNumber)) {
                        $ret[self::$ID_IDENTIFICATION_NUMBER] = $this->identificationNumber;
                }

                if ($this->birthNumber !== NULL and strlen($this->birthNumber)) {

                        $ret[self::$ID_BIRTH_NUMBER] = $this->birthNumber;
                }

                if ($this->companyName !== NULL and strlen($this->companyName)) {
                        $ret[self::$ID_COMPANY_NAME] = $this->companyName;
                }

                if (!count($ret)) {
                        throw new InvalidKeyPartException();
                }

                return $ret;
        }


}

/**
 * Class InvalidKeyPartException
 * @package Sasule\Ares\Query
 */
class InvalidKeyPartException extends \Exception
{
        const CODE = "84100";
        const MESSAGE = "KeyPart is invalid. Check if either one property of identification number, birth number or company name is set.";

        public function __construct($message = self::MESSAGE, $code = self::CODE, \Exception $previous = NULL)
        {
                parent::__construct($message, $code, $previous);
        }


}