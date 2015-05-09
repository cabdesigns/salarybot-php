<?php

require_once('../vendor/autoload.php');

use SalaryBotUk\Employee as Employee;
use SalaryBotUk\TaxYear as TaxYear;
use SalaryBotUk\SalaryCalculator as Calculator;

// Setup tax year
$taxYearData = json_decode(file_get_contents('../tests/stubs/tax-year.json'));
$taxYear = new TaxYear\TaxYear($taxYearData);
$allowances = $taxYear->getAllowances();
$taxBands = $taxYear->getTaxBands();
$niBands = $taxYear->getNationalInsurance();
$studentLoan = $taxYear->getStudentLoan();
$minimumWage = $taxYear->getMinimumWage();


// Setup employee
$employee = new Employee\Employee;
$employee->setAge(18);
$employee->setHoursPerDay(7.5);
$employee->setDaysPerWeek(5);
$employee->setPensionContribution(1);
$employee->setStudentLoanType('p1');
$employee->setMarried(false);
$employee->setBlind(false);
$employee->setPensioner(false);

$salary = new Employee\Salary($employee);
$salary->setSalary(30000);
$salary->setAnnualBonus(0);
$salary->setAnnualAllowances(0);
$salary->setFrequency(Employee\Salary::FREQ_YEAR);

// Setup calculators
$allowancesCalculator = new Calculator\AllowancesCalculator($employee, $salary, $allowances);
$minimumWageCalculator = new Calculator\MinimumWageCalculator($employee, $salary, $minimumWage);
$niCalculator = new Calculator\NationalInsuranceCalculator($employee, $salary, $niBands);
$pensionContribCalculator = new Calculator\PensionContribCalculator($employee, $salary);
$studentLoanCalculator = new Calculator\StudentLoanCalculator($employee, $salary, $studentLoan);

$taxCalculator = new Calculator\TaxCalculator($salary, $taxBands);
$taxCalculator->setAllowancesCalculator($allowancesCalculator);

$netIncomeCalculator = new Calculator\NetIncomeCalculator($salary);
$netIncomeCalculator->setTaxCalculator($taxCalculator);
$netIncomeCalculator->setNationalInsuranceCalculator($niCalculator);
$netIncomeCalculator->setPensionContribCalculator($pensionContribCalculator);
$netIncomeCalculator->setStudentLoanCalculator($studentLoanCalculator);


// Calculate!
echo '<h3>Employee</h3>';
echo 'Tax year: ' . $taxYear->getTaxYear() . '<br />';
echo 'Married: ' . ($employee->isMarried() ? 'Yes' : 'No') . '<br />';
echo 'Blind: ' . ($employee->isBlind() ? 'Yes' : 'No') . '<br />';
echo 'State pension age: ' . ($employee->isPensioner() ? 'Yes' : 'No') . '<br />';
echo 'Student loan: ' . ($employee->getStudentLoanType() ? $employee->getStudentLoanType() : 'No') . '<br />';
echo 'Pension contributions: ' . $employee->getPensionContribution() . '%<br />';
echo 'Age: ' . $employee->getAge() . '<br />';
echo 'Days per week: ' . $employee->getDaysPerWeek() . '<br />';
echo 'Hours per day: ' . $employee->getHoursPerDay() . '<br />';
echo 'Gross wage: &pound;' . $salary->getSalary() . ' per ' . $salary->getFrequency() . '<br />';

echo '<h3>Income and allowances</h3>';
echo 'Gross income: &pound;' . $salary->getGross('year') . '<br />';
echo 'Base salary: &pound;' . $salary->getSalary() . '<br />';
echo 'Annual bonus: &pound;' . $salary->getAnnualBonus() . '<br />';
echo 'Other allowances: &pound;' . $salary->getAnnualAllowances() . '<br />';
echo 'Personal allowance: &pound;' . $allowancesCalculator->calculate() . '<br />';
echo 'Taxable income: &pound;' . $taxCalculator->calculateTaxable() . '<br />';
echo 'Is above minimum wage?: ' . ($minimumWageCalculator->calculate() ? 'Yes' : 'No') . '<br />';

echo '<h3>Income deductions</h3>';
echo 'Income tax: &pound;' . $taxCalculator->calculate() . '<br />';
echo 'National insurance: &pound;' . $niCalculator->calculate() . '<br />';
echo 'Student loan: &pound;' . $studentLoanCalculator->calculate() . '<br />';
echo 'Pension contributions (' . $employee->getPensionContribution() . '%): &pound;' . $pensionContribCalculator->calculate() . '<br />';

echo '<h3>Income summary</h3>';
echo 'Net income: &pound;' . $netIncomeCalculator->calculate() . '<br />';
