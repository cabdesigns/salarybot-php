<?php

namespace SalaryBotUk\SalaryCalculator;

use SalaryBotUk\Employee as Employee;

use SalaryBotUk\TaxYear as TaxYear;

use SalaryBotUk\SalaryCalculator as Calculator;

class NetIncomeCalculator
{

    /**
     * The employee's salary
     * @var Employee\Salary
     */
    private $salary;

    /**
     * The tax calculator
     * @var Calculator\TaxCalculator
     */
    private $taxCalculator;

    /**
     * The national insurance calculator
     * @var Calculator\NationalInsuranceCalculator
     */
    private $nationalInsuranceCalculator;

    /**
     * The student loan calculator
     * @var Calculator\StudentLoanCalculator
     */
    private $studentLoanCalculator;

    /**
     * The pension contribution calculator
     * @var Calculator\PensionContribCalculator
     */
    private $pensionContribCalculator;

    /**
     * Constructor
     * @param Employee\Salary $salary
     */
    public function __construct(Employee\Salary $salary)
    {
        $this->salary = $salary;
    }

    /**
     * Calculate the net income on this salary
     * @return float
     */
    public function calculate()
    {
        $grossIncome = $this->salary->getGross('year');
        $tax = $this->taxCalculator->calculate();
        $ni = $this->nationalInsuranceCalculator->calculate();
        $studentLoan = $this->studentLoanCalculator->calculate();
        $pensionContrib = $this->pensionContribCalculator->calculate();

        $deductions = $tax + $ni + $studentLoan + $pensionContrib;
        $netIncome = $grossIncome - $deductions;

        return $netIncome;
    }

    /**
     * Set the tax calculator
     * @param Calculator\TaxCalculator $taxCalculator
     */
    public function setTaxCalculator(Calculator\TaxCalculator $taxCalculator)
    {
        $this->taxCalculator = $taxCalculator;
    }

    /**
     * Set the national insurance calculator
     * @param Calculator\NationalInsuranceCalculator $nationalInsuranceCalculator
     */
    public function setNationalInsuranceCalculator(Calculator\NationalInsuranceCalculator $nationalInsuranceCalculator)
    {
        $this->nationalInsuranceCalculator = $nationalInsuranceCalculator;
    }

    /**
     * Set the student loan calculator
     * @param Calculator\StudentLoanCalculator $studentLoanCalculator
     */
    public function setStudentLoanCalculator(Calculator\StudentLoanCalculator $studentLoanCalculator)
    {
        $this->studentLoanCalculator = $studentLoanCalculator;
    }

    /**
     * Set the pension contribution calculator
     * @param Calculator\PensionContribCalculator $pensionContribCalculator
     */
    public function setPensionContribCalculator(Calculator\PensionContribCalculator $pensionContribCalculator)
    {
        $this->pensionContribCalculator = $pensionContribCalculator;
    }

}

