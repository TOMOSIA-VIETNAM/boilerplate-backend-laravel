<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Admin\Http\Requests\User\CreateRequest;
use Modules\Admin\Http\Requests\User\UpdateRequest;
use Modules\Admin\Services\UserService;

class UserController extends AdminController
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
        $this->middleware(['role:master_admin|admin|user', 'permission:writer'], ['except' => ['index']]);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $users = $this->userService->getLists();

        return view('admin::users.index', compact('users'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->userService->deleteById($id);

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
        $created = $this->userService->create($request->onlyFields());

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
        $user = $this->userService->findById($id);

        return view('admin::users.edit', compact('user'));
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateRequest $request): RedirectResponse
    {
        $updated = $this->userService->updateById($id, $request->onlyFields());

        if (!$updated) {
            return redirect()->back()->with('error', value: __('Update failure'));
        }

        return redirect()->route('admin.user.index')->with('success', value: __('Update successfully'));
    }
}
