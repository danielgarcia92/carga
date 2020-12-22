<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class UploadDetails extends Model
{
    use Sortable;

    protected $connection = 'sqlsrv';

    /** @var array */
    protected $fillable = [
        'guide_number'
        , 'pieces'
        , 'weight'
        , 'volume'
        , 'nature_goods'
        , 'route_item'
        , 'uploads_id'
    ];

    public $sortable = ['id', 'guide_number', 'route_item', 'uploads_id'];
}
