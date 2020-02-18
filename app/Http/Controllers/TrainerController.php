<?php

namespace LaraDex\Http\Controllers;

use LaraDex\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaraDex\Http\Requests\StoreTrainerRequest;


class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sessionChecker($session){
        if (empty($session)){
            return false;
        } else {
            return true;
        }
    }
    public function index(Request $request)
    {
        if($this->sessionChecker($request->user())){
            $request->user()->authorizeRole(['user', 'admin']);

            $trainers = Trainer::all();

            return view('trainers.index', compact('trainers'));
        }
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainerRequest $request)
    {
        //return $request->all();
        //return $request->input('name');
        
        //return $request;

        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images', $name);
        }
        
        $trainer = new Trainer();
        $trainer->name = $request->input('name');
        $trainer->slug = $request->input('slug');
        $trainer->avatar = $name;
        $trainer->description = $request->input('description');
        $trainer->save();
        //return 'Saved';
        return redirect()->route('trainers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        //$trainer = Trainer::find($id);
        //$trainer = Trainer::where('slug','=',$slug)->firstOrFail();
        return view('trainers.show', compact('trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        $trainer->fill($request->except('avatar'));
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $name = time().$file->getClientOriginalName();
            $trainer->avatar = $name;
            $file->move(public_path().'/images/', $name);
        }
        $trainer->save();
        //return 'Actualizado';
        return redirect()->route('trainers.show', [$trainer])->with('status','Entrenador actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        $file_path = public_path().'/images/'.$trainer->avatar;
        \File::delete($file_path);
        $trainer->delete();
        //return 'Deleted';
        return redirect()->route('trainers.index');
    }
}
