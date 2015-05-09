<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class SalaryCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->taxCalculatorMock = \Mockery::mock('\SalaryBotUk\SalaryCalculator\TaxCalculator');
        $this->niCalculatorMock = \Mockery::mock('\SalaryBotUk\SalaryCalculator\NationalInsuranceCalculator');
        $this->studentLoanCalculatorMock = \Mockery::mock('\SalaryBotUk\SalaryCalculator\StudentLoanCalculator');
        $this->pensionContribCalculatorMock = \Mockery::mock('\SalaryBotUk\SalaryCalculator\PensionContribCalculator');
    }

    public function setCalculatorValues($tax, $ni, $studentLoan, $pensionContrib)
    {
        $this->taxCalculatorMock->shouldReceive('calculate')->once()->andReturn($tax);
        $this->niCalculatorMock->shouldReceive('calculate')->once()->andReturn($ni);
        $this->studentLoanCalculatorMock->shouldReceive('calculate')->once()->andReturn($studentLoan);
        $this->pensionContribCalculatorMock->shouldReceive('calculate')->once()->andReturn($pensionContrib);
    }

    public function setCalculatorDeps($parentCalculator)
    {
        $parentCalculator->setTaxCalculator($this->taxCalculatorMock);
        $parentCalculator->setNationalInsuranceCalculator($this->niCalculatorMock);
        $parentCalculator->setStudentLoanCalculator($this->studentLoanCalculatorMock);
        $parentCalculator->setPensionContribCalculator($this->pensionContribCalculatorMock);
    }

    public function testNetIncome()
    {
        $this->salaryMock->shouldReceive('getGross')->once()->andReturn(30000);

        $this->setCalculatorValues(5000, 3000, 1500, 500);
        $calculator = new Calculator\NetIncomeCalculator($this->salaryMock);
        $this->setCalculatorDeps($calculator);
        $netIncome = $calculator->calculate();

        $this->assertEquals(20000, $netIncome);
    }
}
