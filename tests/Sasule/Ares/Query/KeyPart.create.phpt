<?php


use Tester\Assert;

require __DIR__ . "/../../../bootstrap.php";


class KeyPartTest extends \Tester\TestCase
{
        /** @var  \Sasule\Ares\Query\KeyPart */
        protected $kp;

        /** @var  \Sasule\Ares\Query\KeyPart */
        protected $kp2;

        public function setUp()
        {
                $this->kp = new \Sasule\Ares\Query\KeyPart("xaxa", "cn", "8412275123");
                $this->kp2 = new \Sasule\Ares\Query\KeyPart();
        }


        public function testConstructorValues()
        {
                Assert::same("xaxa", $this->kp->getIdentificationNumber());
                Assert::same("cn", $this->kp->getCompanyName());
                Assert::same("8412275123", $this->kp->getBirthNumber());
        }


        public function testSameData()
        {
                Assert::same(array(
                    'ICO' => 'xaxa',
                    'Rodne_cislo' => '8412275123',
                    'Obchodni_firma' => 'cn'
                ), $this->kp->toRequestArray());

        }

        public function testEmptyObjectException()
        {
                Assert::exception(function () {
                        $this->kp2->toRequestArray();
                }, '\Sasule\Ares\Query\InvalidKeyPartException', \Sasule\Ares\Query\InvalidKeyPartException::MESSAGE, \Sasule\Ares\Query\InvalidKeyPartException::CODE);
        }


}


$testCase = new KeyPartTest();
$testCase->run();








