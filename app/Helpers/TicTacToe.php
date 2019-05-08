<?php

namespace App\Helpers;

class TicTacToe 
{
    /**
     * Declare public variable
     */
    public $player   = 'X';
    public $computer = 'O';
    public $board    = [];
    public $status   = [
        'gameOver' => false,
        'winner'   => null,
        'tie'      => false
    ];
    public $possibleMove = [];

    /**
     * handle constructor
     * @param array selected box ($boxed)
     * @return void
     */
    public function __construct($boxed)
    {
        $this->board = $boxed;
    }

    /**
     * handle scan board array
     * @return array 
     */
    public function scanBoard()
    {
        if($this->winCondition($this->board, $this->player))
        {
            $this->status['gameOver'] = true;
            $this->status['winner'] = 'Player';
        }
        else
        {
            if(empty($this->possibleMoves()))
            {
                $this->status['gameOver'] = true;
                $this->status['tie'] = true;
            }else{
                $nextMove = $this->AIMoves();
                if($nextMove)
                {
                    $this->makeMove($this->computer, $nextMove);
                    if($this->winCondition($this->board, $this->computer))
                    {
                        $this->status['gameOver'] = true;
                        $this->status['winner'] = 'AI';
                    }
                }
            }
        }
        $this->possibleMove = $this->possibleMoves();

        return $this;
    }

    /**
     * Handle check win condition
     * @param array $box
     * @param array $player
     * @return bool condition win or not (true/false)
     */
    public function winCondition($box, $player)
    {
        $case = 
        // Top
        ( $box['a'] == $player && $box['b'] == $player && $box['c'] == $player ) ||
        // Midle Horizontal
        ( $box['d'] == $player && $box['e'] == $player && $box['f'] == $player ) ||
        // Bottom
        ( $box['g'] == $player && $box['h'] == $player && $box['i'] == $player ) || 
        // Left
        ( $box['a'] == $player && $box['d'] == $player && $box['g'] == $player ) ||
        // Midle Vertical
        ( $box['b'] == $player && $box['e'] == $player && $box['h'] == $player ) ||
        // Right
        ( $box['c'] == $player && $box['f'] == $player && $box['i'] == $player ) ||
        // Diagonal 'b'
        ( $box['a'] == $player && $box['e'] == $player && $box['i'] == $player ) ||
        // Diagonal 'c'
        ( $box['c'] == $player && $box['e'] == $player && $box['g'] == $player );

        return $case;
    }

    /**
     * handle make move board
     * @param string player 
     * @param integer $position
     * @return void
     */
    public function makeMove($player, $position)
    {
        $this->board[$position] = $player;
    }

    /**
     * Detect possible move
     * @return array array of empty slot to move
     */
    protected function possibleMoves()
    {
        $empty = array_filter($this->board, function($space)
        {
            return $space == '';
        });

        return array_keys($empty);
    }

    /**
     * Handle move list and return shuffled one
     * @param array of available move option
     * @return integer shuffled one
     */
    protected function shuffleMove($moves)
    {
        $toShuffle = $moves;
        shuffle($toShuffle);
        return $toShuffle[0];
    }

    /**
     * Computer Movement
     * @return array next movement
     */
    protected function AIMoves()
    {
        $possibleMoves = $this->possibleMoves();

        foreach (['O', 'X'] as $tester) 
        {
            foreach ($possibleMoves as $moveIndex) 
            {
                $tryBoard = $this->board;
                $tryBoard[$moveIndex] = $tester;
                if($this->winCondition($tryBoard, $tester))
                {
                    $move = $moveIndex;
                    return $move;
                }
            }
        }

        if(in_array('e', $possibleMoves))
        {
            $move = 'e';
            return $move;
        }
        else
        {
            $OpenCorner = array_values(
                array_filter($possibleMoves, function($moves){
                    return in_array(intval($moves), ['a', 'c', 'g', 'i']);
                })
            );

            if(!empty($OpenCorner))
            {
                $move = $this->shuffleMove($OpenCorner);
                return $move;
            }
            else
            {
                $OpenEdge = array_values(
                    array_filter($possibleMoves, function($moves){
                        return in_array(intval($moves), ['b', 'd', 'f', 'h']);
                    })
                );

                if(!empty($OpenEdge))
                {
                    $move = $this->shuffleMove($OpenCorner);
                    return $move;
                }
            }
        }

    }

   
}
