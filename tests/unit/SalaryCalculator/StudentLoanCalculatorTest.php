<?php

use SalaryBotUk\SalaryCalculator as Calculator;

class StudentLoanCalculatorTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->employeeMock = \Mockery::mock('\SalaryBotUk\Employee\Employee');
        $this->salaryMock = \Mockery::mock('\SalaryBotUk\Employee\Salary');
        $this->studentLoanMock = \Mockery::mock('\SalaryBotUk\TaxYear\StudentLoan');
    }

    public function testP1Loan()
    {
        $this->employeeMock->shouldReceive('getStudentLoanType')->andReturn('p1');
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);
        $this->studentLoanMock->shouldReceive('getThreshold')->andReturn(16910);
        $this->studentLoanMock->shouldReceive('getRate')->andReturn(0.09);

        $calculator = new Calculator\StudentLoanCalculator($this->employeeMock, $this->salaryMock, $this->studentLoanMock);
        $studentLoan = $calculator->calculate();

        $this->assertEquals(1178.10, $studentLoan);
    }

    public function testNoLoan()
    {
        $this->employeeMock->shouldReceive('getStudentLoanType')->andReturn('');
        $this->salaryMock->shouldReceive('getGross')->andReturn(30000);

        $calculator = new Calculator\StudentLoanCalculator($this->employeeMock, $this->salaryMock, $this->studentLoanMock);
        $studentLoan = $calculator->calculate();

        $this->assertEquals(0, $studentLoan);
    }

}
