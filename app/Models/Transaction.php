<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Transaction\EnumTransactionStatus;
use App\Enum\Transaction\EnumTransactionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * Class Transaction
 *
 * @package App\Models
 * @method \Illuminate\Database\Query\Builder report($from, $to)
 */
class Transaction extends Model
{
    /**
     * @var string
     */
    protected $table = 'transaction';

    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'type',
        'sum',
        'status',
        'operation'
    ];

    /**
     * @return BelongsTo
     */
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @param $status
     */
    public function setStatusAttribute($status) : void
    {
        $this->attributes['status'] = EnumTransactionStatus::get($status)->getValue();
    }

    /**
     * @param $status
     *
     * @return bool
     */
    public function changeStatus($status) : bool
    {
        $this->status = $status;

        return $this->save();
    }

    /**
     *
     */
    public function changeSuccessStatus() : void
    {
        $this->changeStatus(EnumTransactionStatus::SUCCESS);
    }

    /**
     *
     */
    public function changeFailedStatus() : void
    {
        $this->changeStatus(EnumTransactionStatus::FAILED);
    }

    /**
     *
     */
    public function changeProcessingStatus() : void
    {
        $this->changeStatus(EnumTransactionStatus::PROCESSING);
    }

    /**
     * @return bool
     */
    public function isRegularType() : bool
    {
        return $this->type === EnumTransactionType::REGULAR;
    }

    /**
     * @return bool
     */
    public function isFirstType() : bool
    {
        return $this->type === EnumTransactionType::FIRST;
    }

    /**
     * @param $query
     * @param $from
     * @param $to
     *
     * @return Builder
     */
    public function scopeReport($query, \DateTimeInterface $from, \DateTimeInterface $to) : Builder
    {
        return $query->select(
            DB::raw(
                'DATE(updated_at) as date,
                sum(type="first") as new,
                sum(type="regular") as regular,
                sum(IF(type="first" OR type="regular", sum, 0)) as sum,
                sum(IF(type="first" OR type="regular", 1, 0)) as count,
                sum(IF(type="refund", sum, 0)) as sumRefund,
                count(IF(type="refund", 1, 0)) as countRefund'
            )
        )
            ->where('status', EnumTransactionStatus::SUCCESS)
            ->whereBetween('updated_at', [$from, $to])
            ->groupBy('date');
    }
}
