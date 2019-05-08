<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/** Use TicTacToe Main Helper Here */
use App\Helpers\TicTacToe;

class BoardController extends Controller
{
    /**
     * Show the game board.
     *
     */
    public function index()
    {
        $board = [];
        return view('index',compact('board'));
    }

    /**
     * Handle Ajax Submit Box (When box is clicked)
     * @param Illuminate\Http\Request
     * @return array json array_game
     */
    public function ajaxSubmitBox(Request $request)
    {
        $box   = $request->box;
        $game  = new TicTacToe($box);
        $game->scanBoard();
        
        $array_game = [
            'board'  => view('board',['board' => $game->board])->render(),
            'status' => $game->status,
            'possible' => $game->possibleMove
        ];

        return json_encode($array_game);
    }
}
