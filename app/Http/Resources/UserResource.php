<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        return [
            
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'password'=>$this->password,
            'upload_successful'=>$this->upload_successful,
            'disk'=>$this->disk,
            'create_dates'=>[
                'created_at_human'=>$this->created_at->diffForHumans(),
                'created_at' =>$this->created_at, 
            ],

            'update_dates'=>[
                'updated_at_human'=>$this->updated_at->diffForHumans(),
                'updated_at' =>$this->updated_at, 
            ]

        ];
    }
}
