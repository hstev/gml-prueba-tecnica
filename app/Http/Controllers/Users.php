<?php

namespace App\Http\Controllers;

use App\Events\AdminReportByCountry;
use App\Events\UserRegistered;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('category')->orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {        
        
        $validated = $request->validated();
        if ($validated) {
            if ($request->has('id')) {
                User::
                where(['id' => $request->id])
                ->update(
                    [
                        'name'         => $request->name, 
                        'last_name'    => $request->last_name,
                        'document'     => $request->document,
                        'email'        => $request->email,
                        'phone_number' => $request->phone_number,
                        'category_id'  => $request->category_id,
                        'country'      => $request->country,
                        'address'      => $request->address
                    ]
                );
            }
            else {
                $user = User::create(
                    [
                        'name'         => $request->name, 
                        'last_name'    => $request->last_name,
                        'document'     => $request->document,
                        'email'        => $request->email,
                        'phone_number' => $request->phone_number,
                        'category_id'  => $request->category_id,
                        'country'      => $request->country,
                        'address'      => $request->address
                    ]
                );
                $this->registered($user);
            }
        }
    }

    public function totalUsersByCountry(): array
    {
        return User::select('country')
        ->selectRaw("COUNT('country') AS total")
        ->groupBy('country')
        ->get();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['deleted' => TRUE]);
    }

    protected function registered(User $user)
    {
        event(new UserRegistered($user));
        event(new AdminReportByCountry($user));
    }
}
