<?php

namespace UCS\Component\TimeSheet\Tests\Validator;

use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\HoursPerDay;
use UCS\Component\TimeSheet\TimeSheet;
use UCS\Component\TimeSheet\TimeEntry;

/**
 * Class HoursPerDayTest.
 */
class HoursPerDayTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var HoursPerDay
	 */ 
	private $hoursPerDay;
	
	/**
     * {@inheritdoc}
     */
	public function setUp()
	{
		$this->hoursPerDay = new HoursPerDay(4);
	}
	
	/**
     * Test getName
     */
    public function testGetName()
    {
		$this->assertSame('hours_per_day', $this->hoursPerDay->getName());
    }
	
	/**
     * Test validate with valid time sheet
     */
	public function testValidateValidTimeSheet()
	{
		$timeEntry = new TimeEntry();
		$timeEntry->setDuration(4);
		
		$timeSheet = new TimeSheet();
		$timeSheet->addEntry($timeEntry);
				
		$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
		$timeSheetValidationContext = new TimeSheetValidationContext($translator, 'FR', $timeSheet);
				
		$this->assertTrue($this->hoursPerDay->validate($timeSheetValidationContext));
	}
	
	/**
     * Test validate with invvalid time sheet
     */
	public function testValidateInValidTimeSheet()
	{
		$timeEntry = new TimeEntry();
		$timeEntry->setDuration(8);
		
		$timeSheet = new TimeSheet();
		$timeSheet->addEntry($timeEntry);
				
		$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
		$timeSheetValidationContext = new TimeSheetValidationContext($translator, 'FR', $timeSheet);
				
				
		$this->assertFalse($this->hoursPerDay->validate($timeSheetValidationContext));
	}
}