<?php

class SalaryTest extends PHPUnit_Framework_TestCase {

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
    }

    public function testGrossHourly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(1);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(1);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(10);
        $salary->setFrequency('hour');
        $salary->setAnnualBonus(20);
        $salary->setAnnualAllowances(10);

        $this->assertEquals(550, $salary->getGross('year'));
    }

    public function testGrossDaily()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(1);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(1);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(100);
        $salary->setFrequency('day');
        $salary->setAnnualBonus(200);
        $salary->setAnnualAllowances(100);

        $this->assertEquals(5500, $salary->getGross('year'));
    }

    public function testGrossWeekly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(100);
        $salary->setFrequency('week');
        $salary->setAnnualBonus(200);
        $salary->setAnnualAllowances(100);

        $this->assertEquals(5500, $salary->getGross('year'));
    }

    public function testGrossMonthly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(1000);
        $salary->setFrequency('month');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(18000, $salary->getGross('year'));
    }

    public function testGrossYearly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(30000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(36000, $salary->getGross('year'));
    }

    public function testSalaryConvertToYearly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(30000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(30000, $salary->getBase('year'));
    }

    public function testSalaryConvertToMonthly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(12000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(1000, $salary->getBase('month'));
    }

    public function testSalaryConvertToWeekly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(5);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(52000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(1000, $salary->getBase('week'));
    }

    public function testSalaryConvertToDaily()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(7.5);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(2);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(104000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(1000, $salary->getBase('day'));
    }

    public function testSalaryConvertToHourly()
    {
        $this->employeeMock->shouldReceive('getHoursPerDay')->andReturn(2);
        $this->employeeMock->shouldReceive('getDaysPerWeek')->andReturn(1);

        $salary = new \SalaryBotUk\Employee\Salary($this->employeeMock);
        $salary->setSalary(104000);
        $salary->setFrequency('year');
        $salary->setAnnualBonus(5000);
        $salary->setAnnualAllowances(1000);

        $this->assertEquals(1000, $salary->getBase('hour'));
    }

}
