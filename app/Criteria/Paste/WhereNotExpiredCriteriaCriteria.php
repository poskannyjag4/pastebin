<?php

namespace App\Criteria\Paste;

use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WhereNotExpiredCriteriaCriteria.
 *
 * @package namespace App\Criteria\Paste;
 */
class WhereNotExpiredCriteriaCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Paste              $model
     * @param RepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->where(function ($query) {
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        });
    }
}
