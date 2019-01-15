<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\Client\EnumClientStatus;
use App\Enum\Transaction\EnumTransactionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Client
 *
 * @package App\Models
 * @method \Illuminate\Database\Query\Builder active()
 * @method \Illuminate\Database\Query\Builder inActive()
 * @method \Illuminate\Database\Query\Builder locked()
 * @method \Illuminate\Database\Query\Builder lastMonthPassed()
 */
class Client extends Model
{
    /**
     * @var string
     */
    protected $table = 'client';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic_name',
        'email',
        'status',
        'balance',
        'last_payment'
    ];

    /**
     * @return HasMany
     */
    public function transaction() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }


    /**
     * @param $query
     *
     * @return Builder
     */
    public function scopeActive($query) : Builder
    {
        return $query->where('status', EnumClientStatus::ACTIVE);
    }

    /**
     * @param $query
     *
     * @return Builder
     */
    public function scopeInActive($query) : Builder
    {
        return $query->where('status', EnumClientStatus::INACTIVE);
    }

    /**
     * @param $query
     *
     * @return Builder
     */
    public function scopeLocked($query) : Builder
    {
        return $query->where('status', EnumClientStatus::LOCKED);
    }


    /**
     * @return bool
     */
    public function isLocked() : bool
    {
        return $this->status === EnumClientStatus::LOCKED;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->status === EnumClientStatus::ACTIVE;
    }

    /**
     * @return bool
     */
    public function ban() : bool
    {
        $this->status = EnumClientStatus::LOCKED;

        return $this->save();
    }

    /**
     * @param $sum
     *
     * @return bool
     */
    public function deposit($sum) : bool
    {
        $this->increment('balance', $sum);

        return $this->save();
    }

    /**
     * @param $sum
     *
     * @return bool
     */
    public function withdraw($sum) : bool
    {
        $this->decrement('balance', $sum);

        return $this->save();
    }

    /**
     * @param $query
     *
     * @return Builder
     */
    public function scopeLastMonthPassed($query) : Builder
    {
        return $query->whereDoesntHave('transaction', function ($query) {
            $query->where('created_at', '>=', Carbon::parse()->subMonth())
                ->whereIn('type', [EnumTransactionType::FIRST, EnumTransactionType::REGULAR]);
        });
    }
}
