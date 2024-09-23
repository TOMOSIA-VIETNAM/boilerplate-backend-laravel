<?php
namespace Modules\Api\Http\Controllers;

use App\Containers\User\Actions\UpdatePasswordAction;
use App\Containers\User\Actions\UpdateProfileAction;
use Illuminate\Http\Request;
use Modules\Api\Http\Requests\User\ChangePasswordRequest;
use Modules\Api\Http\Requests\User\UserRequest;
use Modules\Api\Transformers\Profile\ProfileResource;
use Modules\Api\Transformers\SuccessResource;

class UserController extends ApiController
{
    /**
     * @param Request $request
     * @return ProfileResource
     */
    public function profile(Request $request): ProfileResource
    {
        return ProfileResource::make($request->user());
    }

    /**
     * @param UserRequest $request
     * @return ProfileResource
     */
    public function update(UserRequest $request): ProfileResource
    {
        $user = resolve(UpdateProfileAction::class)->handle($request->onlyFields());

        return ProfileResource::make($user);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return SuccessResource
     */
    public function changePassword(ChangePasswordRequest $request): SuccessResource
    {
        resolve(UpdatePasswordAction::class)->handle($request->onlyFields());

        return SuccessResource::make();
    }
}
