<?php
namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Api\Http\Requests\User\ChangePasswordRequest;
use Modules\Api\Http\Requests\User\UserRequest;
use Modules\Api\Services\UserService;
use Modules\Api\Transformers\Profile\ProfileResource;
use Modules\Api\Transformers\SuccessResource;

class UserController extends ApiController
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService) {}

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
        $user = $this->userService->updateProfile($request->onlyFields());

        return ProfileResource::make($user);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return SuccessResource
     */
    public function changePassword(ChangePasswordRequest $request): SuccessResource
    {
        $this->userService->updatePassword($request->onlyFields());

        return SuccessResource::make();
    }
}
