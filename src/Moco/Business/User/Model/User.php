<?php
declare(strict_types=1);

namespace Dreitier\Moco\Business\User\Model;

use Carbon\Carbon;
use Dreitier\Moco\Business\Timestamps;

class User
{
    public function __construct(
        public readonly UserId     $id,
        public readonly string     $firstname,
        public readonly string     $lastname,
        public readonly bool       $active,
        public readonly bool       $extern,
        public readonly string     $email,
        public readonly string     $mobilePhone,
        public readonly string     $workPhone,
        public readonly string     $homeAddress,
        public readonly string     $info,
        public readonly ?Carbon    $birthday,
        public readonly ?string     $avatarUrl,
        public readonly array      $tags,
        public readonly array      $customProperties,
        public readonly Unit       $unit,
        public readonly Timestamps $timestamps,
    )
    {

    }

    public static function unwrap($data)
    {
        return new User(
            id: new UserId($data->id),
            firstname: $data->firstname,
            lastname: $data->lastname,
            active: $data->active,
            extern: $data->extern,
            email: $data->email,
            mobilePhone: $data->mobile_phone,
            workPhone: $data->work_phone,
            homeAddress: $data->home_address,
            info: $data->info,
            birthday: $data->birthday ? Carbon::parse($data->birthday) : null,
            avatarUrl: $data->avatar_url,
            tags: $data->tags,
            customProperties: !empty($data->custom_properties) ? (array)$data->custom_properties : [],
            unit: Unit::unwrap($data->unit),
            timestamps: Timestamps::unwrap($data),
        );
    }
}
