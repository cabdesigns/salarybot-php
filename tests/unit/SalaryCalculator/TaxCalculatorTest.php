<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class TaxCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->taxBandsMock = \Mockery::mock('\SalaryBotUk\TaxYear\Bands');
        $this->allowancesCalculatorMock = \Mockery::mock('\SalaryBotUk\SalaryCalculator\AllowancesCalculator');
    }

    public function mockTaxBand($name, $rate = 0, $min = 0, $max = 0)
    {
        $this->taxBandsMock->shouldReceive('getRate')->with($name)->andReturn($rate);
        $this->taxBandsMock->shouldReceive('getMin')->with($name)->andReturn($min);
        $this->taxBandsMock->shouldReceive('getMax')->with($name)->andReturn($max);
    }

    public function testSingleTaxBand()
    {
        $this->mockTaxBand('basic', 0.2, 0, 31865);
        $this->mockTaxBand('higher', 0.4, 31865, 150000);
        $this->mockTaxBand('additional', 0.45, 150000, 0);

        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->allowancesCalculatorMock->shouldReceive('calculate')->andReturn(10000);
        $this->allowancesCalculatorMock->shouldReceive('calculateMarriedCouplesAllowance')->andReturn(0);

        $calculator = new Calculator\TaxCalculator($this->salaryMock, $this->taxBandsMock);
        $calculator->setAllowancesCalculator($this->allowancesCalculatorMock);
        $tax = $calculator->calculate();

        $this->assertEquals(4000, $tax);
    }

    public function testMultiTaxBands()
    {
        $this->mockTaxBand('basic', 0.2, 0, 31865);
        $this->mockTaxBand('higher', 0.4, 31865, 150000);
        $this->mockTaxBand('additional', 0.45, 150000, 0);

        $this->salaryMock->shouldReceive('getGross')->andReturn(50000);
        $this->allowancesCalculatorMock->shouldReceive('calculate')->andReturn(10000);
        $this->allowancesCalculatorMock->shouldReceive('calculateMarriedCouplesAllowance')->andReturn(0);

        $calculator = new Calculator\TaxCalculator($this->salaryMock, $this->taxBandsMock);
        $calculator->setAllowancesCalculator($this->allowancesCalculatorMock);
        $tax = $calculator->calculate();

        $this->assertEquals(9627, $tax);
    }

    public function testTaxBandWithNoLimit()
    {
        $this->mockTaxBand('basic', 0.2, 0, 31865);
        $this->mockTaxBand('higher', 0.4, 31865, 150000);
        $this->mockTaxBand('additional', 0.45, 150000, 0);

        $this->salaryMock->shouldReceive('getGross')->andReturn(200000);
        $this->allowancesCalculatorMock->shouldReceive('calculate')->andReturn(0);
        $this->allowancesCalculatorMock->shouldReceive('calculateMarriedCouplesAllowance')->andReturn(0);

        $calculator = new Calculator\TaxCalculator($this->salaryMock, $this->taxBandsMock);
        $calculator->setAllowancesCalculator($this->allowancesCalculatorMock);
        $tax = $calculator->calculate();

        $this->assertEquals(76127, $tax);
    }

    public function testInvalidBand()
    {
        $this->mockTaxBand('invalidTaxBand', 0);

        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->allowancesCalculatorMock->shouldReceive('calculate')->andReturn(10000);
        $this->allowancesCalculatorMock->shouldReceive('calculateMarriedCouplesAllowance')->andReturn(0);

        $calculator = new Calculator\TaxCalculator($this->salaryMock, $this->taxBandsMock);
        $calculator->setAllowancesCalculator($this->allowancesCalculatorMock);
        $tax = $calculator->calculateBand('invalidTaxBand');

        $this->assertEquals(0, $tax);
    }

    public function testMarriedCouplesAllowance()
    {
        $this->mockTaxBand('basic', 0.2, 0, 31865);
        $this->mockTaxBand('higher', 0.4, 31865, 150000);
        $this->mockTaxBand('additional', 0.45, 150000, 0);

        $this->salaryMock->shouldReceive('getGross')->andReturn(20000);
        $this->allowancesCalculatorMock->shouldReceive('calculate')->andReturn(10660);
        $this->allowancesCalculatorMock->shouldReceive('calculateMarriedCouplesAllowance')->andReturn(816.5);

        $calculator = new Calculator\TaxCalculator($this->salaryMock, $this->taxBandsMock);
        $calculator->setAllowancesCalculator($this->allowancesCalculatorMock);
        $tax = $calculator->calculate();

        $this->assertEquals(1051.5, $tax);
    }

}
