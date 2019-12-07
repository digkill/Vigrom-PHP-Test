<?php

namespace App\Http\Middleware;

use App\Enum\UserRole;
use Closure;

class AccessChecker
{
  private $commonAccessible = [
    '*:api/auth/*',
    'patch:api/admin/users/fcm/*',
    '*:api/test/*',
    '*:api/test',
    '*:uploads/*',
    '*:api/paypal/*',
    '*:api/users/*',
  ];

  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    $routeCheckList = [
      UserRole::ADMIN => [
        '*:api/admin/*',
        '*:api/soldiers/*'
      ],


    ];

    $requestMethod = strtolower($request->method());
    $requestPath = $request->path();
    $checkUrl = "$requestMethod:$requestPath";

    $replacements = [
      '/' => '\/',
      '*' => '.*'
    ];

    $userRole = $request->user()->role ?? null;
    $patternsByRole = isset($routeCheckList[$userRole]) ? $routeCheckList[$userRole] : [];
    $patternsByRole = array_merge($patternsByRole, $this->commonAccessible);

    foreach ($patternsByRole as $pattern) {
      $pattern = strtr($pattern, $replacements);
      if (preg_match("/^$pattern$/", $checkUrl)) {
        return $next($request);
      }
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }
}
