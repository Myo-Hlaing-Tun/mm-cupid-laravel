<?php 
    namespace App;

    class Constants{
        public const COMPANY_NAME                               = "MM-cupid";
        public const ADMIN_ROLE                                 = 1;
        public const Editor_ROLE                                = 2;
        public const CUSTOMER_SERVICE_ROLE                      = 3;
        public const ADMIN_ENABLE_STATUS                        = 0;
        public const ADMIN_DISABLE_STATUS                       = 1;
        public const MEMBER_REGISTERED_STATUS                   = 0;
        public const MEMBER_EMAIL_CONFIRMED_STATUS              = 1;
        public const MEMBER_PENDING_PHOTO_VERIFICATION_STATUS   = 2;
        public const MEMBER_FAILED_PHOTO_VERIFICATION_STATUS    = 3;
        public const MEMBER_PHOTO_VERIFIED_STATUS               = 4;
        public const MEMBER_BANNED_STATUS                       = 5;
        public const THUMB_WIDTH                                = 150;
        public const THUMB_HEIGHT                               = 200;
        public const RECORDS_PER_PAGE                           = 9;
        public const PARTNER_GENDER_MALE                        = 1;
        public const PARTNER_GENDER_FEMALE                      = 2;
        public const PARTNER_GENDER_BOTH                        = 3;
        public const BUDDHISM_RELIGION                          = 1;
        public const CHRISTIAN_RELIGION                         = 2;
        public const ISLAM_RELIGION                             = 3;
        public const HINDUISM_RELIGION                          = 4;
        public const JAIN_RELIGION                              = 5;
        public const SHINTO_RELIGION                            = 6;
        public const ATHEISM_RELIGION                           = 7;
        public const OTHERS_RELIGION                            = 8;
        public const GENDER_MALE                                = 1;
        public const GENDER_FEMALE                              = 2;
        public const DATE_REQUEST_POINT                         = 300;
        public const DATE_REQUEST_SENT                          = 0;
        public const DATE_REQUEST_REJECTED                      = 1;
        public const DATE_REQUEST_ACCEPTED                      = 2;
        public const DATE_REQUEST_ADMIN_APPROVED                = 3;
        public const PURCHASE_SENT_STATUS                       = 0;
        public const PURCHASE_FAILED_STATUS                     = 1;
        public const PURCHASE_SUCCESS_STATUS                    = 2;
        public const PURCHASE1_MONEY                            = 10000;
        public const PURCHASE2_MONEY                            = 30000;
        public const PURCHASE3_MONEY                            = 50000;
        public const PURCHASE1_POINT                            = 1000;
        public const PURCHASE2_POINT                            = 3500;
        public const PURCHASE3_POINT                            = 6000;
        public const ADD_POINT                                  = 1;
        public const SUBTRACT_POINT                             = 2;
    }
?>