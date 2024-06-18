<?php

namespace App\Filters;
use Illuminate\Http\Request;
class ApiFilter
{
    protected $safeParams = []; 

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request){
        $eloQuery = [];
        foreach($this->safeParams as $param => $operators){
            $query = $request->query($param); //e.g postalCode[gt]
            if(!isset($query)){
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach($operators as $op){
                if(isset($query[$op])){
                    $eloQuery[] = [$column,$this->operatorMap[$op],$query[$op]];
                }
            }
        }
        return $eloQuery;
    }
}
