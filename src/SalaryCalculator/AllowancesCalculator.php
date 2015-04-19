<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class AllowancesCalculator
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
     * The tax year allowances
     * @var mixed
     */
    private $allowances = null;

    /**
     * Constructor
     * @param Employee\Employee  $employee
     * @param Employee\Salary    $salary
     * @param TaxYear\Allowances $allowances
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary, TaxYear\Allowances $allowances)
    {
        $this->employee = $employee;
        $this->salary = $salary;
        $this->allowances = $allowances;
    }

    /**
     * Calculate the personal allowance for this employee
     * @return float
     */
    public function calculate()
    {
        $personalAllowance = $this->calculateByAge();
        $personalAllowance += $this->calculateBlind();
        $personalAllowance = $this->reduceHighEarnings($personalAllowance);
        return $personalAllowance;
    }

    /**
     * Calculate the personal allowance for this employee given any age related allowances
     * @return float
     */
    public function calculateByAge()
    {
    	$age = $this->employee->getAge();
        $gross = $this->salary->getGross('year');
    	$personalAllowance = $this->allowances->getPersonalAllowance();
        $ageAllowance = $this->allowances->getAgeBandAllowance($age);
        $ageAllowanceThreshold = $this->allowances->getAgeAllowanceThreshold();

        if ($ageAllowance) {
            $taxable = $gross - $ageAllowanceThreshold;
            $ageAllowance = ($gross > $ageAllowanceThreshold) ? $ageAllowance - ($taxable / 2) : $ageAllowance;
        }

        $personalAllowance = ($ageAllowance > $personalAllowance) ? $ageAllowance : $personalAllowance;

    	return $personalAllowance;
    }

    /**
     * Calculate any blind allowance due
     * @return float
     */
    public function calculateBlind()
    {
        $allowance = 0.0;

        if ($this->employee->isBlind()) {
        	$allowance = $this->allowances->getBlindAllowance();
        }

        return $allowance;
    }

    /**
     * Return a reduced personal allowance if the employee is a high earner
     * @param  float $personalAllowance
     * @return float
     */
    private function reduceHighEarnings($personalAllowance = 0.0)
    {

        if (!$this->isHighEarner()) {
            return $personalAllowance;
        }

        $gross = $this->salary->getGross('year');
        $highEarnerThreshold = $this->allowances->getHighEarnerThreshold();
        $reducedAllowance = $personalAllowance - (($gross - $highEarnerThreshold) / 2);
        $reducedAllowance = $reducedAllowance >= 0 ? $reducedAllowance : 0.0;

        return $reducedAllowance;
    }

    /**
     * Is the employee a high earner
     * @return boolean
     */
    private function isHighEarner()
    {
        return $this->salary->getGross('year') > $this->allowances->getHighEarnerThreshold();
    }

    /**
     * Calculate the married couples allowance to be offset against tax
     * @return float
     * @see http://www.which.co.uk/money/tax/guides/tax-in-retirement/married-couples-allowance/
     */
    public function calculateMarriedCouplesAllowance()
    {
        $mca = 0;
        $age = $age = $this->employee->getAge();
        $ageAllowance = $this->allowances->getAgeBandAllowance($age);
        $isMarried = $this->employee->isMarried();
        $minAge = $this->allowances->getMarriageAllowanceMinAge();

        if ($age >= $minAge && $isMarried) {

            $gross = $this->salary->getGross('year');
            $ageAllowanceThreshold = $this->allowances->getAgeAllowanceThreshold();

            $mcaMin = $this->allowances->getMarriageAllowanceMin();
            $mcaMax = $this->allowances->getMarriageAllowanceMax();
            $mcaRate = $this->allowances->getMarriageAllowanceRate();

            if ($gross <= $ageAllowanceThreshold) {
                $mca = $mcaRate * $mcaMax;
            } else {
                // MCA is reduced by £1 for every £2 of additional income above age allowance limit
                $taxable = $gross - $ageAllowanceThreshold;
                $diff = $taxable / 2;
                $leftOver = $diff - ($ageAllowance - $this->calculate());
                $taxableUnderMaxMCA = $mcaMax - $leftOver;

                $mcaMin = $mcaRate * $mcaMin;
                $reducedMCA = $mcaRate * $taxableUnderMaxMCA;

                $mca = ($reducedMCA > $mcaMin) ? $reducedMCA : $mcaMin;
            }
        }

        return $mca;
    }

}
