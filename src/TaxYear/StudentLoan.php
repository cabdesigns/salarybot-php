<?php

namespace SalaryBotUk\TaxYear;

class StudentLoan {

	/**
	 * The student loan repayment rate
	 * @var float
	 */
    private $rate = 0.0;

    /**
     * The different student loan thresholds
     * @var mixed
     */
    private $thresholds = [];

    /**
     * Set the student loan
     * @param mixed
     */
    public function __construct($studentLoan) {
    	$this->rate = $studentLoan->rate;
    	$this->thresholds = $studentLoan->thresholds;
    }

    /**
     * Get the student loan repayment rate
     * @return float
     */
    public function getRate() {
    	return $this->rate;
    }

    /**
     * Get the threshold for a given student loan type
     * @param  string
     * @return float
     * @throws Exception
     */
    public function getThreshold($studentLoanType) {
    	if (isset($this->thresholds->$studentLoanType)) {
    		return $this->thresholds->$studentLoanType;
    	} else {
    		throw new \Exception("Invalid student loan type specified.", 1);
    	}
    }

}
