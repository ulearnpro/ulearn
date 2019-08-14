<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;
use App\Models\Course;

class IsSubscribed
{
    /**
     * 
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        $course_slug = $request->segment(2);
        
        $is_subscribed = Course::is_subscribed($course_slug, $user->id);
        
        if($is_subscribed)
                return $next($request);

        if (Request::isMethod('get')) {
            abort(401);
        } else if(Request::isMethod('post')) {
            return redirect('/');
        }

        
    }
}
