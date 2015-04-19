<?php

namespace SalaryBotUk\TaxYear;

class TaxBands {

    /**
     * Array of tax band objects
     * @var array
     */
    private $bands = [];

    /**
     * Set the tax bands
     * @param mixed
     */
    public function __construct($taxBands) {
        $this->bands = $taxBands;
    }

    /**
     * Get the band for a given identifier
     * @param  string
     * @return mixed
     */
    private function getBand($taxBandId) {
        return !empty($this->bands->$taxBandId) ? $this->bands->$taxBandId : null;
    }

    /**
     * Get the tax rate a given identifier
     * @param  string
     * @return float
     */
    public function getRate($taxBandId) {
        $band = $this->getBand($taxBandId);
        return $band ? $band->rate : 0.00;
    }

    /**
     * Get the minimum boundary for the tax band
     * @param  string
     * @return float
     */
    public function getMin($taxBandId) {
        $band = $this->getBand($taxBandId);
        return $band ? $band->min : 0.00;
    }

    /**
     * Get the maximum boundary for the tax band
     * @param  string
     * @return float
     */
    public function getMax($taxBandId) {
        $band = $this->getBand($taxBandId);
        return $band ? $band->max : 0.00;
    }

}
