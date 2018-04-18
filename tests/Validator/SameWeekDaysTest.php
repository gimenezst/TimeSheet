<?php

namespace UCS\Component\TimeSheet\Tests\Validator;

use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\SameWeekDays;
use UCS\Component\TimeSheet\TimeSheet;
use UCS\Component\TimeSheet\TimeEntry;

/**
 * Class SameWeekDaysTest.
 */
class SameWeekDaysTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var SameWeekDays
	 */ 
	private $sameWeekDays;
	
	/**
     * {@inheritdoc}
     */
	public function setUp()
	{
		$this->sameWeekDays = new SameWeekDays();
	}
	
	/**
     * Test getName
     */
    public function testGetName()
    {
		$this->assertSame('same_week_days', $this->sameWeekDays->getName());
    }
	
	/**
     * Test validate with valid time sheet
     */
	public function testValidateValidTimeSheet()
	{
		$timeEntry1 = new TimeEntry();
		$timeEntry1->setDate(new \DateTime('2018-01-01'));
		
		$timeEntry2 = new TimeEntry();
		$timeEntry2->setDate(new \DateTime('2018-01-02'));
		
		$timeSheet = new TimeSheet();
		$timeSheet->addEntry($timeEntry1)->addEntry($timeEntry2);
				
		$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
		$timeSheetValidationContext = new TimeSheetValidationContext($translator, 'FR', $timeSheet);
				
		$this->assertTrue($this->sameWeekDays->validate($timeSheetValidationContext));
	}
	
	/**
     * Test validate with invvalid time sheet
     */
	public function testValidateInValidTimeSheet()
	{
		$timeEntry1 = new TimeEntry();
		$timeEntry1->setDate(new \DateTime('2018-01-01'));
		
		$timeEntry2 = new TimeEntry();
		$timeEntry2->setDate(new \DateTime('2018-12-01'));
		
		$timeSheet = new TimeSheet();
		$timeSheet->addEntry($timeEntry1)->addEntry($timeEntry2);
				
		$translator = $this->getMock('Symfony\Component\Translation\TranslatorInterface');
		$timeSheetValidationContext = new TimeSheetValidationContext($translator, 'FR', $timeSheet);
				
				
		$this->assertFalse($this->sameWeekDays->validate($timeSheetValidationContext));
	}
}