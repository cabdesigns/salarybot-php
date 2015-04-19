<?php
class TaxBandsTest extends PHPUnit_Framework_TestCase {

    public function testTaxBandRate() {
        $data = $this->getStub();
        $taxBands = new \SalaryBotUk\TaxYear\TaxBands($data);
        $this->assertEquals(0.4, $taxBands->getRate('higher'));
    }

    public function testTaxBandMin() {
    	$data = $this->getStub();
        $taxBands = new \SalaryBotUk\TaxYear\TaxBands($data);
        $this->assertEquals(31865, $taxBands->getMin('higher'));
    }

    public function testTaxBandMax() {
        $data = $this->getStub();
        $taxBands = new \SalaryBotUk\TaxYear\TaxBands($data);
        $this->assertEquals(150000, $taxBands->getMax('higher'));
    }

    public function getStub() {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->tax;
    }

}
