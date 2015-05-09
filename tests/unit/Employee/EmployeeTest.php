<?php

class EmployeeTest extends PHPUnit_Framework_TestCase
{

    public function testDaysPerWeek()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setDaysPerWeek(1);
        $this->assertEquals(1, $employee->getDaysPerWeek());
    }

    public function testHoursPerDay()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setHoursPerDay(5);
        $this->assertEquals(5, $employee->getHoursPerDay());
    }

    public function testAge()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setAge(75);
        $this->assertEquals(75, $employee->getAge());
    }

    public function testPensionContribution()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setPensionContribution(2);
        $this->assertEquals(2, $employee->getPensionContribution());
    }

    public function testStudentLoanType()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setStudentLoanType('p2');
        $this->assertEquals('p2', $employee->getStudentLoanType());
    }

    public function testMarriedAllowance()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setMarried(true);
        $this->assertEquals(true, $employee->isMarried());
    }

    public function testBlindAllowance()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setBlind(true);
        $this->assertEquals(true, $employee->isBlind());
    }

    public function testPensioner()
    {
        $employee = new \SalaryBotUk\Employee\Employee();
        $employee->setPensioner(true);
        $this->assertEquals(true, $employee->isPensioner());
    }
}
