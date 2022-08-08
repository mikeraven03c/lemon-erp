<?php

namespace App\Packages\Users\Controllers;

use Illuminate\Http\Request;
use App\Packages\Users\Models\User;
use App\Packages\Users\Contracts\UserContract;
use App\Packages\Users\Resources\UserResource;
use App\Packages\Users\Requests\UserFormRequest;
use App\Packages\Users\DataTransferObjects\CreateUserData;
use App\Packages\Users\DataTransferObjects\UpdateUserData;

class UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->get();
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request, UserContract $userContract)
    {
        try {
            $user = $userContract->store(CreateUserData::fromAPI($request));
            return (new UserResource($user))->additional([
                'status' => 1,
                'message' => $user->name . config('message.store.positive')
            ]);
        } catch (\Exception $e) {
            return [
                'message' => $request->name . config('message.store.negative'),
                'status' => 0,
                'exception' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user, UserContract $userContract)
    {
        try {
            $user = $userContract->update($user, UpdateUserData::fromAPI($request));
            return (new UserResource($user))->additional([
                'status' => 1,
                'message' => $user->name . config('message.update.positive')
            ]);
        } catch (\Exception $e) {
            return [
                'message' => $request->name . config('message.update.negative'),
                'status' => 0,
                'exception' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UserContract $userContract)
    {
        $status = $userContract->delete($request->all());
        return [
            'status' => $status,
            'message' => $status ? config('message.delete.positive') : config('message.delete.negative')
        ];
    }
}
