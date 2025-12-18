<?php
// app/Models/Club.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Поля, разрешённые для массового заполнения
     */
    protected $fillable = [
        'name',
        'league',
        'image_path',
        'short_description',
        'full_description',
        'stadium',
        'founded_year',
        'titles',
    ];

    /**
     * Приведение типов
     */
    protected $casts = [
        'founded_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Даты для мутаторов
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

   

    /**
     * Получить название с заглавной буквы
     */
    public function getFormattedNameAttribute(): string
    {
        return mb_strtoupper($this->name);
    }

    /**
     * Получить возраст клуба
     */
    public function getClubAgeAttribute(): ?int
    {
        if ($this->founded_year) {
            return Carbon::now()->year - $this->founded_year;
        }
        return null;
    }

    /**
     * Получить форматированную дату создания
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    /**
     * Получить форматированную дату обновления
     */
    public function getFormattedUpdatedAtAttribute(): string
    {
        return $this->updated_at->format('d.m.Y H:i');
    }

    /**
     * Получить краткое описание (ограниченное)
     */
    public function getLimitedDescriptionAttribute(): string
    {
        return \Str::limit($this->short_description, 100);
    }

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            // Если это внешняя ссылка
            if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
                return $this->image_path;
            }
            // Если локальный файл
            return asset('storage/' . $this->image_path);
        }
        // Дефолтное изображение
        return 'https://via.placeholder.com/200x200?text=No+Logo';
    }

    

    /**
     * Установить название (первая буква заглавная)
     */
    public function setNameAttribute($value): void
    {
         $value = trim($value);
    // mb_convert_case работает с русскими буквами
    $this->attributes['name'] = mb_convert_case(mb_strtolower($value), MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Установить лигу
     */
    public function setLeagueAttribute($value): void
    {
        $this->attributes['league'] = trim($value);
    }

    /**
     * Установить краткое описание
     */
    public function setShortDescriptionAttribute($value): void
    {
        $this->attributes['short_description'] = trim($value);
    }

    /**
     * Установить полное описание
     */
    public function setFullDescriptionAttribute($value): void
    {
        $this->attributes['full_description'] = $value ? trim($value) : null;
    }

    

    /**
     * Получить клубы определённой лиги
     */
    public function scopeByLeague($query, string $league)
    {
        return $query->where('league', 'like', "%{$league}%");
    }

    /**
     * Получить клубы, основанные после определённого года
     */
    public function scopeFoundedAfter($query, int $year)
    {
        return $query->where('founded_year', '>=', $year);
    }
}