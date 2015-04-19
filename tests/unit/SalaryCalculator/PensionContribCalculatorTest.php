<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class PensionContribCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
    }

    public function testPension()
    {
        $this->employeeMock->shouldReceive('getPensionContribution')->andReturn(1.5);
        $this->salaryMock->shouldReceive('getBase')->andReturn(30000);

        $calculator = new Calculator\PensionContribCalculator($this->employeeMock, $this->salaryMock);
        $pension = $calculator->calculate();

        $this->assertEquals(450, $pension);
    }

    public function testNoPension()
    {
        $this->employeeMock->shouldReceive('getPensionContribution')->andReturn(0);
        $this->salaryMock->shouldReceive('getBase')->andReturn(30000);

        $calculator = new Calculator\PensionContribCalculator($this->employeeMock, $this->salaryMock);
        $pension = $calculator->calculate();

        $this->assertEquals(0, $pension);
    }

}
