<?php

namespace App;

enum StatusEnum:string
{
    //
    case NEW='جديدة';
    case IN_PROGRESS = 'تحت التنفيذ';
    case PENDING = 'معلقة';
    case COMPLETED = 'مكتملة';


}
