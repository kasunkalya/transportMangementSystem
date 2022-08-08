<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Menu Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Kasun Kalya <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Kasun Kalya
 * @version    v1.0.0
 */
class Province extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'province';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['province'];

	

	

}
