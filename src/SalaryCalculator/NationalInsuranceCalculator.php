<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class NationalInsuranceCalculator
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
     * National insurance bands for the tax year
     * @var mixed
     */
    private $niBands = null;

    /**
     * Constructor
     * @param Employee\Employee         $employee
     * @param Employee\Salary           $salary
     * @param TaxYear\Bands $niBands
     */
    public function __construct(Employee\Employee $employee, Employee\Salary $salary, TaxYear\Bands $niBands)
    {
        $this->employee = $employee;
        $this->salary = $salary;
        $this->niBands = $niBands;
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
     * @param  string $niBand
     * @return float
     */
    public function calculateBand($niBand)
    {

        $deductable = 0.0;
        $income = $this->salary->getGross('year');

        $bandRate = $this->niBands->getRate($niBand);
        $bandMin = $this->niBands->getMin($niBand);
        $bandMax = $this->niBands->getMax($niBand);

        if ($this->employee->isPensioner() || !$bandRate) {
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
