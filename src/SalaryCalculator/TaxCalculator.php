<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\SalaryCalculator as Calculator;

class TaxCalculator extends Calculator\AbstractBandsCalculator
{

    /**
     * The allowance calculator
     * @var mixed
     */
    private $allowancesCalculator = null;

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
     * Get the source of income to make deducations against
     * @return float
     */
    protected function getDeductableIncome()
    {
        return $this->calculateTaxable();
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
