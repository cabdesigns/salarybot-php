<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class NationalInsuranceCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->niMock = \Mockery::mock('\SalaryBotUk\TaxYear\Bands');
    }

    public function mockNiBand($name, $rate = 0, $min = 0, $max = 0)
    {
        $this->niMock->shouldReceive('getRate')->with($name)->andReturn($rate);
        $this->niMock->shouldReceive('getMin')->with($name)->andReturn($min);
        $this->niMock->shouldReceive('getMax')->with($name)->andReturn($max);
    }

    public function testSingleBand()
    {
        $this->mockNiBand('basic', 0.12, 7956, 41865);
        $this->mockNiBand('higher', 0.02, 41865, 0);

        $this->employeeMock->shouldReceive('isPensioner')->andReturn(false);
        $this->salaryMock->shouldReceive('getGross')->andReturn(20000);

        $calculator = new Calculator\NationalInsuranceCalculator($this->employeeMock, $this->salaryMock, $this->niMock);
        $nationalInsurance = $calculator->calculate();

        $this->assertEquals(1445.28, $nationalInsurance);
    }

    public function testMultiBands()
    {
        $this->mockNiBand('basic', 0.12, 7956, 41865);
        $this->mockNiBand('higher', 0.02, 41865, 0);

        $this->employeeMock->shouldReceive('isPensioner')->andReturn(false);
        $this->salaryMock->shouldReceive('getGross')->andReturn(50000);

        $calculator = new Calculator\NationalInsuranceCalculator($this->employeeMock, $this->salaryMock, $this->niMock);
        $nationalInsurance = $calculator->calculate();

        $this->assertEquals(4231.78, $nationalInsurance);
    }

    public function testInvalidBand()
    {
        $this->mockNiBand('invalidBand');

        $this->employeeMock->shouldReceive('isPensioner')->andReturn(false);
        $this->salaryMock->shouldReceive('getGross')->andReturn(50000);

        $calculator = new Calculator\NationalInsuranceCalculator($this->employeeMock, $this->salaryMock, $this->niMock);
        $nationalInsurance = $calculator->calculateBand('invalidBand');

        $this->assertEquals(0, $nationalInsurance);
    }

    public function testNoNIForPensioner()
    {
        $this->mockNiBand('basic', 0.12, 7956, 41865);
        $this->mockNiBand('higher', 0.02, 41865, 0);

        $this->employeeMock->shouldReceive('isPensioner')->andReturn(true);
        $this->salaryMock->shouldReceive('getGross')->andReturn(50000);

        $calculator = new Calculator\NationalInsuranceCalculator($this->employeeMock, $this->salaryMock, $this->niMock);
        $nationalInsurance = $calculator->calculateBand('higher');

        $this->assertEquals(0, $nationalInsurance);
    }
}
