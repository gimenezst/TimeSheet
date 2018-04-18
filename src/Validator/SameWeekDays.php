<?php

namespace UCS\Component\TimeSheet\Validator;

/* Imports */
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationRuleInterface;


class SameWeekDays implements TimeSheetValidationRuleInterface
{
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
	$timeSheet = $validationContext->getTimeSheet();
	$weeks = [];
        foreach ($timeSheet->getEntries() as $entry) {
            if (!in_array($entry->getDate()->format('W'), $weeks)) {
		$weeks[] = $entry->getDate()->format('W');
            }
        }

        return count($weeks) <= 1;
    }
}