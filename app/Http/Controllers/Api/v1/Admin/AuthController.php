<?php
namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\UserService;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\v1
 */
class AuthController extends Controller
{
    public $successStatus = 200;

    private $modelName = "Auth";

    /**
     * Sign up new user
     *
     * @param Request $request
     * @param UserService $service
     * @param Logger $log
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(Request $request, UserService $service, Logger $log)
    {
        $params = $request->all();
        $model = $service->store($params);

        if ($model){
            $message = $this->modelName .' was successfully stored.';
            $log->info($message, ['id' => $model->id]);
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName.' was not stored.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, [
            'code' => 20000
        ]));
    }

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->all();
        if(Auth::attempt(['email' => $data['username'], 'password' => $data['password']])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response($this->successResponse(
                $this->modelName,
                $success)
            );
        }
        else{
            return response()->json(
                $this->errorResponse($this->modelName, null, 'error','Unauthorised', 401),
                200
            );
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
}
