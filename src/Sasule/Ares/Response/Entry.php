<?php


namespace Sasule\Ares\Response;


use Nette\Object;

class Entry extends Object
{
        /** @var  string */
        protected $identificationNumber;
        /** @var  string */
        protected $companyName;
        /** @var  Address */
        protected $address;

        /**
         * Sets data from Ares
         * @param $_data
         */
        public function setData($_data)
        {

                $properties = [
                    "ICO" => "identificationNumber",
                    "Obchodni_firma" => "companyName",
                    "Nazev_casti_obce" => "cityPart",
                ];

                if (is_object($_data)) {
                        $vars = get_object_vars($_data);
                        foreach ($vars as $key => $value) {
                                if (array_key_exists($key, $properties)) {
                                        $method = "set" . ucfirst($properties[$key]);
                                        if (method_exists($this, $method)) {
                                                $this->$method($value);
                                        }
                                }
                        }
                } elseif (is_array($_data)) {
                        foreach ($properties as $key => $value) {
                                if (array_key_exists($key, $_data)) {
                                        $method = "set" . ucfirst($value);
                                        if (method_exists($this, $method)) {
                                                $this->$method($_data[$key]);
                                        }
                                }
                        }
                }


        }

        /**
         * @param \Sasule\Ares\Response\Address $address
         * @return $this
         */
        public function setAddress($address)
        {
                $this->address = $address;
                return $this;
        }

        /**
         * @return \Sasule\Ares\Response\Address
         */
        public function getAddress()
        {
                return $this->address;
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


} 