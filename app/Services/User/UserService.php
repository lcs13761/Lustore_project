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
     * @return void
     */
    public function create($request)
    {
        $this->user = $this->user->create($request->safe()->all());
        $request->get('address') ?: $this->HandleAddress($request->address);
        return $this->user;
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
        $this->user = $this->find($id)->update($request->safe()->all());
        $request->get('address') ?: $this->HandleAddress($request->address);
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
    public function HandleAddress($address)
    {
        $data = array(["user_id" => $this->user->id], $address);
        $this->user->address()->updateOrCreate($data);
    }
}
