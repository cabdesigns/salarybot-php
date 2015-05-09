<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;
use SalaryBotUk\TaxYear as TaxYear;
use SalaryBotUk\SalaryCalculator as Calculator;

class NationalInsuranceCalculator extends Calculator\AbstractBandsCalculator
{

    /**
     * The employee
     * @var Employee\Employee
     */
    private $employee;

    /**
     * Constructor
     * @param Employee\Employee         $employee
     * @param Employee\Salary           $salary
     * @param TaxYear\Bands $bands
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary, TaxYear\Bands $bands)
    {
        $this->employee = $employee;
        parent::__construct($salary, $bands);
    }

    /**
     * Calculate the national insurance owed
     * @return float
     */
    public function calculate()
    {
        $nationalInsurance = 0.0;
        $nationalInsurance += $this->calculateBand('basic');
        $nationalInsurance += $this->calculateBand('higher');
        return $nationalInsurance;
    }

    /**
     * Calculate the national insurance owed for the specified band
     * @param  string $band
     * @return float
     */
    public function calculateBand($band)
    {
        $deductable = 0.0;

        if (!$this->employee->isPensioner()) {
            $deductable = parent::calculateBand($band);
        }

        return $deductable;
    }

    /**
     * Get the source of income to make deducations against
     * @return float
     */
    protected function getDeductableIncome()
    {
        return $this->salary->getGross('year');
    }
}
