<?php

namespace Serverfireteam\Panel\Database\Seeds;

use Illuminate\Database\Seeder;

use Serverfireteam\Panel\Admin;

class AdminSeeder extends Seeder{
    
    public function run(){

        $users = array(
            [
                'first_name' => 'XFactor',
                'last_name' => 'Admin',
                'email' => 'support@xfactoradvertising.com',
                'password' => 'pass3fish',
            ],
            [
                'first_name' => 'Josh',
                'last_name' => 'Guice',
                'email' => 'josh@wizory.com',
                'password' => 'jeer5-dearer',
            ],
        );

        foreach ($users as $user) {
            $admin = Admin::firstOrCreate(array(
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
            ));

            if ($admin->wasRecentlyCreated) {
                $admin->password = bcrypt($user['password']);
                $admin->save();
            }

        }
    }
}
