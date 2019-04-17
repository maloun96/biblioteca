<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\Book;
use App\Models\Auth\Copy;
use App\Models\Auth\Terminal;
use App\Models\Auth\User;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CopyRepository.
 */
class CopyRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Copy::class;
    }

    /**
     * @param array $data
     *
     * @return Book
     * @throws \Throwable
     */
    public function create(array $data) : Copy
    {
        return DB::transaction(function () use ($data) {
            $copy = parent::create([
                'cod' => $data['cod'],
                'book_id' => $data['book_id'],
            ]);

            return $copy;
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
    public function update(Book $book, array $data) : Copy
    {
        return DB::transaction(function () use ($book, $data) {
            if ($book->update([
                'cod' => $data['cod'],
                'book_id' => $data['book_id'],
            ])) {
                return $book;
            }
        });
    }

    public function deleteByBookId($bookId) {
        $this->model->where('book_id', '=', $bookId)->forceDelete();
    }
}
