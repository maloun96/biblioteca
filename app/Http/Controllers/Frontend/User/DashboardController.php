<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Auth\Book;
use App\Models\Auth\Copy;
use App\Repositories\Backend\Auth\BookRepository;
use App\Repositories\Backend\Auth\CopyRepository;
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

	public $copyRepository;

    /**
     * DashboardController constructor.
     * @param BookRepository $bookRepository
     * @param LoanRepository $loanRepository
     * @param CopyRepository $copyRepository
     */
	public function __construct(BookRepository $bookRepository, LoanRepository $loanRepository, CopyRepository $copyRepository) {
		$this->bookRepository = $bookRepository;
		$this->loanRepository = $loanRepository;
		$this->copyRepository = $copyRepository;
	}

	/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$loansBooksIds = [];
		$loans = $this->loanRepository->where('status', 1, '=')->with('copy')->orderBy('created_at', 'desc')->get();

		foreach($loans as $loan) {
			if(!array_key_exists($loan->copy->book->id, $loansBooksIds)) {
				$loansBooksIds[$loan->copy->book->id] = 1;
			} else {
				$loansBooksIds[$loan->copy->book->id] += 1;
			}
		}

		$books = $this->copyRepository->with('book')->all();
		foreach($books as $key => $book) {
			if(array_key_exists($book->id, $loansBooksIds)) {
				$books[$key]->available = $book->copies > $loansBooksIds[$book->id];
			} else {
				$books[$key]->available = true;
			}
		}

		$userLoans = $this->loanRepository
            ->where('user_id', Auth::user()->id, '=')
            ->orderBy('created_at', 'desc')
            ->with('copy')->get();

        return view('frontend.user.dashboard', ['books' => $books, 'userLoans' => $userLoans]);
    }

    public function loan(Request $request, $copyId) {
		$this->loanRepository->create([
			'user_id' => Auth::user()->id,
			'copy_id' => $copyId,
			'status' => 0
		]);

		return redirect()->route('frontend.user.dashboard')->withFlashSuccess('The loan was successfully created. Wait for approve');
	}
}
