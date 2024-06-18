<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $arr = array('billedDate'=>'billed_dated','paidDate'=>'paid_dated');
        foreach($arr as $key=>$a){
            if(array_key_exists($a,$data)){
                $data[$key] = $data[$a];
                unset($data[$a]);
            }
        }
        return $data;
    }
}
