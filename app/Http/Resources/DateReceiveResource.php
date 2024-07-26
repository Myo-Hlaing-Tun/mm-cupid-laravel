<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DateReceiveResource extends JsonResource
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
            'invite_id' => $this->invite_id,
            'accept_id' => $this->accept_id,
            'status'    => $this->status,
            'details'   => $this->when($this->getMemberByInviteId() != null,
                            $this->getMemberByInviteId),
        ];
    }
}
