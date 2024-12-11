<?php

class UserRole
{
    public function userLabel($type)
    {
        $roles = [
            'expertise' => 'Ekspertiz',
            'repairman' => 'Usta',
            'car_owner' => 'Müşteri',
            'lawyer' => 'Avukat',
            'insurer' => 'Sigortacı',
            ''
        ];

        return isset($roles[$type]) ? $roles[$type] : 'Bilinmeyen Rol';
    }
}

$userRole = new UserRole();
echo $userRole->userLabel('expertise');
echo $userRole->userLabel('unknown');
