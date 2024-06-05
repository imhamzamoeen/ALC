<?php

namespace App\Classes\Enums;

class StatusEnum
{
    public const Active = 'active';
    public const Inactive = 'inactive';
    public const Draft = 'draft';
    public const New = 'new';
    public const PENDING = 'pending';
    public const UNSCHEDULED = 'unscheduled';
    public const SCHEDULED = 'scheduled';
    public const RESCHEDULED = 'rescheduled';
    public const CANCELLED = 'cancelled';
    public const COMPLETED = 'completed';

    

    public const ChangeRequestPending = 'pending';
    public const ChangeRequestCompleted = 'completed';
    public const ChangeRequestCancelled = 'cancelled';
    public const ChangeRequestProgress = 'progress';

    public const SubscriptionCancelled = 'subscription_cancelled';
    public const SubscriptionActive = 'subscription_active';
    public const SubscriptionExtend = 'subscription_extend';
    public const NotSubscribed = 'not_subscribed';
    public const SubscriptionEnd = 'subscription_end';
    public const PausedSubscription = 'paused';

    public const TrialRequested = 'trial_requested';
    public const TrialSuccessful = 'trial_successful';
    public const TrialUnSuccessful = 'trial_unsuccessful';
    public const TrialScheduled = 'trial_scheduled';
    public const TrialUnScheduled = 'trial_unscheduled';
    public const TrialMissed = 'trial_missed';
    public const TrialRejected = 'trial_rejected';
    public const TrialRescheduled = 'trial_rescheduled';
    public const TrialValid = 'trial_valid';
    public const TrialInvalid = 'trial_invalid';
    public const RescheduleRequested = 'reschedule_requested';
    public const PaymentPending = 'payment_pending';

    /*Classes attendance Statuses*/
    public const UNATTENDED = 'unattended';
    public const ATTENDED = 'attended';
    public const PRESENT = 'present';
    public const ABSENT = 'absent';
    public const ONGOING = 'on_going';
    public const CLASSMISSED = 'class_missed';
    public const TEACHERABSENT = 'teacher_absent';

    public static $Statuses  =
    [
        self::Active,
        self::Inactive,
        self::PENDING,
        self::Draft
    ];

    public static $Attended_status_color =
    [
        self::ATTENDED      => 'success',
        self::PRESENT       => 'success',
        self::ABSENT        => 'danger',
        self::UNATTENDED    => 'warning',
        self::CLASSMISSED   => 'danger'
    ];

    public static $Classes_status_color =
    [
        self::SCHEDULED     => 'success',
        self::COMPLETED     => 'success',
        self::RESCHEDULED   => 'primary',
        self::CANCELLED     => 'danger',
        self::CLASSMISSED   => 'danger',
        self::TEACHERABSENT => 'danger',
        self::UNATTENDED => 'danger',
        self::ATTENDED => 'success',
    ];
    public static $Status_color  =
    [
        self::Active    => 'success',
        self::Inactive  => 'danger',
        self::PENDING   => 'warning',
        self::Draft     => 'dark'
    ];

    public static $Subscription_statuses  =
    [
        self::SubscriptionCancelled,
        self::SubscriptionActive,
        self::SubscriptionExtend,
        self::TrialScheduled,
        self::NotSubscribed
    ];

    public static $Trial_statuses =
    [
        self::TrialRequested,
        self::TrialScheduled,
        self::TrialSuccessful,
        self::TrialRescheduled,
        self::TrialMissed,
        self::TrialRejected
    ];
    public static $Valid_Trial_Status =
    [


        self::TrialSuccessful,
        self::TrialUnSuccessful,


    ];

    public static $Trials_With_Summary =
    [
        self::TrialSuccessful,
        self::TrialUnSuccessful,
        self::TrialMissed,
        self::TrialRescheduled,
        self::TrialInvalid
    ];

    public static $Subscription_status_color =
    [
        self::TrialRequested     => 'status-secondary',
        self::TrialScheduled     => 'status-primary',
        self::TrialSuccessful    => 'status-success',
        self::TrialMissed        => 'status-failed',
        self::TrialUnSuccessful  => 'status-failed',
        self::TrialRejected      => 'status-failed',
        self::TrialRescheduled   => 'status-warning',
        self::RescheduleRequested   => 'status-secondary',
        self::TrialInvalid       => 'status-failed',
        self::PaymentPending    => 'status-warning',
        self::SubscriptionActive => 'status-success',
        self::SubscriptionExtend => 'status-danger',
        self::SubscriptionEnd => 'status-danger'
    ];

    public static $subscription_bootstrap_colors =
    [
        self::TrialRequested     => 'danger',
        self::TrialScheduled     => 'primary',
        self::TrialSuccessful    => 'success',
        self::TrialMissed        => 'danger',
        self::TrialUnSuccessful  => 'danger',
        self::TrialRejected      => 'danger',
        self::TrialRescheduled   => 'info',
        self::TrialInvalid       => 'danger',
    ];

    public static $Basic_statuses =
    [
        self::Active,
        self::Inactive
    ];
}
