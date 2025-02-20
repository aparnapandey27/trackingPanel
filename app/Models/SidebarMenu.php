<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    use HasFactory;

    protected $table = 'sidebar_menu'; 

    protected $fillable = ['title', 'url', 'icon', 'order', 'parent_id'];
}
