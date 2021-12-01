<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vwUploadsNotification extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'vwUploadsNotification';

    /** @var array */
    protected $fillable = [
        'std_zulu'
        , 'OUTZulu'
    ];

    public $sortable = ['std_zulu', 'OUTZulu'];
}
