<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\Book;
use App\Repositories\Backend\Auth\BookRepository;
use App\Repositories\Backend\Auth\LoanRepository;
use Auth;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{

	public $bookRepository;

	public $loanRepository;

	/**
	 * DashboardController constructor.
	 * @param BookRepository $bookRepository
	 * @param LoanRepository $loanRepository
	 */
	public function __construct(BookRepository $bookRepository, LoanRepository $loanRepository) {
		$this->bookRepository = $bookRepository;
		$this->loanRepository = $loanRepository;
	}

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$loansBooksIds = [];
		$loans = $this->loanRepository->where('status', 1, '=')->with('book')->orderBy('created_at', 'desc')->get();
		foreach($loans as $loan) {
			if(!array_key_exists($loan->book->id, $loansBooksIds)) {
				$loansBooksIds[$loan->book->id] = 1;
			} else {
				$loansBooksIds[$loan->book->id] += 1;
			}
		}

		$books = $this->bookRepository->all();
		foreach($books as $key => $book) {
			if(array_key_exists($book->id, $loansBooksIds)) {
				$books[$key]->available = $book->copies > $loansBooksIds[$book->id];
			} else {
				$books[$key]->available = true;
			}
		}
		$userLoans = $this->loanRepository->where('user_id', Auth::user()->id, '=')->orderBy('created_at', 'desc')->get();

        return view('frontend.user.dashboard', ['books' => $books, 'userLoans' => $userLoans]);
    }

    public function loan(Request $request, Book $book) {
		$this->loanRepository->create([
			'user_id' => Auth::user()->id,
			'book_id' => $book->id,
			'status' => 0
		]);

		return redirect()->route('frontend.user.dashboard')->withFlashSuccess('The loan was successfully created. Wait for approve');
	}
}
