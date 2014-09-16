<?php

namespace Sasule\Ares;


use Nette\Object;
use Sasule\Ares\Response\Address;
use Sasule\Ares\Response\Entry;

class Response extends Object
{
        /** @var int */
        protected $count = 0;

        /** @var  Entry[] */
        protected $entries;


        protected static $ID_ANSWER = "Odpoved";
        protected static $ID_ANSWER_COUNT = "odpoved_pocet";
        protected static $ID_ENTRY = "Zaznam";
        protected static $ID_IDENTIFY = "Identifikace";
        protected static $ID_IDENTIFY_ADDRESS_ARES = "Adresa_ARES";

        public function __construct($_data)
        {
                $this->setData($_data);
        }

        /**
         * Sets response data and returns
         * @param $_data
         * @return $this
         */
        public function setData($_data)
        {

                if (is_object($_data)) {

                        if (property_exists($_data, self::$ID_ANSWER_COUNT)) {

                                if (intval($_data->{self::$ID_ANSWER_COUNT}) > 0) {
                                        if (property_exists($_data, self::$ID_ANSWER)) {
                                                if (is_array($_data->{self::$ID_ANSWER})) {
                                                        $this->_parseAnswers($_data->{self::$ID_ANSWER});
                                                } else {
                                                        $answer = $_data->{self::$ID_ANSWER};

                                                        if (property_exists($answer, self::$ID_ENTRY)) {
                                                                if (is_array($answer->{self::$ID_ENTRY})) {
                                                                        foreach ($answer->{self::$ID_ENTRY} as $data) {
                                                                                $this->_createEntry($data);
                                                                        }
                                                                } else {
                                                                        $this->_createEntry($answer->{self::$ID_ENTRY});
                                                                }
                                                        }
                                                }
                                        }
                                }
                        }
                }
                return $this;
        }

        /**
         * Parses Answer section
         * @param $_answers
         */
        protected function _parseAnswers($_answers)
        {
                foreach ($_answers as $answer) {
                        if (property_exists($answer, self::$ID_ENTRY)) {
                                if (is_array($answer->{self::$ID_ENTRY})) {
                                        foreach ($answer->{self::$ID_ENTRY} as $data) {
                                                $this->_createEntry($data);
                                        }
                                } else {
                                        $this->_createEntry($answer->{self::$ID_ENTRY});
                                }

                        }
                }
        }

        /**
         * Creates an ARES entry form returned stdClass
         * @param $_data
         */
        protected function _createEntry($_data)
        {
                $entry = new Entry();
                $entry->setData($_data);

                if (property_exists($_data, self::$ID_IDENTIFY)) {
                        $ident = $_data->{self::$ID_IDENTIFY};
                        if (property_exists($ident, self::$ID_IDENTIFY_ADDRESS_ARES)) {
                                $idenAddress = $ident->{self::$ID_IDENTIFY_ADDRESS_ARES};
                                $address = new Address();
                                $address->setData($idenAddress);
                                $entry->setAddress($address);
                        }
                }

                $this->entries[] = $entry;
                $this->count++;
        }


        /**
         * Return count of entries
         * @return int
         */
        public function getCount()
        {
                return $this->count;
        }


        /**
         * Returns entries from Ares
         * @return \Sasule\Ares\Response\Entry[]
         */
        public function getEntries()
        {
                return $this->entries;
        }


}

