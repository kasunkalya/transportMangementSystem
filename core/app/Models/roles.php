<?php namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

/**
 * User Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     kasun kalya <kasun.kalya@gmail.com>
 * @copyright  Copyright (c) 2015, kasun kalya
 * @version    v1.0.0
 */
class Roles extends CartalystUser{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role_users';


}
