<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Game;
use Illuminate\Http\Request;
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

       
        $gameId = $request->get('game_id'); // Adjust this based on your route parameter name
        // dd($gameId);
        // Retrieve the game from the database
        $game = Game::findOrFail($gameId);

        // Check if kickoff time has passed or if it's null
        if ($game->kick_off_time === null || now()->gt($game->kick_off_time)) {
            return response()->json(['error' => 'Kickoff time has passed or not set yet','code' =>'403']);
        }

        // Allow the request to proceed
        return $next($request);
    }
}
