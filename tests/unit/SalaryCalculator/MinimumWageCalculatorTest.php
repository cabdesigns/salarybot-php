<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class MinimumWageCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->minimumWageMock = \Mockery::mock('\SalaryBotUk\TaxYear\MinimumWage');

        $bands = [
            $this->stubMinWageBand(0, 3.79),
            $this->stubMinWageBand(18, 5.13),
            $this->stubMinWageBand(21, 6.50)
        ];

        $this->minimumWageMock->shouldReceive('getBands')->andReturn($bands);
    }

    public function stubMinWageBand($minAge, $minWage)
    {
        $band = new stdClass;
        $band->minAge = $minAge;
        $band->minWage = $minWage;
        return $band;
    }

    public function testMinimumWage()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(5.13);
        $this->employeeMock->shouldReceive('getAge')->andReturn(19);

        $calculator = new Calculator\MinimumWageCalculator($this->employeeMock, $this->salaryMock, $this->minimumWageMock);
        $minimumWage = $calculator->calculate();

        $this->assertEquals(true, $minimumWage);
    }

    public function testBelowMinimumWage()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(5.13);
        $this->employeeMock->shouldReceive('getAge')->andReturn(22);

        $calculator = new Calculator\MinimumWageCalculator($this->employeeMock, $this->salaryMock, $this->minimumWageMock);
        $minimumWage = $calculator->calculate();

        $this->assertEquals(false, $minimumWage);
    }

    public function testNoAgeProvided()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(5.13);
        $this->employeeMock->shouldReceive('getAge')->andReturn(null);

        $calculator = new Calculator\MinimumWageCalculator($this->employeeMock, $this->salaryMock, $this->minimumWageMock);
        $minimumWage = $calculator->calculate();

        $this->assertEquals(true, $minimumWage);
    }
}
