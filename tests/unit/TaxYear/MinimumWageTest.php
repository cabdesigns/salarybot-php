<?php
class MinimumWageTest extends PHPUnit_Framework_TestCase
{

    public function testMinimumWage()
    {
    	$data = $this->getStub();
        $minimumWage = new \SalaryBotUk\TaxYear\MinimumWage($data);
        $bands = $minimumWage->getBands();
        $firstBandAge = $bands[0]->minAge;
        $firstBandWage = $bands[0]->minWage;
        $this->assertEquals(0, $firstBandAge);
        $this->assertEquals(3.79, $firstBandWage);
    }

    public function getStub()
    {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->minimumWage;
    }

}
