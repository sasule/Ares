<?php


use Tester\Assert;


require __DIR__ . "/../../bootstrap.php";


class AresTest extends \Tester\TestCase
{
        protected $in = "00027383";

        /** @var  \Sasule\Ares\Ares */
        protected $ares;

        public function setUp()
        {
                $this->ares = new \Sasule\Ares\Ares("sasa.szollos@gmail.com");
        }


        public function testNoQuery()
        {
                $ares = $this->ares;
                Assert::exception(function () use ($ares) {
                        $ares->request();
                }, 'Sasule\Ares\NoQueryException', \Sasule\Ares\NoQueryException::MESSAGE, \Sasule\Ares\NoQueryException::CODE);
        }

        public function testIdentificationNumber()
        {


                $keyPart = new \Sasule\Ares\Query\KeyPart($this->in);

                $query = new \Sasule\Ares\Query($keyPart);

                $this->ares->addQuery($query);
                $response = $this->ares->request();

                Assert::isEqual(1, $response->getCount());

                $entries = $response->getEntries();

                Assert::count(1, $entries);

                $entry = $entries[0];

                Assert::same($this->in, $entry->getIdentificationNumber());

        }
}


$test = new AresTest();
$test->run();



