<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckKickoffTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

       Log::info('inside middleware check kick off time');
        $gameId = $request->input('game_id');



        $kickoffTime = DB::table('games')
            ->where('id', $gameId)
            ->value('kick_off_time');


        $currentTime = (int) round(microtime(true) * 1000);



        if ($currentTime > $kickoffTime) {
            return response()->json(['status' => 403, 'message' => 'You cannot update predictions after the kickoff time has passed.'], 403);
        }


        return $next($request);
    }
}
