<?php
class TaxYearTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        $this->taxYearStub = $stub;
    }

    public function testTaxYearSet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertEquals('2014-2015', $taxYear->getTaxYear());
    }

    public function testAllowancesSet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertInstanceOf('\SalaryBotUk\TaxYear\Allowances', $taxYear->getAllowances());
    }

    public function testTaxSet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertInstanceOf('\SalaryBotUk\TaxYear\TaxBands', $taxYear->getTaxBands());
    }

    public function testNISet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertInstanceOf('\SalaryBotUk\TaxYear\NationalInsurance', $taxYear->getNationalInsurance());
    }

    public function testStudentLoanSet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertInstanceOf('\SalaryBotUk\TaxYear\StudentLoan', $taxYear->getStudentLoan());
    }

    public function testMinimumWageSet()
    {
        $taxYear = new \SalaryBotUk\TaxYear\TaxYear($this->taxYearStub);
        $this->assertInstanceOf('\SalaryBotUk\TaxYear\MinimumWage', $taxYear->getMinimumWage());
    }

}
