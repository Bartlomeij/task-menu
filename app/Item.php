<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package App
 */
class Item extends Model
{
    /**
     * @var string
     */
    private string $field;

    /**
     * @var string
     */
    private int $parent_id;

    /**
     * @var array
     */
    protected $fillable = ['field', 'parent_id', 'children'];

    /**
     * @var array
     */
    protected $visible = ['field'];

    /**
     * @var array
     */
    protected $with = ['children'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany( Menu::class, 'id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(){
        return $this->hasOne( Menu::class, 'parent_id', 'id' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
