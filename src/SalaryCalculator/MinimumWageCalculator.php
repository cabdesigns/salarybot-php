<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;
use SalaryBotUk\TaxYear as TaxYear;
use SalaryBotUk\SalaryCalculator as Calculator;

class MinimumWageCalculator
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
     * The minimum wage for the tax year
     * @var mixed
     */
    private $minimumWage = null;

    /**
     * Constructor
     * @param Employee\Employee   $employee
     * @param Employee\Salary     $salary
     * @param TaxYear\MinimumWage $minimumWage
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary, TaxYear\MinimumWage $minimumWage)
    {
        $this->employee = $employee;
        $this->salary = $salary;
        $this->minimumWage = $minimumWage;
    }

    /**
     * Calculate if the salary is above or equal to minimum wage
     * @return boolean
     */
    public function calculate()
    {
        $age = $this->employee->getAge();

        if (!is_int($age)) {
            return true;
        }

        $gross = $this->salary->getGross('hour');
        $bands = $this->minimumWage->getBands();
        $minWage = 0;
        $greatestAgeBand = 0;

        foreach ($bands as $band) {
            if ($age >= $band->minAge && $band->minAge >= $greatestAgeBand) {
                $minWage = $band->minWage;
                $greatestAgeBand = $band->minAge;
            }
        }

        $isPaidMinimumWage = $gross >= $minWage;

        return $isPaidMinimumWage;
    }
}
