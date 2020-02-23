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
     * @var array
     */
    protected $fillable = ['field'];

    /**
     * @var array
     */
    protected $visible = ['field'];


    public function children(){
        return $this->hasMany( Menu::class, 'parent_id', 'id' );
    }

    public function parent(){
        return $this->hasOne( Menu::class, 'id', 'parent_id' );
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
