<?php

namespace App\Http\Middleware;

use App\DataServer\Hybrid\UserService;
use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CheckUserToken
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'user/login',
        'user/logout',
        'user/register',
        'user/captcha',
        'user/captcha/*',
        'user/register/*',
        'user/resetPwd/*',
        'user/resetPwd',
        'user/checkMobileWhereFrom/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->shouldPassThrough($request)){
            $token = $request->header('token');
            if($token != config('app.token')) {
                //throw new UnauthorizedHttpException('Basic realm="My Realm"','need Token');
                return makeFailedMsg("need auth");
            }
            // 保存用户
            $user = [
                "id" => 1,
                "name" => "sam"
            ];
            \Cache::put($token, $user, 24*60);//缓存一天
        }
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through the verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }
        return false;
    }
}
