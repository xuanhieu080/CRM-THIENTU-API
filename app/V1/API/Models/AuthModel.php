<?php

namespace App\V1\API\Models;


use App\Jobs\SendMail;
use App\Models\PasswordReset;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Supports\CRM;
use App\Supports\CRM_ERROR;
use App\V1\API\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthModel extends AbstractModel
{

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $model = new User();
        parent::__construct($model);
    }


    public function login($input)
    {
        try {
            $user = User::where('email', $input['email'])
                ->orWhere('username', $input['email'])->first();
            if (!$user || !Hash::check($input['password'], $user->password)) {
                return response()
                    ->json(['errors' => [
                        'password' => ['Mật khẩu không đúng']
                    ]], 422);
            }


            $authToken = $user->createToken('apiToken');
            $token = $authToken->plainTextToken;


        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
        return response()->json(['token' => $token, 'token_type' => 'Bearer']);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }

    public function forgot($input)
    {
        try {
            $token = CRM::genCode('password_reset_tokens', 'token', 60);
            PasswordResetToken::updateOrCreate(
                ['email' => $input['email']],
                [
                    'email'      => $input['email'],
                    'token'      => $token,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);

            $user = User::whereEmail($input['email'])->first();
            $url = env('UI_LINK', 'https://hegka.com') . "/reset-password/$token";
            $details['email_address'] = 'no-reply@hegka.com';
            $details['mailer'] = 'smtp-no-reply';
            $details['to'] = $user->email;
            $details['view'] = 'emails.auth.forgot-password';
            $details['subject'] = "Thay đổi mật khẩu Hegka";
            $details['user'] = $user->toArray();
            $details['link'] = $url;

            dispatch(new SendMail($details));
            return response()->json(['message' => "Hướng dẫn cấp lại mật khẩu đã được gửi!"]);

        } catch (\Exception $exception) {
            $response = CRM_ERROR::handle($exception, 'unknown');
            return response()->json(['message' => $response['message']],400);
        }
    }

    public function newPassword($input)
    {
        try {
            DB::beginTransaction();
            $item = PasswordResetToken::whereToken($input['token'])->first();

            if (empty($item)) {
                throw new \Exception('Token không tồn tại!',404);
            }
            if (!empty($item) && (strtotime($item->created_at) + 600) < time()) {
                throw new \Exception('Token đã hết hạn!');
            }
            $containsUpper = preg_match('/[A-Z]/', $input['password']);
            $containsLower = preg_match('/[a-z]/', $input['password']);
            $containsNumber = preg_match('/[0-9]/', $input['password']);
            $containsDigit = preg_match('/\d/', $input['password']);
            $containsSpecial = preg_match('/[^a-zA-Z\d]/', $input['password']);

            if (strlen($input['password']) < 8 || !$containsDigit || !$containsUpper || !$containsLower || !$containsNumber || !$containsSpecial) {
                return response()->json(['errors' => ['password' => [__("Password has at least one number, special char, upper case, lower case and greater than 8 digits!")]]], 422);
            }
            $user = User::whereEmail($item->email)->first();
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
            $user->tokens()->delete();

            $authToken = $user->createToken('apiToken');
            $token = $authToken->plainTextToken;

            $url = env('UI_LINK', 'https://hegka.com'). '/login';
            $details['email_address'] = 'no-reply@hegka.com';
            $details['mailer'] = 'smtp-no-reply';
            $details['to'] = $user->email;
            $details['view'] = 'emails.auth.new-password';
            $details['subject'] = "Đặt lại mật khẩu thành công";
            $details['user'] = $user->toArray();
            $details['link'] = $url;

            dispatch(new SendMail($details));
            $item->delete();
            DB::commit();
            return response()->json(['message' => __('passwords.success'), 'user' => new UserResource($user), 'token' => $token]);
        } catch (\Exception $exception) {
            DB::rollBack();
            $response = CRM_ERROR::handle($exception, 'unknown');
            return response()->json(['message' => $response['message']], 400);
        }
    }
}
