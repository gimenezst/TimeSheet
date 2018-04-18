<?php

namespace UCS\Component\TimeSheet\Validator;

/* Imports */
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationRuleInterface;


class SameWeekDays implements TimeSheetValidationRuleInterface
{
    /**
     *
     * @var string
     */
    private $weekNumber;

    /**
     *
     * @param string $pattern
     */
    public function __construct()
    {
        $this->weekNumber = date("W");
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'same_week_days';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(TimeSheetValidationContext $validationContext)
    {
	$timeSheet = $validationContext->timeSheet;
        foreach ($timeSheet->getEntries() as $entry) {
            if(date("W", $entry->getDate()) != $this->weekNumber){
                return false;
            }
        }

        return true;
    }
}