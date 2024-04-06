<?php


use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

it('handle data on  add user', function(){

    $user = User::factory();

    // $request = new UserStoreRequest($user);


    //expect(Validator::make($request->all(), $request->rules()))->toBeTrue();
});
