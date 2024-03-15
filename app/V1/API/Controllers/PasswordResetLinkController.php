<?php


namespace App\V1\API\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\PasswordReset;
use App\Models\User;
use App\Supports\FORUM;
use App\Supports\FORUM_ERROR;
use App\V1\Mobile\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Send a reset link to the given user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ForgotPasswordRequest $request)
    {
        try {
            $input = $request->all();
            $token = FORUM::genCode('password_resets', 'token', 60);

//            $tokenReset = FORUM::encryptString($token, env('SECRET'), true);
            PasswordReset::where('email', $input['email'])->delete();
            PasswordReset::insert([
                'email'      => $input['email'],
                'token'      => $token,
                'created_at' => date('Y-m-d H:i:s', time())
            ]);
            $user = User::whereEmail($input['email'])->first();
            $url = env('UI_LINK','https://hegka.com'). "/reset-password/$token";
            $details['email_address'] = 'no-reply@hegka.com';
            $details['mailer'] = 'smtp-no-reply';
            $details['to'] = $user->email;
            $details['view'] = 'emails.users.forgot-password';
            $details['subject'] = "Thay đổi mật khẩu Hegka";
            $details['user'] = $user->toArray();
            $details['link'] = $url;

            dispatch(new SendEmailJob($details));

            return response()->json(['message' => __('passwords.sent')]);
        } catch (\Exception $exception) {
            $response = FORUM_ERROR::handle($exception, 'unknown');
            return response()->json(['message' => $response['message']],400);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker('users');
    }
}
