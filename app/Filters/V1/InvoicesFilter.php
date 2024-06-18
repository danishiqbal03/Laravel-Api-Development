<?php

namespace App\Filters\V1;
use App\Filters\ApiFilter;
class InvoicesFilter extends ApiFilter
{
    protected $safeParams = [
        'customer_id'=>['eq'],
        'amount'=>['eq','gt','lt'],
        'status'=>['eq','ne'],
        'billed_dated'=>['eq','gt','lt'],
        'paid_dated'=>['eq','gt','lt'],
    ]; 

    protected $columnMap = [
        'billedDate'=>'billed_dated',
        'paidDate'=>'paid_dated',
    ];

    protected $operatorMap = [
        'eq'=>'=',
        'gt'=>'>',
        'lt'=>'<',
        'gte'=>'>=',
        'lte'=>'<=',
        'ne'=>'!='
    ];
}
