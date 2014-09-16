<?php


namespace Sasule\Ares;


use Nette\Object;
use Nette\Utils\DateTime;
use Sasule\Ares\Query\KeyPart;

class Query extends Object implements IObject
{

        const ID = "Dotaz";

        /** @var int */
        protected $helperId;
        /** @var  string */
        protected $searchType;
        /** @var  KeyPart */
        protected $keyPart;
        /** @var  string */
        protected $city;
        /** @var  DateTime */
        protected $dtValid;
        /** @var  string */
        protected $registerType;
        /** @var int */
        protected $maxCount;

        /** @var string */
        protected static $ID_HELPER_ID = "Pomocne_ID";
        /** @var string */
        protected static $ID_SEARCH_TYPE = "Typ_vyhledani";
        /** @var string */
        protected static $ID_KEY_PART = "Klicove_polozky";
        /** @var string */
        protected static $ID_CITY = "Nazev_obce";
        /** @var string */
        protected static $ID_DT_VALID = "Datum_platnosti";
        /** @var string */
        protected static $ID_REGISTER_TYPE = "Typ_registru";
        /** @var string */
        protected static $ID_MAX_COUNT = "Max_pocet";

        const MAX_COUNT = 200;
        const INITIAL_HELPER_ID = 1;
        const SEARCH_TYPE_FREE = "FREE";
        const SEARCH_TYPE_OF = "OF"; //whatever it means...


        /**
         * @param KeyPart $keyPart
         * @param int $maxCount
         */
        public function __construct(KeyPart $keyPart, $maxCount = self::MAX_COUNT)
        {
                $this->maxCount = $maxCount;
                $this->keyPart = $keyPart;
                $this->searchType = self::SEARCH_TYPE_FREE;
                $this->helperId = self::INITIAL_HELPER_ID;
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
         * @param int $helperId
         * @return $this
         */
        public function setHelperId($helperId)
        {
                $this->helperId = $helperId;
                return $this;
        }

        /**
         * @return int
         */
        public function getHelperId()
        {
                return $this->helperId;
        }

        /**
         * @param \Sasule\Ares\Query\KeyPart $keyPart
         * @return $this
         */
        public function setKeyPart($keyPart)
        {
                $this->keyPart = $keyPart;
                return $this;
        }

        /**
         * @return \Sasule\Ares\Query\KeyPart
         */
        public function getKeyPart()
        {
                return $this->keyPart;
        }

        /**
         * @param int $maxCount
         * @return $this
         */
        public function setMaxCount($maxCount)
        {
                $this->maxCount = $maxCount;
                return $this;
        }

        /**
         * @return int
         */
        public function getMaxCount()
        {
                return $this->maxCount;
        }

        /**
         * @param string $searchType
         * @return $this
         */
        public function setSearchType($searchType)
        {
                $this->searchType = $searchType;
                return $this;
        }

        /**
         * @return string
         */
        public function getSearchType()
        {
                return $this->searchType;
        }


        /**
         * @return array of string
         * @throws QueryMissingKeyPartException
         */
        public function toRequestArray()
        {
                $ret = array();

                if ($this->keyPart instanceof KeyPart) {

                        $ret[self::$ID_HELPER_ID] = $this->helperId;

                        if ($this->checkUsable($this->searchType)) {
                                $ret[self::$ID_SEARCH_TYPE] = $this->searchType;
                        }

                        $ret[self::$ID_KEY_PART] = $this->keyPart->toRequestArray();

                        if ($this->checkUsable($this->city)) {
                                $ret[self::$ID_CITY] = $this->city;
                        }

                        if ($this->dtValid instanceof DateTime) {
                                $ret[self::$ID_DT_VALID] = $this->dtValid->format(Ares::REQUEST_DATE_FORMAT);
                        }

                        if ($this->checkUsable($this->registerType)) {
                                $ret[self::$ID_REGISTER_TYPE] = $this->registerType;
                        }

                        $ret[self::$ID_MAX_COUNT] = $this->maxCount;

                } else {
                        throw new QueryMissingKeyPartException();
                }

                return $ret;
        }


        /**
         * Checks whether property is not null and non-zero length
         * @param $property
         * @return bool
         */
        protected function checkUsable($property)
        {
                return ($property !== NULL and strlen($property));
        }
}


class QueryMissingKeyPartException extends \Exception
{
        const CODE = "84101";
        const MESSAGE = "KeyPart is missing.";

        public function __construct($message = self::MESSAGE, $code = self::CODE, \Exception $previous = NULL)
        {
                parent::__construct($message, $code, $previous);
        }
}