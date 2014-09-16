<?php


namespace Sasule\Ares\Response;


use Nette\Object;

class Address extends Object
{
        /** @var  string */
        protected $district;
        /** @var  string */
        protected $city;
        /** @var  string */
        protected $cityPart;
        /** @var  string */
        protected $street;
        /** @var  string */
        protected $orientationNumber;
        /** @var  string */
        protected $postalCode;


        /**
         * Aets data from ARES
         * @param $_data
         */
        public function setData($_data)
        {

                $properties = [
                    "Nazev_okresu" => "district",
                    "Nazev_obce" => "city",
                    "Nazev_casti_obce" => "cityPart",
                    "Nazev_ulice" => "street",
                    "Cislo_domovni" => "orientationNumber",
                    "PSC" => "postalCode",
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
         * @param string $city
         * @return $this
         */
        public function setCity($city)
        {
                $this->city = $city;
                return $this;
        }

        /**
         * @return string
         */
        public function getCity()
        {
                return $this->city;
        }

        /**
         * @param string $cityPart
         * @return $this
         */
        public function setCityPart($cityPart)
        {
                $this->cityPart = $cityPart;
                return $this;
        }

        /**
         * @return string
         */
        public function getCityPart()
        {
                return $this->cityPart;
        }


        /**
         * @param string $district
         * @return $this
         */
        public function setDistrict($district)
        {
                $this->district = $district;
                return $this;
        }

        /**
         * @return string
         */
        public function getDistrict()
        {
                return $this->district;
        }

        /**
         * @param string $orientationNumber
         * @return $this
         */
        public function setOrientationNumber($orientationNumber)
        {
                $this->orientationNumber = $orientationNumber;
                return $this;
        }

        /**
         * @return string
         */
        public function getOrientationNumber()
        {
                return $this->orientationNumber;
        }

        /**
         * @param string $postalCode
         * @return $this
         */
        public function setPostalCode($postalCode)
        {
                $this->postalCode = $postalCode;
                return $this;
        }

        /**
         * @return string
         */
        public function getPostalCode()
        {
                return $this->postalCode;
        }

        /**
         * @param string $street
         * @return $this
         */
        public function setStreet($street)
        {
                $this->street = $street;
                return $this;
        }

        /**
         * @return string
         */
        public function getStreet()
        {
                return $this->street;
        }


} 