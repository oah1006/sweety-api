<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Actions\UploadAttachmentAction;
use App\Enums\AttachmentTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staff\CreateStaffRequest;
use App\Http\Requests\Admin\Staff\UpdateStaffRequest;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $staff = Staff::with('user', 'store');

        $keyword = $request->keywords;

        $staff->when($keyword, fn (Builder $query)
                    => $query->whereFullText('full_name', $keyword)
                ->orWhere('code', $keyword)
                ->orWhereHas('user', fn (Builder $query)
                    => $query->whereFullText(['address', 'phone_number', 'email'], $keyword)));

        if ($request->filled('role')) {
            $role = $request->role;

            $staff->where('role', $role);
        }

        if ($request->filled('status')) {
            $status = $request->status;

            $staff->where('is_active', $status);
        }

        if ($request->filled('store_id')) {
            $storeId = $request->store_id;

            $staff->where('store_id', $storeId);
        }

        $staff = $staff->paginate(5);

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateStaffRequest $request)
    {
        $this->authorize('create', Staff::class);

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
                'role' => $staff->role,
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Staff $staff)
    {
        $staff->load('user');

        $staff->load('attachment');

        $staff->load('store');

        return response()->json($staff);
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
        $this->authorize('update', $staff);

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
                'is_active' => $staff->is_active,
                'role' => $staff->role,
                'user' => [
                    'email' => $staff->user->email
                ],
                'attachments' => $staff->attachment
            ],
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('delete', $staff);

        $staff->delete();

        return response()->noContent();
    }
}
