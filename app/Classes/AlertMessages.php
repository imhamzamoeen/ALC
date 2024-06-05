<?php
namespace App\Classes;

class AlertMessages{
    public const ERROR_500 = 'Something went wrong! Please try again';
    public const VALIDATION_ERROR = 'Error submitting! Please recheck your inputs';


    public const STUDENT_ADDED_SUCCESS = 'A new profile has been added successfully.';
    public const STUDENT_ADDED_FAILED = 'Error adding profile. Please try again!';
    public const STUDENT_LIMIT_EXCEEDED = 'The maximum profile limit has reached.';

    public const TEACHER_ASSIGNED_SUCCESS = 'Trial Request has been updated successfully';
    public const TEACHER_ASSIGNED_FAILED = 'Something went wrong. Please try again!';
    public const TRIAL_SIGNED_INVALID = 'Trial has been signed as invalid!';
    public const PIN_SETUP_SUCCESSFUL = 'Console PIN has been activated successfully';
    public const PIN_SETUP_UPDATED = 'Console PIN has been updated successfully';
    public const PIN_SUCCESSFUL = 'Console access has been granted.';
    public const PIN_RESET = 'Pin reset successful! Please check your email.';
    public const PIN_INVALID = 'Invalid Pin provided! Please try again.';
    public const STATS_NOT_FOUND = 'No Stats Found For Requested Month';
}
