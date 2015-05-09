<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;
use SalaryBotUk\SalaryCalculator as Calculator;

class PensionContribCalculator
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
     * Constructor
     * @param Employee\Employee $employee
     * @param Employee\Salary   $salary
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary)
    {
        $this->employee = $employee;
        $this->salary = $salary;
    }

    /**
     * Calculate the pension contribution to be paid
     * @return float
     */
    public function calculate()
    {
        $pensionPercent = $this->employee->getPensionContribution();
        $grossSalary = $this->salary->getBase('year');
        $pension = ($grossSalary / 100) * $pensionPercent;
        return $pension;
    }
}
