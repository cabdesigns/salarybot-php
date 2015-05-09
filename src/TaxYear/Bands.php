<?php

namespace SalaryBotUk\TaxYear;

class Bands
{

    /**
     * Array of bands
     * @var array
     */
    private $bands = [];

    /**
     * Set the bands
     * @param mixed
     */
    public function __construct($bands)
    {
        $this->bands = $bands;
    }

    /**
     * Get the band for a given identifier
     * @param  string
     * @return mixed
     */
    private function getBand($bandId)
    {
        return !empty($this->bands->$bandId) ? $this->bands->$bandId : null;
    }

    /**
     * Get the band rate given an identifier
     * @param  string
     * @return float
     */
    public function getRate($bandId)
    {
        $band = $this->getBand($bandId);
        return $band ? $band->rate : 0.00;
    }

    /**
     * Get the minimum boundary for the band
     * @param  string
     * @return float
     */
    public function getMin($bandId)
    {
        $band = $this->getBand($bandId);
        return $band ? $band->min : 0.00;
    }

    /**
     * Get the maximum boundary for the band
     * @param  string
     * @return float
     */
    public function getMax($bandId)
    {
        $band = $this->getBand($bandId);
        return $band ? $band->max : 0.00;
    }
}
