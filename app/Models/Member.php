<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Enums\MemberStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email_target',
        'email_nick',
        'email_full',
        'libera_nick',
        'libera_cloak',
        'libera_cloak_applied',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => MemberStatus::class,
        ];
    }

    /**
     * Scope a query to search members by username, email, or libera nick.
     */
    #[Scope]
    protected function search(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $q, $search) {
            $q->whereFullText(
                ['username', 'email_target', 'email_nick', 'libera_nick'],
                Str::toBooleanFullTextQuery($search),
                ['mode' => 'boolean']
            );
        });
    }

    /**
     * Scope a query to only include members with specific status(es).
     *
     * @param  MemberStatus|array<MemberStatus>  $statuses
     */
    #[Scope]
    protected function withStatus(Builder $query, MemberStatus|array $statuses): void
    {
        $statuses = is_array($statuses) ? $statuses : [$statuses];
        $statusValues = array_map(fn ($status) => $status->value, $statuses);
        $query->whereIn('status', $statusValues);
    }
}
