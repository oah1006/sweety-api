<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Actions\UploadFileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staff\CreateStaffRequest;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStaffRequest $request)
    {
        $data = $request->validated();

        $code = fake()->numerify('NV####');

        $data['password'] = bcrypt($data['password']);
        $data['code'] = $code;

        $staff = Staff::create($data);
        $token = $staff->createToken('apitoken');

        if ($request->hasFile('avatar')) {
            UploadFileAction::run($request->file('avatar'), $staff, 'avatars');
        }

        $staff = $staff->fresh();

        return response()->json([
            'staff' => $staff,
            'token' => $token
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
