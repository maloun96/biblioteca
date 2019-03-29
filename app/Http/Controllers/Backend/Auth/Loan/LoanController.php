<?php

namespace App\Http\Controllers\Backend\Auth\Loan;

use App\Http\Requests\Backend\Auth\Terminal\StoreTerminalRequest;
use App\Models\Auth\Book;
use App\Http\Controllers\Controller;
use App\Models\Auth\Loan;
use App\Repositories\Backend\Auth\BookRepository;
use App\Repositories\Backend\Auth\LoanRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Repositories\Backend\Auth\UserRepository;
use Auth;
use Illuminate\Http\Request;

/**
 * Class LoanController.
 */
class LoanController extends Controller
{
	/**
	 * @var LoanRepository
	 */
	protected $loanRepository;

	/**
	 * @var UserRepository
	 */
	protected $userRepository;

	/**
	 * @var BookRepository
	 */
	protected $bookRepository;

	/**
	 * TerminalController constructor.
	 *
	 * @param LoanRepository $loanRepository
	 * @param UserRepository $userRepository
	 * @param BookRepository $bookRepository
	 */
	public function __construct(LoanRepository $loanRepository, UserRepository $userRepository, BookRepository $bookRepository)
	{
		$this->loanRepository = $loanRepository;
		$this->userRepository = $userRepository;
		$this->bookRepository = $bookRepository;
	}

	/**
	 * @param \Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(\Request $request)
	{
		$loans = $this->loanRepository->getPaginated(25, 'created_at', 'desc');
		$isAdmin = $this->isAdmin();
		return view('backend.auth.loan.index')->with(compact('loans', 'isAdmin'));
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
		$books = $this->bookRepository->orderBy('created_at', 'desc')->all();
		$users = $this->userRepository->orderBy('created_at', 'desc')->all();
		return view('backend.auth.loan.create', ['books' => $books, 'users' => $users]);
	}

	/**
	 * @param StoreTerminalRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store(StoreTerminalRequest $request)
	{
		$data = array_merge($request->only(
			'user_id',
			'book_id'
		), ['status' => 0]);

		$this->loanRepository->create($data);

		return redirect()->route('admin.auth.loan.index')->withFlashSuccess('The loan was successfully created. Wait for approve');
	}

	public function approve(Loan $loan) {
		$this->loanRepository->updateStatus($loan, ['status' => 1]);
		return redirect()->route('admin.auth.loan.index')->withFlashSuccess('Loan was successfully updated.');
	}

	public function back(Loan $loan) {
		$this->loanRepository->updateStatus($loan, ['status' => 2]);
		return redirect()->route('admin.auth.loan.index')->withFlashSuccess('Loan was successfully updated.');
	}

	/**
	 * @param ManageUserRequest $request
	 * @param RoleRepository $roleRepository
	 * @param PermissionRepository $permissionRepository
	 * @param Loan $loan
	 * @return mixed
	 */
	public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Loan $loan)
	{
		$books = $this->bookRepository->orderBy('created_at', 'desc')->all();
		$users = $this->userRepository->orderBy('created_at', 'desc')->all();
		return view('backend.auth.loan.edit', ['books' => $books, 'users' => $users, 'loan' => $loan]);
	}

	/**
	 * @param StoreTerminalRequest $request
	 * @param Loan $loan
	 * @return mixed
	 * @throws \Throwable
	 */
	public function update(Request $request, Loan $loan)
	{
		$this->loanRepository->update($loan, $request->only(
			'user_id',
			'book_id',
			'status'
		));

		return redirect()->route('admin.auth.loan.index')->withFlashSuccess('Book was successfully updated.');
	}

	/**
	 * @param Loan $loan
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Loan $loan)
	{
		$this->loanRepository->deleteById($loan->id);

		return redirect()->route('admin.auth.loan.index')->withFlashSuccess('Loan was successfully deleted.');
	}
}
