<?php

namespace App\Containers\Admin\Models\Traits\methods;

use App\Enums\LogNameEnum;

trait AdminMethod
{
    /**
     * @param string $roleName
     * @return void
     */
    public function logCreated(string $roleName): void
    {
        activity()
            ->logCreated(__($this->email . ' is created with role ' . $roleName), $this, [
                'attributes' => ['role_name' => $roleName]
            ], LogNameEnum::ROLE);
    }

    /**
     * @param string $previousRoleName
     * @param string $currentRoleName
     * @return void
     */
    public function logUpdated(string $previousRoleName, string $currentRoleName): void
    {
        activity()
            ->logUpdated(__($this->email . ' is updated to role ' . $currentRoleName), $this, [
                'old' => ['role_name' => $previousRoleName],
                'attributes' => ['role_name' => $currentRoleName]
            ], LogNameEnum::ROLE);
    }
}
