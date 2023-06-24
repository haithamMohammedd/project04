<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count =5;
        if(request()->has('items_count')){
            $count = request('items_count');
        }

        $courses = Course::orderBy('id','Asc')->paginate($count);
        if(request()->has('name')){
            $courses = Course::orderBy('id','Asc')->where('name','like','%'.request()->name .'%')->paginate($count);
        }

        return view('courses.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','max:10'],
            'price'=>['required','numeric'],
            'image'=>['required','image','mimes:png,jpg,svg,gif'],
            'description'=>['max:400']
        ]);

        //image Upload
        $imagename = 'courses_'.time().rand().request()->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads'),$imagename);

        Course::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'image'=>$imagename,
            'description'=>$request->description,
        ]);

        return redirect()->route('courses.index')->with('msg','Course added successfuly')->with('type','success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>['required','max:10'],
            'price'=>['required','numeric'],
            'image'=>['image','mimes:png,jpg,svg,gif'],
            'description'=>['max:400']
        ]);

        $course = Course::find($id);
        $imagename = $course->image;

        if($request->hasFile('image')){
                //image Upload
            $imagename = 'courses_'.time().rand().request()->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'),$imagename);
        }

        $action = $course->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'image'=>$imagename,
            'description'=>$request->description,
        ]);

        if($action){
            return redirect()->route('courses.index')->with('msg','Course updated successfuly')->with('type','success');
        }else{
            return redirect()->route('courses.index')->with('msg','Course updated successfuly')->with('type','success');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::destroy($id);
        return redirect()->route('courses.index')->with('msg','Course deleted successfuly')->with('type','danger');
    }
}
