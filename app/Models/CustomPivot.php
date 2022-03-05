<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class CustomPivot extends Pivot
{
    protected $casts = [
      'created_at' => 'datetime:Y-m-d',
      'updated_at' => 'datetime:Y-m-d'
    ];
}
?>