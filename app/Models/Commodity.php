<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commodity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'category_id', 'program_study_id', 'item_code', 'stock', 'condition', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function programStudy(): BelongsTo
    {
        return $this->belongsTo(ProgramStudy::class);
    }
}
