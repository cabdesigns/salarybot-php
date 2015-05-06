<?php

namespace SalaryBotUk\Employee;

class Employee
{

    /**
     * Age of employee
     * @var integer
     */
    private $age = 0;

    /**
     * Number of hours worked per day
     * @var float
     */
    private $hoursPerDay = 7.5;

    /**
     * Number of days per week worked
     * @var integer
     */
    private $daysPerWeek = 5;

    /**
     * Employee's pension contribution
     * @var float
     */
    private $pensionContribution = 0.0;

    /**
     * Employee's type of student loan
     * @var string
     */
    private $studentLoanType = '';

    /**
     * Is married
     * @var boolean
     */
    private $married = false;

    /**
     * Is registered as blind
     * @var boolean
     */
    private $blind = false;

    /**
     * Is state pension age
     * @var boolean
     */
    private $pensioner = false;

    /**
     * Get employee age
     * @return boolean
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set employee age
     * @param integer $age
     */
    public function setAge($age)
    {
        $this->age = is_int($age) ? $age : 0;
    }

    /**
     * Get hours per day worked
     * @return float
     */
    public function getHoursPerDay()
    {
        return $this->hoursPerDay;
    }

    /**
     * Set hours per day worked
     * @param float $hoursPerDay
     */
    public function setHoursPerDay($hoursPerDay)
    {
        $this->hoursPerDay = $hoursPerDay;
    }

    /**
     * Get days per week worked
     * @return integer
     */
    public function getDaysPerWeek()
    {
        return $this->daysPerWeek;
    }

    /**
     * Set days per week worked
     * @param integer $daysPerWeek
     */
    public function setDaysPerWeek($daysPerWeek)
    {
        $this->daysPerWeek = $daysPerWeek;
    }

    /**
     * Get pension contribution (percent)
     * @return float
     */
    public function getPensionContribution()
    {
        return $this->pensionContribution;
    }

    /**
     * Set pension contribution (percent)
     * @param float $pensionContribution
     */
    public function setPensionContribution($pensionContribution)
    {
        $this->pensionContribution = $pensionContribution;
    }

    /**
     * Get student loan type
     * @return string
     */
    public function getStudentLoanType()
    {
        return $this->studentLoanType;
    }

    /**
     * Set student loand type
     * @param string $studentLoanType
     */
    public function setStudentLoanType($studentLoanType)
    {
        $this->studentLoanType = $studentLoanType;
    }

    /**
     * Is married
     * @return boolean
     */
    public function isMarried()
    {
        return $this->married;
    }

    /**
     * Set married
     * @param boolean $isMarried
     */
    public function setMarried($isMarried)
    {
        $this->married = $isMarried;
    }

    /**
     * Is registered blind
     * @return boolean
     */
    public function isBlind()
    {
        return $this->blind;
    }

    /**
     * Set blind
     * @param boolean $isBlind
     */
    public function setBlind($isBlind)
    {
        $this->blind = $isBlind;
    }

    /**
     * Is stage pension age
     * @return boolean
     */
    public function isPensioner()
    {
        return $this->pensioner;
    }

    /**
     * Set pensioner
     * @param boolean $isPensioner
     */
    public function setPensioner($isPensioner)
    {
        $this->pensioner = $isPensioner;
    }

}
