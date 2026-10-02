<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use SoftDeletes;

    public const RESULT_PASS = 'PASS';

    public const RESULT_FAIL = 'FAIL';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'handler_name',
        'certificate_number',
        'date_of_assessment',
        'training_organization',
        'assessor_name',
        'result',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_assessment' => 'date',
        ];
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->comments()->where('status', Comment::STATUS_APPROVED);
    }

    public function getSlugAttribute(): string
    {
        return str_replace('/', '-', $this->certificate_number);
    }

    public function getVerifyUrlAttribute(): string
    {
        return route('verify.show', $this->slug);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isPassed(): bool
    {
        return $this->result === self::RESULT_PASS;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! filled($term)) {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function (Builder $builder) use ($like, $term) {
            $builder->where('handler_name', 'like', $like)
                ->orWhere('certificate_number', 'like', $like)
                ->orWhere('certificate_number', 'like', '%'.str_replace('-', '/', $term).'%')
                ->orWhere('training_organization', 'like', $like)
                ->orWhere('assessor_name', 'like', $like);
        });
    }

    public static function numberFromSlug(string $slug): string
    {
        return str_replace('-', '/', $slug);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('certificate_number', self::numberFromSlug($slug))->first();
    }
}
