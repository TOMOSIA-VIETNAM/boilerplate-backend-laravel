<?php
namespace Modules\Admin\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Admin\Constants\UserStatus;
use Modules\Admin\Entities\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(10),
            'email' => Str::random(20) . '@test.com',
            'password' => Hash::make('12345678'),
            'status' => UserStatus::ACTIVE,
            'email_verified_at' =>  Carbon::now()
        ];
    }
}

