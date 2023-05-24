<?php

namespace App\Constants;

class AppConstants
{
    const UNDEFINED_USER_TYPE = "UNDEFINED";
    const DEFAULT_USER_TYPE = "User";
    const ADMIN_USER_TYPE = "Admin"; // represents "Admin"

    const OTP_DEFAULT_LENGTH = 5;
    const MAX_PROFILE_PIC_SIZE = 2048;

    const MALE = 'Male';
    const FEMALE = 'Female';
    const OTHERS = 'Others';


    const GENDERS = [
        self::MALE,
        self::FEMALE,
        self::OTHERS,
    ];


    const GG_PROVIDER = 'google';
    const FB_PROVIDER = 'facebook';

    const PAGINATION_SIZE_WEB = 50;
    const CONTENT_TYPE = [
        "VIDEO" => "video",
        "AUDIO" => "audio",
        "YOUTUBE" => "youtube",
        "ARTICLE" => "article",
        "QUIZ" => "quiz",
    ];
    const QUIZ_STATUS = [
        "STARTED" => "started",
        "IN_PROGRESS" => "inprogress",
        "COMPLETED" => "completed",
    ];
}
