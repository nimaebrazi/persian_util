# PersianUtil
Persian util is simple PHP lib for persian developers.

## Extend
This library extend from:

[Jalali Date Format V2.65](http://jdf.scr.ir/)

## install via composer
```bash
composer require nimaebrazi/persian_util
```

| Method Example |      output   |      Description   |
| :-------------: | :-------------: | :-------------: |
| ```toPersianNumber(95)```  | ۹۵  | Integer number |
| ```toPersianNumber(125.36)```  | ۱۲۵٫۳۶ | Double number |
| ```toPersianNumber(125.36,'.')``` | ۱۲۵.۳۶ | Double number with change float symbol|
| - | - | - | - |
| ```toEnglishNumber(۹۵)```  | 95  | Integer or String number  |
| ```toEnglishNumber(۱۲۵٫۳۶)```  | 125.36 | Double or String number |
| - | - | - | - |
| ```getDay()```  | 2  | Return number of Jalali day  |
| ```getMonth()``` | 10 | Return number of Jalali month |
| ```getYear()``` | 1395 | Return number of Jalali year |
| ```getPersianDateFormat()```  | 1395/10/2  | Return string of Jalali day  |
| - | - | - | - |
| ```getDayWord(2)```  | دو  | Return string of Jalali day  |
| ```getMonthWord(2)``` | اردیبهشت | Return string of Jalali month |
| ```getYearWord(1395)``` | هزاروسیصدو نودوپنج | Return string of Jalali year |
| ```getSeasonWord(10)``` | زمستان | Return string of Jalali season of month |
| ```getDateWord('1395/2/15')``` | پانزده اردیبهشت هزار و سیصد و نود و پنج | Return string of Jalali date |
| - | - | - | - |
| ```isAfterToday('1395/11/2')```  | ('today is: 1395/12/1') false | Return bool  |
| ```isBeforeToday('1395/11/2')``` | ('today is: 1395/12/1') true | Return bool |
| ```isExpired('1395/11/2')``` | ('today is: 1395/12/1') true | Return bool |
| - | - | - | - |
| ```unixTimestampToJalali(1485342613)``` | 1486984213 | Return (string) jalali timestamp |
| ```unixTimestampToStrFormat(1485342613)``` | 2017-01-25 14:40:13 | Return string of gregorian date with Asia/Tehran timezone |
| ```gregorianToJalaliStrFormat(1485342613)``` | 1395/11/6 14:40:13  | Return (int) jalali time stamp |
