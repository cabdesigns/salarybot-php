<?php

namespace SalaryBotUk\TaxYear;

class NationalInsurance {

    /**
     * Array of national insurance bands
     * @var array
     */
    private $bands = [];

    /**
     * Set the national insurance bands
     * @param mixed
     */
    public function __construct($niBands) {
        $this->bands = $niBands;
    }

    /**
     * Get the band for a given identifier
     * @param  string
     * @return mixed
     */
    private function getBand($niBandId) {
        return !empty($this->bands->$niBandId) ? $this->bands->$niBandId : null;
    }

    /**
     * Get the national insurance rate a given identifier
     * @param  string
     * @return float
     */
    public function getRate($niBandId) {
        $band = $this->getBand($niBandId);
        return $band ? $band->rate : 0.00;
    }

    /**
     * Get the minimum boundary for the national insurance band
     * @param  string
     * @return float
     */
    public function getMin($niBandId) {
        $band = $this->getBand($niBandId);
        return $band ? $band->min : 0.00;
    }

    /**
     * Get the maximum boundary for the national insurance band
     * @param  string
     * @return float
     */
    public function getMax($niBandId) {
        $band = $this->getBand($niBandId);
        return $band ? $band->max : 0.00;
    }

}
