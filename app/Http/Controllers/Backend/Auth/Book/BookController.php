<?php

namespace App\Http\Controllers\Backend\Auth\Book;

use App\Http\Requests\Backend\Auth\Terminal\StoreTerminalRequest;
use App\Models\Auth\Book;
use App\Models\Auth\Copy;
use App\Models\Auth\Terminal;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\BookRepository;
use App\Repositories\Backend\Auth\CopyRepository;
use App\Repositories\Backend\Auth\LoanRepository;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;

/**
 * Class BookController.
 */
class BookController extends Controller
{
	/**
	 * @var BookRepository
	 */
	protected $bookRepository;

    /**
     * @var CopyRepository
     */
    protected $copyRepository;

    /**
     * @var LoanRepository
     */
    protected $loanRepository;

    /**
     * TerminalController constructor.
     *
     * @param BookRepository $bookRepository
     * @param CopyRepository $copyRepository
     */
	public function __construct(BookRepository $bookRepository, CopyRepository $copyRepository, LoanRepository $loanRepository)
	{
		$this->bookRepository = $bookRepository;
		$this->copyRepository = $copyRepository;
		$this->loanRepository = $loanRepository;
	}

	/**
	 * @param \Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(\Request $request)
	{
		return view('backend.auth.book.index')->withBooks($this->bookRepository->getPaginated(25, 'id', 'asc'));
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
		return view('backend.auth.book.create');
	}

	/**
	 * @param StoreTerminalRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store(StoreTerminalRequest $request)
	{
		$b = $this->bookRepository->create($request->only(
			'name'
		));

		$copies = $request->all()['cod_unic'];
		foreach($copies as $copy) {
		    $this->copyRepository->create(array('cod' => $copy, 'book_id' => $b->id));
        }

		return redirect()->route('admin.auth.book.index')->withFlashSuccess('The book was successfully created.');
	}

	/**
	 * @param ManageUserRequest $request
	 * @param RoleRepository $roleRepository
	 * @param PermissionRepository $permissionRepository
	 * @param Book $book
	 * @return mixed
	 */
	public function edit(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository, Book $book)
	{
		return view('backend.auth.book.edit')->withBook($book);
	}

	/**
	 * @param StoreTerminalRequest $request
	 * @param Book $book
	 * @return mixed
	 * @throws \Throwable
	 */
	public function update(StoreTerminalRequest $request, Book $book)
	{
		$this->bookRepository->update($book, $request->only(
			'name'
		));

        $this->copyRepository->deleteByBookId($book->id);
        $copies = $request->all()['cod_unic'];
        foreach($copies as $copy) {
            $this->copyRepository->create(array('cod' => $copy, 'book_id' => $book->id));
        }

		return redirect()->route('admin.auth.book.index')->withFlashSuccess('Book was successfully updated.');
	}

	/**
	 * @param Book $book
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Book $book)
	{
	    $this->loanRepository->deleteByBookId($book->id);
        $this->copyRepository->deleteByBookId($book->id);
		$this->bookRepository->deleteById($book->id);

		return redirect()->route('admin.auth.book.index')->withFlashSuccess('Book was successfully deleted.');
	}
}
