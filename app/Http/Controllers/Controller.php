<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static function getColumnTable($table)
	{
		$columns = array();
		$prefix  = \DB::getTablePrefix();
		foreach (\DB::getSchemaBuilder()->getColumnListing($prefix.$table) as $column) {
		   //print_r($column);
		    $columns[$column] = '';
		}

		$object = (object) $columns;
		return $object;
	}

    //commmon function to display the error both in terminal and browser
    public function return_output($type, $status_title, $message, $redirect_url, $status_code = '')
    {
        // echo 'test';exit;
        //$type = error/flash - error on form validations, flash to show session values
        //$status_title = success/error/info - change colors in toastr as per the status

        
        if ($type=='error') {
            if ($redirect_url == 'back') {
                return Redirect::back()->withErrors($message)->withInput();
            } elseif ($redirect_url != '') {
                return Redirect::to($redirect_url)->withErrors($message)->withInput();
            }
        } else {
            if ($redirect_url == 'back') {
                return Redirect::back()->with($status_title, $message);
            } elseif ($redirect_url != '') {
                return Redirect::to($redirect_url)->with($status_title, $message);
            } elseif ($redirect_url == '') {
                return Session::flash($status_title, $message);
            }
        }
        
    }
}

