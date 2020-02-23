<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * @var string
     */
    private string $field;

    /**
     * @var int
     */
    private int $max_depth;

    /**
     * @var int
     */
    private int $max_children;

    /**
     * @var array
     */
    protected $fillable = ['field', 'max_depth', 'max_children'];

    /**
     * @var array
     */
    protected $visible = ['field', 'max_depth', 'max_children'];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * @return int
     */
    public function getMaxDepth(): int
    {
        return $this->max_depth;
    }

    /**
     * @param int $max_depth
     */
    public function setMaxDepth(int $max_depth): void
    {
        $this->max_depth = $max_depth;
    }

    /**
     * @return int
     */
    public function getMaxChildren(): int
    {
        return $this->max_children;
    }

    /**
     * @param int $max_children
     */
    public function setMaxChildren(int $max_children): void
    {
        $this->max_children = $max_children;
    }
}
