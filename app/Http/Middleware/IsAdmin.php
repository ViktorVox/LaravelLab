<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, что юзер авторизован И его роль == admin
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request); // Разрешаем "проход"
        }

        // Иначе, не пускаем
        return response()->json([
            'status'    => 'error',
            'message'   => 'Доступ запрещен. Только для администратора'
        ], 403);
    }
}
