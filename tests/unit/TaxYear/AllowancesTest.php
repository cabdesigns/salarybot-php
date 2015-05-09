<?php
class AllowancesTest extends PHPUnit_Framework_TestCase
{

    public function testPersonalAllowance()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(10000, $allowances->getPersonalAllowance());
    }

    public function testHighEarnerThreshold()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(100000, $allowances->getHighEarnerThreshold());
    }

    public function testBlindAllowance()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(2230, $allowances->getBlindAllowance());
    }

    public function testBadAgeAllowance()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(0.0, $allowances->getAgeBandAllowance('test'));
    }

    public function testAge6574Allowance()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(10500, $allowances->getAgeBandAllowance(65));
    }

    public function testAge75Allowance()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(10660, $allowances->getAgeBandAllowance(75));
    }

    public function testAgeAllowancesThreshold()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(27000, $allowances->getAgeAllowanceThreshold());
    }

    public function testMarriageAllowanceMin()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(3140, $allowances->getMarriageAllowanceMin());
    }

    public function testMarriageAllowanceMax()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(8165, $allowances->getMarriageAllowanceMax());
    }

    public function testMarriageAllowanceRate()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(0.1, $allowances->getMarriageAllowanceRate());
    }

    public function testMarriageAllowanceMinAge()
    {
        $data = $this->getStub();
        $allowances = new \SalaryBotUk\TaxYear\Allowances($data);
        $this->assertEquals(75, $allowances->getMarriageAllowanceMinAge());
    }

    public function getStub()
    {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->allowances;
    }
}
