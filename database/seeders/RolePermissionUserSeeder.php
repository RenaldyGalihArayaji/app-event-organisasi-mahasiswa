<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission

        // Dashboard
        Permission::create(['name' => 'Event-Active dashboard']);
        Permission::create(['name' => 'Event-Inactive dashboard']);
        Permission::create(['name' => 'Event-Waiting dashboard']);
        Permission::create(['name' => 'Event-Rejected dashboard']);
        Permission::create(['name' => 'Event-Approved dashboard']);
        Permission::create(['name' => 'Report-Waiting dashboard']);
        Permission::create(['name' => 'Report-Rejected dashboard']);
        Permission::create(['name' => 'Report-Approved dashboard']);

        // Event
        Permission::create(['name' => 'view event']);
        Permission::create(['name' => 'create event']);
        Permission::create(['name' => 'update event']);
        Permission::create(['name' => 'delete event']);
        Permission::create(['name' => 'show event']);
        Permission::create(['name' => 'update-khusus event']);

        // Report
        Permission::create(['name' => 'view report']);
        Permission::create(['name' => 'create report']);
        Permission::create(['name' => 'update report']);
        Permission::create(['name' => 'delete report']);
        Permission::create(['name' => 'show report']);
        Permission::create(['name' => 'update-khusus report']);

        // Sponsorship
        Permission::create(['name' => 'view sponsorship']);
        Permission::create(['name' => 'create sponsorship']);
        Permission::create(['name' => 'update sponsorship']);
        Permission::create(['name' => 'delete sponsorship']);
        Permission::create(['name' => 'show sponsorship']);

        // Category
        Permission::create(['name' => 'view category']);
        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'update category']);
        Permission::create(['name' => 'delete category']);

        // Organization
        Permission::create(['name' => 'view organization']);
        Permission::create(['name' => 'create organization']);
        Permission::create(['name' => 'update organization']);
        Permission::create(['name' => 'delete organization']);

        // Role
        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        // User
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);


        // Participant
        Permission::create(['name' => 'view participant']);
        Permission::create(['name' => 'delete participant']);


        // Setting
        Permission::create(['name' => 'update setting']);


        // Role To Permission
        Role::create(["name" => "super admin"]);
        $roleSuperAdmin = Role::findByName('super admin');

        // Dashboard
        $roleSuperAdmin->givePermissionTo('Event-Active dashboard');
        $roleSuperAdmin->givePermissionTo('Event-Inactive dashboard');
        $roleSuperAdmin->givePermissionTo('Event-Waiting dashboard');
        $roleSuperAdmin->givePermissionTo('Event-Rejected dashboard');
        $roleSuperAdmin->givePermissionTo('Event-Approved dashboard');
        $roleSuperAdmin->givePermissionTo('Report-Waiting dashboard');
        $roleSuperAdmin->givePermissionTo('Report-Rejected dashboard');
        $roleSuperAdmin->givePermissionTo('Report-Approved dashboard');

        // Role
        $roleSuperAdmin->givePermissionTo('view role');
        $roleSuperAdmin->givePermissionTo('create role');
        $roleSuperAdmin->givePermissionTo('update role');
        $roleSuperAdmin->givePermissionTo('delete role');

        // User
        $roleSuperAdmin->givePermissionTo('view user');
        $roleSuperAdmin->givePermissionTo('create user');
        $roleSuperAdmin->givePermissionTo('update user');
        $roleSuperAdmin->givePermissionTo('delete user');

        // Category
        $roleSuperAdmin->givePermissionTo('view category');
        $roleSuperAdmin->givePermissionTo('create category');
        $roleSuperAdmin->givePermissionTo('update category');
        $roleSuperAdmin->givePermissionTo('delete category');

        // Event
        $roleSuperAdmin->givePermissionTo('view event');
        $roleSuperAdmin->givePermissionTo('show event');
        $roleSuperAdmin->givePermissionTo('create event');
        $roleSuperAdmin->givePermissionTo('delete event');
        $roleSuperAdmin->givePermissionTo('update-khusus event');

        // Submission Report
        $roleSuperAdmin->givePermissionTo('view report');
        $roleSuperAdmin->givePermissionTo('show report');
        $roleSuperAdmin->givePermissionTo('delete report');
        $roleSuperAdmin->givePermissionTo('update-khusus report');

        // Participant
        $roleSuperAdmin->givePermissionTo('view participant');
        $roleSuperAdmin->givePermissionTo('delete participant');

        // organization
        $roleSuperAdmin->givePermissionTo('view organization');
        $roleSuperAdmin->givePermissionTo('create organization');
        $roleSuperAdmin->givePermissionTo('update organization');
        $roleSuperAdmin->givePermissionTo('delete organization');

        // Setting
        $roleSuperAdmin->givePermissionTo('update setting');

        Organization::create([
            'name' => 'super admin',
        ]);


        Setting::create([
            'app_name' => ucwords('app meom'),
            'app_logo' => 'logo.png',
            'hero_name' => ucwords('selamat datang di'),
            'short_description' => ucwords(' Selamat datang di App Meom, solusi terbaik dalam Manajemen Event untuk organisasi mahasiswa STMIK El Rahma Yogyakarta. Dengan fitur-fitur yang canggih dan user-friendly, kami memudahkan Anda merencanakan, mengatur, dan mendaftar acara Anda dengan lebih efisien dan profesional.'),
            'hero_image' => 'hero.jpg',
            'contact_phone' => '0839748746476',
            'contact_email' => 'appmeom@gmail.com',
            'contact_address' => 'Jl. Sisingamangaraja Jl. Karangkajen No.76, Brontokusuman, Kec. Mergangsan, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55153'
        ]);

        // user
        $userSuperadmin = User::create([
            'name' => 'super admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
            'organization_id' => 1,
        ]);
        $userSuperadmin->assignRole($roleSuperAdmin);
    }
}
