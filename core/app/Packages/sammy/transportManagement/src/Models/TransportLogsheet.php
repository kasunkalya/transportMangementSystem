<?php namespace Sammy\TransportManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Permission Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Kasun Kalya <kasun.kalya@gmail.com>
 * @copyright  Copyright (c) 2015, Kasun Kalya
 * @version    v1.0.0
 */
class TransportLogsheet extends Model{


	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'muthumala_transportRequest_logsheet';

	/**
	 * The attributes that are not assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	

	/**
	 * get customer each outlet
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
//    public function comments()
//    {
//        return $this->hasMany('App\Comment');
//    }

}
