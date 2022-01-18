<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User\UserRepositoryInterface;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UsersLoginRequest;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login User.
     *
     * @return \Illuminate\Http\Requests\UsersLoginRequest
     */
    public function index(UsersLoginRequest $request)
    {
        $validated = $request->validated();

        if (!auth()->attempt($validated)) {
            return response([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        "These credentials do not match our records."
                    ]
                ]
            ],422);
        }

        $token = auth()->user()->createToken('user');
        return response([
            'token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_at' => $token->token->toArray()['expires_at']
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
     * @param  \Illuminate\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userRepository->create($validated);
        return response()->json($user, 201);
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
    public function destroy()
    {
        if (auth()->check()) {
            auth()->user()->AauthAcessToken()->delete();
        }
        return response()->json([
            "message" => "Logged out successfully"
        ]);
    }
}
