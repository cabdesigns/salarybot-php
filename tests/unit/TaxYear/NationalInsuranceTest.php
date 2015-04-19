<?php
class NationalInsuranceTest extends PHPUnit_Framework_TestCase {

    public function testRate() {
        $data = $this->getStub();
        $nationalInsurance = new \SalaryBotUk\TaxYear\NationalInsurance($data);
        $this->assertEquals(0.12, $nationalInsurance->getRate('basic'));
    }

    public function testMin() {
    	$data = $this->getStub();
        $nationalInsurance = new \SalaryBotUk\TaxYear\NationalInsurance($data);
        $this->assertEquals(7957, $nationalInsurance->getMin('basic'));
    }

    public function testMax() {
        $data = $this->getStub();
        $nationalInsurance = new \SalaryBotUk\TaxYear\NationalInsurance($data);
        $this->assertEquals(41865, $nationalInsurance->getMax('basic'));
    }

    public function getStub() {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->nationalInsurance;
    }

}
