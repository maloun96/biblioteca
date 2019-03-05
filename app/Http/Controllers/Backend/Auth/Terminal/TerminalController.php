<?php

namespace App\Http\Controllers\Backend\Auth\Terminal;

use App\Http\Requests\Backend\Auth\Terminal\StoreTerminalRequest;
use App\Models\Auth\Terminal;
use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\TerminalRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;

/**
 * Class TerminalController.
 */
class TerminalController extends Controller
{
	/**
	 * @var TerminalRepository
	 */
	protected $terminalRepository;

	/**
	 * TerminalController constructor.
	 *
	 * @param TerminalRepository $terminalRepository
	 */
	public function __construct(TerminalRepository $terminalRepository)
	{
		$this->terminalRepository = $terminalRepository;
	}

	/**
	 * @param \Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(\Request $request)
	{
		return view('backend.auth.terminal.index')->withTerminals($this->terminalRepository->getPaginated(25, 'id', 'asc'));
	}

	/**
	 * @param ManageUserRequest    $request
	 * @param RoleRepository       $roleRepository
	 * @param PermissionRepository $permissionRepository
	 *
	 * @return mixed
	 */
	public function create(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
	{
		return view('backend.auth.terminal.create');
	}

	/**
	 * @param StoreTerminalRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store(StoreTerminalRequest $request)
	{
		$this->terminalRepository->create($request->only(
			'name'
		));

		return redirect()->route('admin.auth.terminal.index')->withFlashSuccess('The terminal was successfully created.');
	}

	/**
	 * @param ManageUserRequest $request
	 * @param RoleRepository $roleRepository
	 * @param PermissionRepository $permissionRepository
	 * @param Terminal $terminal
	 * @return mixed
	 */
	public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Terminal $terminal)
	{
		return view('backend.auth.terminal.edit')->withTerminal($terminal);
	}

	/**
	 * @param StoreTerminalRequest $request
	 * @param Terminal $terminal
	 * @return mixed
	 * @throws \App\Exceptions\GeneralException
	 * @throws \Throwable
	 */
	public function update(StoreTerminalRequest $request, Terminal $terminal)
	{
		$this->terminalRepository->update($terminal, $request->only(
			'name'
		));

		return redirect()->route('admin.auth.terminal.index')->withFlashSuccess('Terminal was successfully updated.');
	}

	/**
	 * @param Terminal $terminal
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Terminal $terminal)
	{
		$this->terminalRepository->deleteById($terminal->id);

		return redirect()->route('admin.auth.terminal.index')->withFlashSuccess('Terminal was successfully deleted.');
	}
}
