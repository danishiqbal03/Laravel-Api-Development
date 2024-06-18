<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\InvoiceResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Get the parent resource's array representation
        $data = parent::toArray($request);

        // Replace 'postal_code' with 'postalCode' if present
        if (array_key_exists('postal_code', $data)) {
            $data['postalCode'] = $data['postal_code'];
            unset($data['postal_code']); // Remove 'postal_code' from the array
        }


        $data['invoices'] = InvoiceResource::collection($this->whenLoaded('invoices'));
        

        return $data;
    }
}
