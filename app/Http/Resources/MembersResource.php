<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MembersResource extends JsonResource
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
            'id'                    => $this->id,
            'username'              => $this->username,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
            'gender'                => $this->gender,
            'gender_name'           => $this->gender_name,
            'date_of_birth'         => $this->date_of_birth,
            'education'             => $this->education,
            'about'                 => $this->about,
            'religion'              => $this->religion,
            'age'                   => $this->age,
            'height'                => $this->height,
            'thumb_path'            => $this->thumb_path,
            'religion_name'         => $this->religion_name,
            'work'                  => $this->work,
            'status'                => $this->status,
            'partner_gender_name'   => $this->partner_gender_name,
            'partner_min_age'       => $this->partner_min_age,
            'partner_max_age'       => $this->partner_max_age,
            'height_feet'           => $this->height_feet,
            'height_inches'         => $this->height_inches,
            'city'              => $this->when($this->getCitiesByMember()!= null,
                                    new CitiesResource($this->getCitiesByMember)),
            'member_hobbies'    => $this->when($this->getMemberHobbiesByMember() != null,
                                    MemberHobbiesResource::collection($this->getMemberHobbiesByMember)),
            'gallery'           => $this->when($this->getMemberGalleryByMember() != null,
                                    GalleryResource::collection($this->getMemberGalleryByMember)),
            'invited_members'   => $this->when($this->getDateRequestMember() != null,
                                    DateRequestResource::collection($this->getDateRequestMember)),
            'accepted_members'  => $this->when($this->getDateReceivedMember() != null,
                                    DateReceiveResource::collection($this->getDateReceivedMember)),
        ];
    }
}