<?php

namespace UCS\Component\TimeSheet\Validator;

/* Imports */
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationRuleInterface;


class HoursPerDay implements TimeSheetValidationRuleInterface
{
    /**
   *
       * @var int
       */
    const HOURS = 7;

    /**
     *
     * @var int
     */
    private $hours;
    
    /**
     *
     * @param int $hours
     */
    public function __construct($hours = null)
    {
        $this->hours = $hours ? $hours : self::HOURS;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hours_per_day';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(TimeSheetValidationContext $validationContext)
    {
        $timeSheet = $validationContext->getTimeSheet();
        foreach ($timeSheet->getEntries() as $entry) {
            if($entry->getDuration() > $this->hours) {
                return false;
            }
        }

        return true;
    }
}