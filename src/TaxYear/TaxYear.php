<?php

namespace SalaryBotUk\TaxYear;

use SalaryBotUk\TaxYear as Year;

class TaxYear
{

    /**
     * The tax year
     * @var string
     */
    private $taxYear = '';

    /**
     * Personal allowances for the tax year
     * @var mixed
     */
    private $allowances = null;

    /**
     * Tax bands
     * @var mixed
     */
    private $taxBands = null;

    /**
     * National insurance rates
     * @var mixed
     */
    private $nationalInsurance = null;

    /**
     * Student loan rates
     * @var mixed
     */
    private $studentLoan = null;

    /**
     * Minimum wage rates
     * @var mixed
     */
    private $minimumWage = null;

    /**
     * Set the values for the tax year
     * @param mixed
     */
    public function __construct($taxYear)
    {

        $this->taxYear = $taxYear->taxYear;
        $this->allowances = new Year\Allowances($taxYear->allowances);
        $this->taxBands = new Year\TaxBands($taxYear->tax);
        $this->nationalInsurance = new Year\NationalInsurance($taxYear->nationalInsurance);
        $this->studentLoan = new Year\StudentLoan($taxYear->studentLoan);
        $this->minimumWage = new Year\MinimumWage($taxYear->minimumWage);

    }

    /**
     * Return the tax year
     * @return string
     */
    public function getTaxYear()
    {
        return $this->taxYear;
    }

    /**
     * Return the tax year allowances
     * @return \SalaryBotUk\TaxYear\Allowances
     */
    public function getAllowances()
    {
        return $this->allowances;
    }

    /**
     * Return the tax bands
     * @return \SalaryBotUk\TaxYear\TaxBands
     */
    public function getTaxBands()
    {
        return $this->taxBands;
    }

    /**
     * Return the national insurance
     * @return \SalaryBotUk\TaxYear\NationalInsurance
     */
    public function getNationalInsurance()
    {
        return $this->nationalInsurance;
    }

    /**
     * Return the student loan rates
     * @return \SalaryBotUk\TaxYear\StudentLoan
     */
    public function getStudentLoan()
    {
        return $this->studentLoan;
    }

    /**
     * Return the minimum wage rates
     * @return \SalaryBotUk\TaxYear\MinimumWage
     */
    public function getMinimumWage()
    {
        return $this->minimumWage;
    }

}
