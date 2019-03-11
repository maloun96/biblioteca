<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\Terminal;
use App\Models\Auth\User;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Auth\User\UserConfirmed;
use App\Notifications\Backend\Auth\UserAccountActive;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TerminalController.
 */
class TerminalRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model()
	{
		return Terminal::class;
	}

	/**
	 * @param array $data
	 *
	 * @return User
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function create(array $data) : Terminal
	{
		return DB::transaction(function () use ($data) {
			$terminal = parent::create([
				'name' => $data['name'],
			]);

			return $terminal;
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
	 * @param Terminal $terminal
	 * @param array $data
	 *
	 * @return Terminal
	 * @throws \Throwable
	 */
	public function update(Terminal $terminal, array $data) : Terminal
	{
		return DB::transaction(function () use ($terminal, $data) {
			if ($terminal->update([
				'name' => $data['name'],
			])) {
				return $terminal;
			}
		});
	}
}
