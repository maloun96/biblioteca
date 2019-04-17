<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\Loan;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class LoanRepository.
 */
class LoanRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model()
	{
		return Loan::class;
	}

	/**
	 * @param array $data
	 *
	 * @return Loan
	 * @throws \Throwable
	 */
	public function create(array $data) : Loan
	{
		return DB::transaction(function () use ($data) {
			$loan = parent::create([
				'user_id' => $data['user_id'],
				'book_id' => $data['book_id'],
				'status' => $data['status'],
			]);

			return $loan;
		});
	}

	/**
	 * @param int    $paged
	 * @param string $orderBy
	 * @param string $sort
	 *
	 * @return mixed
	 */
	public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
	{
		return $this->model
			->orderBy($orderBy, $sort)
			->with('user')
			->paginate($paged);
	}

	/**
	 * @param Loan $loan
	 * @param array $data
	 *
	 * @return Loan
	 * @throws \Throwable
	 */
	public function update(Loan $loan, array $data) : Loan
	{
		return DB::transaction(function () use ($loan, $data) {
			if ($loan->update([
				'user_id' => $data['user_id'],
				'book_id' => $data['book_id'],
				'status' => $data['status'],
			])) {
				return $loan;
			}
		});
	}

	/**
	 * @param Loan $loan
	 * @param array $data
	 *
	 * @return Loan
	 * @throws \Throwable
	 */
	public function updateStatus(Loan $loan, array $data) : Loan
	{
		return DB::transaction(function () use ($loan, $data) {
			if ($loan->update([
				'status' => $data['status'],
			])) {
				return $loan;
			}
		});
	}

    public function deleteByBookId($bookId) {
        $this->model->where('book_id', '=', $bookId)->forceDelete();
    }
}
