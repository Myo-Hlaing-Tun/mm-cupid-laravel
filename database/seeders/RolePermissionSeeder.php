<?php

namespace Database\Seeders;

use App\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->truncate();
        DB::table('role_permission')->insert(
            [
                'id'        => 1,
                'route'     => 'admin-backend/index',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 2,
                'route'     => 'admin-backend/index',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 3,
                'route'     => 'admin-backend/index',
                'role'      => Constants::Editor_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 4,
                'route'     => 'admin-backend/user',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 5,
                'route'     => 'admin-backend/city',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 6,
                'route'     => 'admin-backend/setting',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 7,
                'route'     => 'admin-backend/hobby',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 8,
                'route'     => 'admin-backend/member',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 9,
                'route'     => 'admin-backend/member',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 10,
                'route'     => 'admin-backend/post',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 11,
                'route'     => 'admin-backend/post',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 12,
                'route'     => 'admin-backend/pointpurchase',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 13,
                'route'     => 'admin-backend/pointpurchase',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 14,
                'route'     => 'admin-backend/point',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 15,
                'route'     => 'admin-backend/api',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 16,
                'route'     => 'admin-backend/point',
                'role'      => Constants::Editor_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 17,
                'route'     => 'admin-backend/point',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 18,
                'route'     => 'admin-backend/dating',
                'role'      => Constants::ADMIN_ROLE
            ]
        );
        DB::table('role_permission')->insert(
            [
                'id'        => 19,
                'route'     => 'admin-backend/dating',
                'role'      => Constants::CUSTOMER_SERVICE_ROLE
            ]
        );
    }
}
