<?php
namespace App\Models;

/**
 * Permission Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     kasun Kalya <kasun.kalya@gmail.com>
 *
 */
use Illuminate\Database\Eloquent\Model;

class LorryModel extends Model
{

    /**
     * table row delete
     */


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'muthumala_vehicle_models';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['model_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * get customer each outlet
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
//    public function comments()
//    {
//        return $this->hasMany('App\Comment');
//    }
}
