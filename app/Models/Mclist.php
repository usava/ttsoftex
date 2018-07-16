<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\MailChimp;

class Mclist extends Model
{
    protected $table = 'm_c_lists';
    protected $guarded = [];

    protected $casts = [
        'modules' => 'array',
        'stats' => 'array',
        'contact' => 'array',
        'campaign_defaults'=> 'array'
    ];

    public $timestamps = false;

    public static function getListsFromApi(MailChimp $mc)
    {
        $response = $mc->get('lists');

        return $response['lists'];
    }

    public static function getListFromApi(MailChimp $mc, $list_id)
    {
        $response = $mc->get('lists/'.$list_id);

        return $response;
    }
}
