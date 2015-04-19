<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class TaxCalculator
{

    /**
     * The employee's salary
     * @var mixed
     */
    private $salary = null;

    /**
     * The tax bands for this tax year
     * @var mixed
     */
    private $taxBands = null;

    /**
     * The allowance calculator
     * @var mixed
     */
    private $allowancesCalculator = null;

    /**
     * Constructor
     * @param Employee\Salary  $salary   [description]
     * @param TaxYear\TaxBands $taxBands [description]
     */
    public function __construct(Employee\Salary $salary, TaxYear\TaxBands $taxBands)
    {
        $this->salary = $salary;
        $this->taxBands = $taxBands;
    }

    /**
     * Calculate the income tax owed
     * @return float
     */
    public function calculate()
    {
        $tax = 0;
        $tax += $this->calculateBand('basic');
        $tax += $this->calculateBand('higher');
        $tax += $this->calculateBand('additional');
        $tax -= $this->allowancesCalculator->calculateMarriedCouplesAllowance();
        return $tax;
    }

    /**
     * Calculate the income tax owed for a particular tax band
     * @param  string $band
     * @return float
     */
    public function calculateBand($band)
    {
        $tax = 0.0;
        $taxableIncome = $this->calculateTaxable();

        $bandRate = $this->taxBands->getRate($band);
        $bandMin = $this->taxBands->getMin($band);
        $bandMax = $this->taxBands->getMax($band);

        if (!$bandRate) {
            return $tax;
        }

        if ($taxableIncome > $bandMin) {

            if ($bandMax && $taxableIncome > $bandMax) {

                $incomeWithinBand = $bandMax - $bandMin;

            } else {

                $incomeWithinBand = $taxableIncome - $bandMin;

            }

            $tax = $incomeWithinBand * $bandRate;

        }

        return $tax;
    }

    /**
     * Calculate how much of the income is taxable
     * @return float
     */
    public function calculateTaxable()
    {
        $grossIncome = $this->salary->getGross('year');
        $personalAllowance = $this->allowancesCalculator->calculate();
        $taxable = $grossIncome - $personalAllowance;
        return $taxable > 0 ? $taxable : 0.0;
    }

    /**
     * Set the allowances calculator
     * @param Calculator\AllowancesCalculator $allowancesCalculator
     */
    public function setAllowancesCalculator(Calculator\AllowancesCalculator $allowancesCalculator)
    {
        $this->allowancesCalculator = $allowancesCalculator;
    }

}
