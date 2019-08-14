<?php
/**
 * PHP Version 7.1.7-1
 * Functions for users
 *
 * @category  File
 * @package   Blog
 * @author    Mohamed Yahya
 * @copyright ULEARN  
 * @license   BSD Licence
 * @link      Link
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;
use Crypt;
use URL;
use Session;
/**
 * Class contain functions for admin
 *
 * @category  Class
 * @package   Blog
 * @author    Mohamed Yahya
 * @copyright ULEARN
 * @license   BSD Licence
 * @link      Link
 */
class BlogController extends Controller
{
    /**
     * Function to display the blogs for admin
     *
     * @param array $request All input values from form
     *
     * @return contents to display in blogs page
     */
    public function index(Request $request)
    {
        $paginate_count = 10;
        if($request->has('search')){
            $search = $request->input('search');
            $blogs = Blog::where('blog_title', 'LIKE', '%' . $search . '%')
                           ->paginate($paginate_count);
        }
        else {
            $blogs = Blog::paginate($paginate_count);
        }
        
        return view('admin.blogs.index', compact('blogs'));
    }

    public function getForm($blog_id='', Request $request)
    {
        if($blog_id) {
            $blog = Blog::find($blog_id);
        }else{
            $blog = $this->getColumnTable('blogs');
        }
        return view('admin.blogs.form', compact('blog'));
    }

    public function saveBlog(Request $request)
    {
        // echo '<pre>';print_r($_POST);exit;
        $blog_id = $request->input('blog_id');

        $validation_rules = ['blog_title' => 'required|string'];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        if ($blog_id) {
            $blog = Blog::find($blog_id);
            $success_message = 'Blog updated successfully';
        } else {
            $blog = new Blog();
            $success_message = 'Blog added successfully';

            //create slug only while add
            $slug = $request->input('blog_title');
            $slug = str_slug($slug, '-');

            $results = DB::select(DB::raw("SELECT count(*) as total from blogs where blog_slug REGEXP '^{$slug}(-[0-9]+)?$' "));

            $finalSlug = ($results['0']->total > 0) ? "{$slug}-{$results['0']->total}" : $slug;
            $blog->blog_slug = $finalSlug;
        }

        $blog->blog_title = $request->input('blog_title');
        $blog->description = $request->input('description');
        $blog->is_active = $request->input('is_active');
        
        if (Input::hasFile('blog_image') && Input::has('blog_image_base64')) {
            //delete old file
            $old_image = $request->input('old_blog_image');
            if (Storage::exists($old_image)) {
                Storage::delete($old_image);
            }

            //get filename
            $file_name   = $request->file('blog_image')->getClientOriginalName();

            // returns Intervention\Image\Image
            $image_make = Image::make($request->input('blog_image_base64'))->encode('jpg');

            // create path
            $path = "blogs";
            
            //check if the file name is already exists
            $new_file_name = SiteHelpers::checkFileName($path, $file_name);

            //save the image using storage
            Storage::put($path."/".$new_file_name, $image_make->__toString(), 'public');

            $blog->blog_image = $path."/".$new_file_name;
            
        }

        $blog->save();

        return $this->return_output('flash', 'success', $success_message, 'admin/blogs', '200');
    }

    public function deleteBlog($blog_id)
    {
        Blog::destroy($blog_id);
        return $this->return_output('flash', 'success', 'Blog deleted successfully', 'admin/blogs', '200');
    }

}
