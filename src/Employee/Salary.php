<?php

namespace SalaryBotUk\Employee;

class Salary
{

    const WEEKS_IN_YEAR = 52;
    const MONTHS_IN_YEAR = 12;

    const FREQ_HOUR = 'hour';
    const FREQ_DAY = 'day';
    const FREQ_WEEK = 'week';
    const FREQ_MONTH = 'month';
    const FREQ_YEAR = 'year';

    /**
     * Valid payment frequencies
     * @var array
     */
    private $validFrequencies = [
        self::FREQ_HOUR,
        self::FREQ_DAY,
        self::FREQ_WEEK,
        self::FREQ_MONTH,
        self::FREQ_YEAR
    ];

    /**
     * Base wage
     * @var float
     */
    private $salary = 0.0;

    /**
     * Wage frequency
     * @var string
     */
    private $frequency = self::FREQ_YEAR;

    /**
     * Annual bonus
     * @var float
     */
    private $annualBonus = 0.0;

    /**
     * Annual company allowances
     * @var float
     */
    private $annualAllowances = 0.0;

    /**
     * The employee this salary belongs to
     * @var mixed
     */
    private $employee = null;

    /**
     * Constructor
     * @param \SalaryBotUk\Employee\Employee $employee
     */
    public function __construct(\SalaryBotUk\Employee\Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the base salary for a specified frequency
     * @param  string $toFrequency
     * @return float
     */
    public function getBase($toFrequency)
    {
        $currentFrequency = $this->getFrequency();
        $frequencyIncome = $this->convert($this->getSalary(), $currentFrequency, $toFrequency);
        return $frequencyIncome;
    }

    /**
     * Get the gross income for a specified frequency
     * @param  string $toFrequency
     * @return float
     */
    public function getGross($toFrequency)
    {
        $currentFrequency = $this->getFrequency();
        $annualFrequency = self::FREQ_YEAR;

        $annualIncome = $this->convert($this->getSalary(), $currentFrequency, $annualFrequency);
        $annualIncome += $this->getAnnualBonus();
        $annualIncome += $this->getAnnualAllowances();

        $frequencyIncome = $this->convert($annualIncome, $annualFrequency, $toFrequency);

        return $frequencyIncome;
    }

    /**
     * Convert income from one frequency to another
     * @param  float $income
     * @param  string $fromFrequency
     * @param  string $toFrequency
     * @return float
     */
    public function convert($income, $fromFrequency, $toFrequency)
    {
        $annualIncome = $this->convertToAnnual($income, $fromFrequency);
        $frequencyIncome = $this->convertFromAnnual($annualIncome, $toFrequency);
        return $frequencyIncome;
    }

    /**
     * Convert income to an annual frequency
     * @param  float $income
     * @param  string $fromFrequency
     * @return float
     */
    private function convertToAnnual($income, $fromFrequency)
    {
        $hoursPerDay = $this->employee->getHoursPerDay();
        $daysPerWeek = $this->employee->getDaysPerWeek();

        switch ($fromFrequency) {
            case self::FREQ_HOUR:
                $annualIncome = $income * self::WEEKS_IN_YEAR * $daysPerWeek * $hoursPerDay;
                break;
            case self::FREQ_DAY:
                $annualIncome = $income * self::WEEKS_IN_YEAR * $daysPerWeek;
                break;
            case self::FREQ_WEEK:
                $annualIncome = $income * self::WEEKS_IN_YEAR;
                break;
            case self::FREQ_MONTH:
                $annualIncome = $income * self::MONTHS_IN_YEAR;
                break;
            default:
                $annualIncome = $income;
        }

        return $annualIncome;
    }

    /**
     * Convert income from an annual frequency to another frequency
     * @param  float $annualIncome
     * @param  string $toFrequency
     * @return float
     */
    private function convertFromAnnual($annualIncome, $toFrequency)
    {
        $hoursPerDay = $this->employee->getHoursPerDay();
        $daysPerWeek = $this->employee->getDaysPerWeek();

        switch ($toFrequency) {
            case self::FREQ_HOUR:
                $frequencyIncome = $annualIncome / self::WEEKS_IN_YEAR / $daysPerWeek / $hoursPerDay;
                break;
            case self::FREQ_DAY:
                $frequencyIncome = $annualIncome / self::WEEKS_IN_YEAR / $daysPerWeek;
                break;
            case self::FREQ_WEEK:
                $frequencyIncome = $annualIncome / self::WEEKS_IN_YEAR;
                break;
            case self::FREQ_MONTH:
                $frequencyIncome = $annualIncome / self::MONTHS_IN_YEAR;
                break;
            default:
                $frequencyIncome = $annualIncome;
        }

        return $frequencyIncome;
    }

    /**
     * Get the base wage
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set the base wage
     * @param float $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * Get the wage frequency
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set the wage frequency
     * @param string $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = in_array($frequency, $this->validFrequencies) ? $frequency : self::FREQ_YEAR;
    }

    /**
     * Get the annual bonus
     * @return float
     */
    public function getAnnualBonus()
    {
        return $this->annualBonus;
    }

    /**
     * Set the annual bonus
     * @param float $annualBonus
     */
    public function setAnnualBonus($annualBonus)
    {
        $this->annualBonus = $annualBonus;
    }

    /**
     * Get the annual company allowance
     * @return float
     */
    public function getAnnualAllowances()
    {
        return $this->annualAllowances;
    }

    /**
     * Set the annual company allowance
     * @param float $annualAllowances
     */
    public function setAnnualAllowances($annualAllowances)
    {
        $this->annualAllowances = $annualAllowances;
    }
}
