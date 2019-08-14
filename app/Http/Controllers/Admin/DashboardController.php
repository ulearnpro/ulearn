<?php
/**
 * PHP Version 7.1.7-1
 * Functions for dashboard
 *
 * @category  File
 * @package   Dashboard
 * @author    Mohamed Yahya
 * @copyright ULEARN  
 * @license   BSD Licence
 * @link      Link
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;
use App\Models\WithdrawRequest;
use App\Models\Instructor;

/**
 * Class contain functions for admin
 *
 * @category  Class
 * @package   Dashboard
 * @author    Mohamed Yahya
 * @copyright ULEARN
 * @license   BSD Licence
 * @link      Link
 */
class DashboardController extends Controller
{
    /**
     * Function to display the dashboard contents for admin
     *
     * @param array $request All input values from form
     *
     * @return contents to display in dashboard
     */
    public function __invoke()
    {
        $courses = DB::table('courses')
                        ->select('courses.*', 'categories.name as category_name', 'instructors.first_name as instructor_name')
                        ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                        ->leftJoin('instructors', 'instructors.id', '=', 'courses.instructor_id')
                        ->paginate(5);
        $metrics = Instructor::admin_metrics();
        return view('admin.dashboard.index', compact('courses', 'metrics'));
    }

    public function withdrawRequests($user_id='', Request $request)
    {
        $withdraw_requests = WithdrawRequest::paginate(10);
        return view('admin.dashboard.withdraw_requests', compact('withdraw_requests'));
    }

    public function approveWithdrawRequest($request_id='',Request $request)
    {
        $withdraw_request = WithdrawRequest::find($request_id);

        $request_amount = $withdraw_request->amount;
        $instructor_credit = $withdraw_request->instructor->total_credits;
        
        if($request_amount > $instructor_credit) {
            return $this->return_output('flash', 'error', 'Requested amount exceeds the Instructor credits', 'back', '422');
        }

        $instructor_id = $withdraw_request->instructor_id;
        Instructor::find($instructor_id)->decrement('total_credits', $request_amount);

        $withdraw_request->status = 1;
        $withdraw_request->save();

        return $this->return_output('flash', 'success', 'Withdraw request approved successfully', 'back', '200');
    }
    
}
