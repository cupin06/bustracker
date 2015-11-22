<?php
/**
 * Created by PhpStorm.
 * User: faiz
 * Date: 11/22/2015
 * Time: 6:29 PM
 */

namespace bustracker\Http\Controllers;

use bustracker\Model\BusStatus;
use Illuminate\Http\Request;

class BusStatusController extends Controller
{

    private $busStatusModel;

    public function __construct(BusStatus $busStatusModel)
    {
        $this->busStatusModel = $busStatusModel;
    }

    public function set(Request $request)
    {

       $setResult = $this->busStatusModel->create( ['destination' => $request->input('destination')] );

        if ($setResult) {
            return 'Successful';
        }

        return 'Failed';
    }

}