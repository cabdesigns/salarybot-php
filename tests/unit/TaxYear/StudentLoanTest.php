<?php
class StudentLoanTest extends PHPUnit_Framework_TestCase {

    public function testRate() {
        $data = $this->getStub();
        $studentLoan = new \SalaryBotUk\TaxYear\StudentLoan($data);
        $this->assertEquals(0.09, $studentLoan->getRate());
    }

    public function testThreshold() {
    	$data = $this->getStub();
        $studentLoan = new \SalaryBotUk\TaxYear\StudentLoan($data);
        $this->assertEquals(21000, $studentLoan->getThreshold('p2'));
    }

    public function testInvalidThreshold() {
        $this->setExpectedException('Exception');
        $data = $this->getStub();
        $studentLoan = new \SalaryBotUk\TaxYear\StudentLoan($data);
        $studentLoan->getThreshold('invalidStudentLoanType');
    }

    public function getStub() {
        $stubFile = dirname(__FILE__) . '/../../stubs/tax-year.json';
        $stub = json_decode(file_get_contents($stubFile));
        return $stub->studentLoan;
    }

}
