<?php

namespace Sasule\Ares;


use Sasule\Ares\WSDL\IWsdl;
use Sasule\Ares\WSDL\Standard;
use Nette\Object;

/**
 * Class Ares
 * Class for communication with Czech Ministry of Finances
 * @package App\Model\Sasule\Ares
 */
class Ares extends Object
{
        /** @var  \SoapClient */
        protected $client;

        /** @var  IWsdl */
        protected $wsdl;

        /** @var  RequestWrapper */
        protected $requestWrapper;

        /** @var  string */
        protected $userEmail;

        const REQUEST_DATE_FORMAT = "Y-m-d\TH:i:s";

        /**
         * Creates new instance of Ares
         * @param string $_userEmail
         * @param IWsdl $_wsdl
         */
        public function __construct($_userEmail, IWsdl $_wsdl = null)
        {

                $this->userEmail = $_userEmail;

                if (null !== $_wsdl) {
                        $this->wsdl = $_wsdl;
                } else {
                        $this->wsdl = new Standard();
                }

                $this->createAresRequest();

        }

        /**
         * Adds a query
         * @param Query $q
         * @return $this
         */
        public function addQuery(Query $q)
        {
                $this->requestWrapper->addQuery($q);
                return $this;
        }

        /**
         * Perforns a request to ARES
         * @return Response
         */
        public function request()
        {
                $client = new \SoapClient($this->wsdl->getWsdl());
                $req = $this->requestWrapper->toRequestArray();


                $response = $client->GetXmlFile($req);

                return new Response($response);
        }


        /**
         * Creates new request wrapper object
         * @return $this
         */
        protected function createAresRequest()
        {
                $this->requestWrapper = new RequestWrapper($this->userEmail);
                return $this;
        }


} 