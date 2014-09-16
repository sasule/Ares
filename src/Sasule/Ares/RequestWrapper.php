<?php

namespace Sasule\Ares;


use Nette\Object;
use Nette\Utils\DateTime;

class RequestWrapper extends Object implements IObject
{
        /**
         * Count of queries
         * @var int
         */
        protected $queryCount = 0;

        /**
         * Required valid user email
         * @var string
         */
        protected $email;

        /**
         * Request Date andTime
         * @var DateTime
         */
        protected $dt;

        /**
         * Request type
         * @var string
         */
        protected $requestType;

        /**
         * Response output format
         * @var string
         */
        protected $outputFormat;

        /** @var array of Query */
        protected $queries = array();

        /** @var string identifier */
        protected static $ID_DT = "dotaz_datum_cas";
        /** @var string identifier */
        protected static $ID_REQUESTS_COUNT = "dotaz_pocet";
        /** @var string identifier */
        protected static $ID_REQUEST_TYPE = "dotaz_typ";
        /** @var string identifier */
        protected static $ID_OUTPUT_FORMAT = "vystup_format";
        /** @var string identifier */
        protected static $ID_EMAIL = "user_mail";
        /** @var string identifier */
        protected static $ID_REQUEST = "Dotaz";


        const REQUEST_TYPE_STANDARD = "Standard";
        const REQUEST_OUTPUT_FORMAT = "XML";


        /**
         * Creates new instance
         * @param string $_email
         */
        public function __construct($_email)
        {
                $this->email = $_email;
                $this->dt = new DateTime();
                $this->outputFormat = self::REQUEST_OUTPUT_FORMAT;
                $this->requestType = self::REQUEST_TYPE_STANDARD;
        }

        /**
         * @param \Nette\Utils\DateTime $dt
         * @return $this
         */
        public function setDt($dt)
        {
                $this->dt = $dt;
                return $this;
        }

        /**
         * @return \Nette\Utils\DateTime
         */
        public function getDt()
        {
                return $this->dt;
        }

        /**
         * @param string $email
         * @return $this
         */
        public function setEmail($email)
        {
                $this->email = $email;
                return $this;
        }

        /**
         * @return string
         */
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * @param string $outputFormat
         * @return $this
         */
        public function setOutputFormat($outputFormat)
        {
                $this->outputFormat = $outputFormat;
                return $this;
        }

        /**
         * @return string
         */
        public function getOutputFormat()
        {
                return $this->outputFormat;
        }

        /**
         * @param string $requestType
         * @return $this
         */
        public function setRequestType($requestType)
        {
                $this->requestType = $requestType;
                return $this;
        }

        /**
         * @return string
         */
        public function getRequestType()
        {
                return $this->requestType;
        }


        /**
         * @return int
         */
        public function getQueryCount()
        {
                return $this->queryCount;
        }


        /**
         * Returns queries
         * @return array of Query
         */
        public function getQueries()
        {
                return $this->queries;
        }

        /**
         * Adds query to array of queries
         * @param Query $_q
         * @return $this
         */
        public function addQuery(Query $_q)
        {

                $this->queryCount++;
                $_q->setHelperId($this->queryCount);
                $this->queries[] = $_q;
                return $this;
        }

        /**
         * @return array of string
         * @throws NoQueryException
         */
        public function toRequestArray()
        {
                $ret = array();


                $ret[self::$ID_DT] = $this->dt->format(Ares::REQUEST_DATE_FORMAT);
                $ret[self::$ID_OUTPUT_FORMAT] = $this->outputFormat;
                $ret[self::$ID_REQUEST_TYPE] = $this->requestType;
                $ret[self::$ID_REQUESTS_COUNT] = $this->queryCount;
                $ret[self::$ID_EMAIL] = $this->email;
                $ret[self::$ID_REQUEST] = array();
                if (!count($this->queries)) {
                        throw new NoQueryException();
                }

                foreach ($this->queries as $query) {
                        /* @var $query \Sasule\Ares\Query */
                        $ret[self::$ID_REQUEST][] = $query->toRequestArray();
                }


                return $ret;
        }


}


class NoQueryException extends \Exception
{
        const CODE = "84103";
        const MESSAGE = "No query provided.";

        public function __construct($message = self::MESSAGE, $code = self::CODE, \Exception $previous = NULL)
        {
                parent::__construct($message, $code, $previous);
        }
}