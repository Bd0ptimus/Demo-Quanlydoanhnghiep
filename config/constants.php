<?php

const QRCODE_SIZE = 100; //px
//product item status
const ITEM_SOLD = 1;
const ITEM_NOT_SOLD = 0;
const ITEM_IN_INVOICE=2;
//check out status
const CHECKOUT_PENDING=0;
const CHECKOUT_DONE=1;
const CHECKOUT_REMOVED=3;

//Roles
const ROLE_CHEF = 1;
const ROLE_MANAGER=2;
const ROLE_STAFF = 3;
const ROLE_TECH_ADMIN = 4;



//staff shift
const SHIFT_MORNING=0;
const SHIFT_AFTERNOON = 1;
const SHIFT_EVENING=2;

const SHIFT_TEXT=[
    'Ca Sáng',
    'Ca Chiều',
    'Ca Tối',
];

//type contract
const FULL_TIME=0;
const PART_TIME=1;
const CONTRACT_TEXT = [
    'Toàn thời gian',
    'Bán thời gian',
];

//account status
const ACC_ACTIVATED=1;
const ACC_SUSPENDED=0;

const ACC_STATUS_TEXT=[
    'Đã đình chỉ',
    'Đã kích hoạt',
];

//shift index
const MORNING_SHIFT=1;
const AFTERNOON_SHIFT = 2;
const EVENING_SHIFT=3;

const MORNING_SHIFT_START='08:00';
const MORNING_SHIFT_END='12:00';
const AFTERNOON_SHIFT_START='14:00';
const AFTERNOON_SHIFT_END='18:00';
const EVENING_SHIFT_START='18:00';
const EVENING_SHIFT_END='22:00';

const START_SHIFT = 1;
const END_SHIFT=2;

//Statistic
const STATISTIC_FOLLOW_MONTH = 1;
const STATISTIC_FOLLOW_YEAR = 2;
const DATE_START_TRACKING_MONTH = '01/02/2023';
const DATE_START_TRACKING_YEAR = '01/01/2022';


//Costs
const FIXED_COST= 1;
const VARIABLE_COST=2;

//Promotion Program
const DISCOUNT_PRODUCT=1;
const DISCOUNT_PROGRAM=2;
const COMBO=3;
const FLASH_SALE=4;

//Discount product
const DISCOUNT_WITH_PERCENT=1;
const DISCOUNT_WITH_FIXED_PRICE=2;


//Product page
//Tabs id
const WAREHOUSE_TAB=1;
const CATEGORY_TAB=2;
const PRODUCT_TAB=3;

//Cost Page
const COST_TAB = 4;
const COSTLIST_TAB = 5;


