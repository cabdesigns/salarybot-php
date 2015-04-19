<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class SalaryCalculator
{

    /**
     * The employee's salary
     * @var null
     */
    private $salary = null;

    private $taxYear = null;

    public function __construct(Employee\Salary $salary, TaxYear\TaxYear $taxYear)
    {
        $this->salary = $salary;
        $this->taxYear = $taxYear;
    }

}
