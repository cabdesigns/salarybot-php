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
     * @var \SalaryBotUk\TaxYear\Allowances
     */
    private $allowances;

    /**
     * Tax bands
     * @var \SalaryBotUk\TaxYear\Bands
     */
    private $taxBands;

    /**
     * National insurance rates
     * @var \SalaryBotUk\TaxYear\Bands
     */
    private $nationalInsurance;

    /**
     * Student loan rates
     * @var \SalaryBotUk\TaxYear\StudentLoan
     */
    private $studentLoan;

    /**
     * Minimum wage rates
     * @var \SalaryBotUk\TaxYear\MinimumWage
     */
    private $minimumWage;

    /**
     * Set the values for the tax year
     * @param mixed
     */
    public function __construct($taxYear)
    {

        $this->taxYear = $taxYear->taxYear;
        $this->allowances = new Year\Allowances($taxYear->allowances);
        $this->taxBands = new Year\Bands($taxYear->tax);
        $this->nationalInsurance = new Year\Bands($taxYear->nationalInsurance);
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
     * @return \SalaryBotUk\TaxYear\Bands
     */
    public function getTaxBands()
    {
        return $this->taxBands;
    }

    /**
     * Return the national insurance
     * @return \SalaryBotUk\TaxYear\Bands
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
