<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class StudentLoanCalculator
{

    /**
     * The employee
     * @var mixed
     */
    private $employee = null;

    /**
     * The employee's salary
     * @var mixed
     */
    private $salary = null;

    /**
     * The student loan options available for this tax year
     * @var null
     */
    private $studentLoan = null;

    /**
     * Constructor
     * @param Employee\Employee   $employee
     * @param Employee\Salary     $salary
     * @param TaxYear\StudentLoan $studentLoan
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary, TaxYear\StudentLoan $studentLoan)
    {
        $this->employee = $employee;
        $this->salary = $salary;
        $this->studentLoan = $studentLoan;
    }

    /**
     * Calculate the student loan repayment owed
     * @return float
     */
    public function calculate()
    {
        $studentLoan = 0.00;
        $grossSalary = $this->salary->getGross('year');
        $studentLoanType = $this->employee->getStudentLoanType();

        if (!$studentLoanType) {
            return $studentLoan;
        }

        $studentLoanThreshold = $this->studentLoan->getThreshold($studentLoanType);

        if ($grossSalary > $studentLoanThreshold) {
            $deductableSalary = $grossSalary - $studentLoanThreshold;
            $studentLoan = $deductableSalary * $this->studentLoan->getRate();
        }

        return $studentLoan;
    }

}

