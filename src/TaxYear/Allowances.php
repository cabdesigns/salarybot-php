<?php

namespace SalaryBotUk\TaxYear;

class Allowances
{

    /**
     * Personal allowance
     * @var float
     */
    private $personal = 0.0;

    /**
     * High earner threshold where personal allowance begins to reduce
     * @var float
     */
    private $highEarnerThreshold = 0.0;

    /**
     * Other allowances
     * @var mixed
     */
    private $allowances = [
        'blind' => 0.0,
        'ageRelated' => [
            'max' => 0.0,
            'bands' => [
                '65-74' => 0.0,
                '75' => 0.0
            ]
        ],
        'marriedCouple' => [
            'min' => 0.0,
            'max' => 0.0,
            'rate' => 0.0
        ]
    ];

    /**
     * Set the allowances
     * @param mixed
     */
    public function __construct($allowances)
    {
        $this->personal = $allowances->personal;
        $this->highEarnerThreshold = $allowances->highEarnerThreshold;
        $this->allowances = $allowances->additional;
    }

    /**
     * Get personal allowance
     * @return float
     */
    public function getPersonalAllowance()
    {
        return $this->personal;
    }

    /**
     * Get the high earner threshold
     * @return float
     */
    public function getHighEarnerThreshold()
    {
        return $this->highEarnerThreshold;
    }

    /**
     * Get blind allowance
     * @return float
     */
    public function getBlindAllowance()
    {
        return $this->allowances->blind;
    }

    /**
     * Get age related allowance
     * @return mixed
     */
    private function getAgeRelated()
    {
        return $this->allowances->ageRelated;
    }

    /**
     * Get age related allowance for a given age band
     * @param  string
     * @return float
     */
    public function getAgeBandAllowance($age)
    {
        $allowance = 0.0;

        if (!is_int($age)) {
            return $allowance;
        }

        $ageBands = $this->getAgeRelated()->bands;
        $greatestAgeBand = 0;

        foreach ($ageBands as $band) {
            if ($age >= $band->minAge && $band->minAge >= $greatestAgeBand) {
                $allowance = $band->allowance;
                $greatestAgeBand = $band->minAge;
            }
        }

        return $allowance;
    }

    /**
     * Get age related allowance threshold before allowance begins to reduce
     * @return float
     */
    public function getAgeAllowanceThreshold()
    {
        return $this->getAgeRelated()->max;
    }

    /**
     * Get married couples allowance
     * @return mixed
     */
    private function getMarriageAllowance()
    {
        return $this->allowances->marriedCouple;
    }

    /**
     * Get minimum age that married couples allowance is applicable
     * @return integer
     */
    public function getMarriageAllowanceMinAge()
    {
        return $this->getMarriageAllowance()->minAge;
    }

    /**
     * Get married couples allowance minimum
     * @return float
     */
    public function getMarriageAllowanceMin()
    {
        return $this->getMarriageAllowance()->min;
    }

    /**
     * Get married couples allowance maximum
     * @return float
     */
    public function getMarriageAllowanceMax()
    {
        return $this->getMarriageAllowance()->max;
    }

    /**
     * Get married couples allowance rate
     * @return float
     */
    public function getMarriageAllowanceRate()
    {
        return $this->getMarriageAllowance()->rate;
    }
}
