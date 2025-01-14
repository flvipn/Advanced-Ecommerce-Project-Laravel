<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
 
    public function CategoryView(){
        $category = Category::latest()->get(); // all the latest data cu variabila
        return view('backend.category.category_view', compact('category'));
    }

    public function CategoryStore(Request $request){
        

    	$request->validate([
    		'category_name_en' => 'required',
    		'category_name_ro' => 'required',
    		'category_icon' => 'required',
    	],[
    		'category_name_en.required' => 'Input category English Name',
    		'category_name_ro.required' => 'Input category Romanian Name',
    	]);

	category::insert([
		'category_name_en' => $request->category_name_en,
		'category_name_ro' => $request->category_name_ro,
		'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
		'category_slug_ro' => str_replace(' ', '-',$request->category_name_ro),
		'category_icon' => $request->category_icon,

    	]);

	    $notification = array(
			'message' => 'Category Inserted Successfully!',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }

    public function CategoryEdit($id){
    	$category = Category::findOrFail($id);
    	return view('backend.category.category_edit',compact('category'));

    }
    public function CategoryUpdate(Request $request){
        $cat_id = $request->id;
        Category::findOrFail($cat_id)->update([
            'category_name_en' => $request->category_name_en,
            'category_name_ro' => $request->category_name_ro,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_ro' => str_replace(' ', '-',$request->category_name_ro),
            'category_icon' => $request->category_icon,
    
            ]);
    
            $notification = array(
                'message' => 'Category Updated Successfully!',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.category')->with($notification);
    }

    public function CategoryDelete($id){
        Category::findOrFail($id)->delete();
            
        $notification = array(
            'message' => 'Category Deleted Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
