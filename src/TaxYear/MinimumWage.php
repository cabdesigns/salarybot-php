<?php

namespace SalaryBotUk\TaxYear;

class MinimumWage
{

    /**
     * Array of minimum wage band objects
     * @var array
     */
    private $bands = [];

    /**
     * Set the minimum wage bands
     * @param mixed
     */
    public function __construct($minimumWageBands)
    {
        $this->bands = $minimumWageBands;
    }

    /**
     * Return the minimum wage bands
     * @return mixed
     */
    public function getBands()
    {
        return $this->bands;
    }
}
