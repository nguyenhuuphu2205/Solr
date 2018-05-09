<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    public $id;
    public $chude;
    public $title;
    public $content;
    public $url;
    public function __construct($id,$chude,$title,$content,$url)
    {

        $this->id = $id;
        $this->chude=$chude;
        $this->title=$title;
        $this->content=$content;
        $this->url=$url;
    }

}
