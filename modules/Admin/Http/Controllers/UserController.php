<?php

namespace Modules\Admin\Http\Controllers;

use App\Containers\User\Actions\Admin\CreateUserAction;
use App\Containers\User\Actions\Admin\DeleteUserAction;
use App\Containers\User\Actions\Admin\DetailUserAction;
use App\Containers\User\Actions\Admin\GetListUserAction;
use App\Containers\User\Actions\Admin\UpdateUserAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\User\CreateRequest;
use Modules\Admin\Http\Requests\User\UpdateRequest;

class UserController extends AdminController
{
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->middleware(['role:master_admin|admin|user', 'permission:writer'], ['except' => ['index']]);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $users = resolve(GetListUserAction::class)->handle();

        return view('admin::users.index', compact('users'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        resolve(DeleteUserAction::class)->handle($id);

        return redirect()->back()->with('success', __('Delete successfully'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin::users.create');
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $created = resolve(CreateUserAction::class)->handle($request->onlyFields());

        if (!$created) {
            return redirect()->back()->with('error', value: __('Create failure'));
        }

        return redirect()->route('admin.user.index')->with('success', value: __('Create successfully'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = resolve(DetailUserAction::class)->handle($id);

        return view('admin::users.edit', compact('user'));
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateRequest $request): RedirectResponse
    {
        $updated = resolve(UpdateUserAction::class)->handle($id, $request->onlyFields());

        if (!$updated) {
            return redirect()->back()->with('error', value: __('Update failure'));
        }

        return redirect()->route('admin.user.index')->with('success', value: __('Update successfully'));
    }
}
