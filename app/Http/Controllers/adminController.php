<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class adminController extends Controller
{
    protected $users;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }
    public function index()
    {
       // $usersarray = User::all();
       $usersarray = $this->users->all();

        return view('admin.index', ['usersarray' => $usersarray]);
        // return view('admin.index', compact('usersarray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $userarray=new User();
        // $userarray->edit($id);
        //  $userarray = User::where('Id', $user)->first();
       // $userarray = User::where('Id', $id)->first();
        $userarray = $this->users->where('id',$id)->first();
        return view('admin.edit', compact('userarray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required', 'email:rfc,dns',
                //Rule::unique('users')
               Rule::unique('users')->ignore($id),
            ],
        ]);

        $userarray = User:: where('id', $id)->first();

        $userarray->name = $request->get('name');
        $userarray->email = $request->get('email');

        $userarray->save();

        return redirect('/admin/user')->with('success', 'User-data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/admin/user')->with('success', 'userdata deleted successfully');
    }
}
