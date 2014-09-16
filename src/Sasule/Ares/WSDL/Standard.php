<?php


namespace Sasule\Ares\WSDL;


use Nette\Object;

class Standard extends Object implements IWsdl
{
        /**
         * WSDL Document
         * @var string
         */
        protected $wsdl = "http://wwwinfo.mfcr.cz/ares/xml_doc/wsdl/standard.wsdl";

        /**
         * Returns WSDL Schema
         * @return string
         */
        public function getWsdl()
        {
                return $this->wsdl;
        }
}