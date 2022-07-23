<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Undocumented function
     *
     * @return mixed
     */
    public function all()
    {
        return $this->user->with('address')->get();
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->user->with('address')->find($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return User
     */
    public function create($request)
    {

        $user = $this->user->create($request->safe()->all());
        !$request->input('address') ?: $this->HandleAddress($user, $request->address);
        return $user;
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @param integer $id
     * @return void
     */
    public function update($request, int $id)
    {
        $user = $this->find($id)->update($request->safe()->all());
        $request->input('address') ?: $this->HandleAddress($user, $request->address);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $this->find($id)->delete();
    }

    /**
     * Undocumented function
     *
     * @param [type] $address
     * @return void
     */
    public function HandleAddress($user, $address)
    {
        $data = array(["user_id" => $user->id], $address);
        $user->address()->updateOrCreate($data);
    }
}
