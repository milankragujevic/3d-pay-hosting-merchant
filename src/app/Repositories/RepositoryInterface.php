<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repositories
 */
interface RepositoryInterface
{

    /**
     * @param array $relations
     *
     * @return Builder
     */
    public function builder(array $relations = []): Builder;
}
