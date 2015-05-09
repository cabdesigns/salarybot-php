<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;
use SalaryBotUk\TaxYear as TaxYear;

abstract class AbstractBandsCalculator
{

    /**
     * The employee's salary
     * @var Employee\Salary
     */
    protected $salary;

    /**
     * The bands for this tax year
     * @var TaxYear\Bands
     */
    protected $bands;

    /**
     * Calculate the total deductions
     * @return float
     */
    abstract public function calculate();

    /**
     * Get the source of income to make deducations against
     * @return float
     */
    abstract protected function getDeductableIncome();

    /**
     * Constructor
     * @param Employee\Salary  $salary
     * @param TaxYear\Bands $bands
     */
    public function __construct(Employee\Salary $salary, TaxYear\Bands $bands)
    {
        $this->salary = $salary;
        $this->bands = $bands;
    }

    /**
     * Calculate the deductions for a particular deductable band
     * @param  string $band
     * @return float
     */
    public function calculateBand($band)
    {
        $deductable = 0.0;
        $income = $this->getDeductableIncome();

        $bandRate = $this->bands->getRate($band);
        $bandMin = $this->bands->getMin($band);
        $bandMax = $this->bands->getMax($band);

        if (!$bandRate) {
            return $deductable;
        }

        if ($income > $bandMin) {
            if ($bandMax && $income > $bandMax) {
                $incomeWithinBand = $bandMax - $bandMin;
            } else {
                $incomeWithinBand = $income - $bandMin;
            }

            $deductable = $incomeWithinBand * $bandRate;
        }

        return $deductable;
    }
}
