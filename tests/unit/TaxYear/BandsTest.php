<?php
class BandsTest extends PHPUnit_Framework_TestCase
{

    public function testTaxBandRate()
    {
        $data = $this->getStub();
        $bands = new \SalaryBotUk\TaxYear\Bands($data);
        $this->assertEquals(0.4, $bands->getRate('higher'));
    }

    public function testTaxBandMin()
    {
        $data = $this->getStub();
        $bands = new \SalaryBotUk\TaxYear\Bands($data);
        $this->assertEquals(31865, $bands->getMin('higher'));
    }

    public function testTaxBandMax()
    {
        $data = $this->getStub();
        $bands = new \SalaryBotUk\TaxYear\Bands($data);
        $this->assertEquals(150000, $bands->getMax('higher'));
    }

    public function getStub()
    {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->tax;
    }
}
