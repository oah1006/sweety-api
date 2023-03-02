<?php

namespace App\Http\Controllers\Staff;

use App\Actions\UploadAttachmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Enums\AttachmentTypes;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staff = Staff::query()->with('user');

        $keyword = $request->keyword;

        $staff->when($keyword, fn (Builder $query)
                    => $query->whereFullText('full_name', $keyword)
                ->orWhere('code', $keyword)
                ->orWhereHas('user', fn (Builder $query)
                    => $query->whereFullText(['address', 'phone_number'], $keyword)));

        $staff = $staff->paginate(8);

        return response()->json([
            'data' => $staff
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateStaffRequest $request)
    {
        $data = $request->validated();

        $staff = Staff::create($data);

        $staff->user()->create($data);

        if ($request->hasFile('avatar')) {
            UploadAttachmentAction::run([$request->file('avatar')], $staff, AttachmentTypes::AVATARS);
        }

        $staff = $staff->fresh();

        return response()->json([
            'data' => [
                'id' => $staff->id,
                'code' => $staff->code,
                'full_name' => $staff->full_name,
                'active' => $staff->is_active,
                'admin' => $staff->is_admin,
                'user' => [
                    'email' => $staff->user->email
                ],
                'attachments' => $staff->attachment
            ],
        ], 201);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->safe()->only(
            (new Staff)->getFillable()
        ));

        $staff->user()->update($request->safe()->only(
            (new User)->getFillable()
        ));

        $staff = $staff->fresh();

        return response()->json([
            'data' => [
                'id' => $staff->id,
                'code' => $staff->code,
                'full_name' => $staff->full_name,
                'active' => $staff->is_active,
                'admin' => $staff->is_admin,
                'user' => [
                    'email' => $staff->user->email
                ],
                'attachments' => $staff->attachment
            ],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return response()->noContent();
    }
}
