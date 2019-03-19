<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\Book;
use App\Models\Auth\Terminal;
use App\Models\Auth\User;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BookRepository.
 */
class BookRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model()
	{
		return Book::class;
	}

	/**
	 * @param array $data
	 *
	 * @return Book
	 * @throws \Throwable
	 */
	public function create(array $data) : Book
	{
		return DB::transaction(function () use ($data) {
			$book = parent::create([
				'name' => $data['name'],
				'copies' => $data['copies'],
			]);

			return $book;
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
			->paginate($paged);
	}

	/**
	 * @param Book $book
	 * @param array $data
	 *
	 * @return Book
	 * @throws \Throwable
	 */
	public function update(Book $book, array $data) : Book
	{
		return DB::transaction(function () use ($book, $data) {
			if ($book->update([
				'name' => $data['name'],
				'copies' => $data['copies'],
			])) {
				return $book;
			}
		});
	}
}
