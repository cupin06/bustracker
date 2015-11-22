<?php
/**
 * Created by PhpStorm.
 * User: faiz
 * Date: 11/21/2015
 * Time: 2:47 PM
 */

namespace bustracker\Model;

use Illuminate\Database\Eloquent\Model;

class BusStatus extends Model
{

    protected $table = 'bus_status';

    protected $fillable = [ 'destination' ];


}