<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class AllowancesCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->allowancesMock = \Mockery::mock('\SalaryBotUk\TaxYear\Allowances');
        $this->allowancesMock->shouldReceive('getPersonalAllowance')->andReturn(10000);
        $this->allowancesMock->shouldReceive('getHighEarnerThreshold')->andReturn(100000);
        $this->allowancesMock->shouldReceive('getAgeAllowanceThreshold')->andReturn(27000);
    }

    public function testPersonal()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(0);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(0.0);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $personalAllowance = $calculator->calculate();

        $this->assertEquals(10000, $personalAllowance);
    }

    public function testHighRateEarner()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(200000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(0);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(0.0);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $personalAllowance = $calculator->calculate();

        $this->assertEquals(0, $personalAllowance);
    }

    public function testBlind()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(0);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(true);
        $this->allowancesMock->shouldReceive('getBlindAllowance')->andReturn(2230);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(0.0);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $personalAllowance = $calculator->calculate();

        $this->assertEquals(12230, $personalAllowance);
    }

    public function test6574Allowance()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(20000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(65);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(10500);
        $this->allowancesMock->shouldReceive('getAgeAllowanceThreshold')->andReturn(27000);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $personalAllowance = $calculator->calculate();

        $this->assertEquals(10500, $personalAllowance);
    }

    public function test75OverWithReducedAllowance()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(75);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(10660);
        $this->allowancesMock->shouldReceive('getAgeAllowanceThreshold')->andReturn(27000);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $personalAllowance = $calculator->calculate();

        $this->assertEquals(10000, $personalAllowance);
    }

    public function testMarriedCouplesAllowance()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(20000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(75);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->employeeMock->shouldReceive('isMarried')->andReturn(true);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(10660);
        $this->allowancesMock->shouldReceive('getAgeAllowanceThreshold')->andReturn(27000);

        $this->allowancesMock->shouldReceive('getMarriageAllowanceMinAge')->andReturn(75);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceMin')->andReturn(3140);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceMax')->andReturn(8165);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceRate')->andReturn(0.1);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $mca = $calculator->calculateMarriedCouplesAllowance();

        $this->assertEquals(816.5, $mca);
    }

    public function testReducedMarriedCouplesAllowance()
    {
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->employeeMock->shouldReceive('getAge')->andReturn(75);
        $this->employeeMock->shouldReceive('isBlind')->andReturn(false);
        $this->employeeMock->shouldReceive('isMarried')->andReturn(true);
        $this->allowancesMock->shouldReceive('getAgeBandAllowance')->andReturn(10660);
        $this->allowancesMock->shouldReceive('getAgeAllowanceThreshold')->andReturn(27000);

        $this->allowancesMock->shouldReceive('getMarriageAllowanceMinAge')->andReturn(75);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceMin')->andReturn(3140);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceMax')->andReturn(8165);
        $this->allowancesMock->shouldReceive('getMarriageAllowanceRate')->andReturn(0.1);

        $calculator = new Calculator\AllowancesCalculator($this->employeeMock, $this->salaryMock, $this->allowancesMock);
        $mca = $calculator->calculateMarriedCouplesAllowance();

        $this->assertEquals(732.5, $mca);
    }
}
