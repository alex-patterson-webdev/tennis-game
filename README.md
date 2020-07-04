[![Build Status](https://travis-ci.com/alex-patterson-webdev/tennis-game.svg?branch=master)](https://travis-ci.com/alex-patterson-webdev/tennis-game)
[![codecov](https://codecov.io/gh/alex-patterson-webdev/tennis-game/branch/master/graph/badge.svg)](https://codecov.io/gh/alex-patterson-webdev/tennis-game)

# Arp\TennisGame

## About

A PHP solution to the Tennis scoring challenge.

## Installation

Installation via [composer](https://getcomposer.org).

    require alex-patterson-webdev/tennis-game ^1
    
## Usage

In order to calculate the Tennis score, first create a new instance of the `Arp\TennisGame\TennisGame` class.

    use Arp\TennisGame\TennisGame;
    $tennisGame = new TennisGame();
    
Once created, we can record each player's shot score by calling either `playerOneWinsShot()` or `playerTwoWinsShot()`.
Internally the `TennisGame` class will keep a record of each player's score, regardless of the order of the winning shots.

    $tennisGame->playerOneWinsShot(); // Increase player one score by 1 point
    $tennisGame->playerTwoWinsShot(); // Increase player two score by 1 point
    
By default, score for both players start at a value of `love` (zero). At any time we can review the score of each 
of the players by calling the `renderScore()` method. The score for both players will be returned as a string, `x-y` 
where `x` represents the first players' score and `y` represents the seconds players' score.
    
    echo $tennisGame->renderScore(); // output string 'love-love'
    
    $tennisGame->playerOneWinsShot();
    echo $tennisGame->renderScore(); // output string 'fifteen-love'
    
    $tennisGame->playerTwoWinsShot();
    $tennisGame->playerOneWinsShot(); // output string 'fifteen-fifteen'
    
In accordance with the rules of Tennis, when players tie and have both reached a score of at least `forty`, then the result of 
the call to `renderScore()` will be `deuce`, indicating the scores are level.

    $tennisGame->playerOneWinsShot();
    $tennisGame->playerOneWinsShot();
    $tennisGame->playerOneWinsShot();
    
    $tennisGame->playerTwoWinsShot();
    $tennisGame->playerTwoWinsShot();
    $tennisGame->playerTwoWinsShot();
        
    echo $tennisGame->renderScore(); // output string 'deuce'
    
If the score is a tie at `deuce`, players must then score 1 additional point to gain an `advantage`. 
In these cases, calls to method `renderScore()` will display the player who has the current advantage.

    $tennisGame->playerOneWinsShot(); // 15
    $tennisGame->playerOneWinsShot(); // 30
    $tennisGame->playerOneWinsShot(); // 40
    
    $tennisGame->playerTwoWinsShot(); // 15
    $tennisGame->playerTwoWinsShot(); // 30
    $tennisGame->playerTwoWinsShot(); // 40 (Deuce)
    $tennisGame->playerTwoWinsShot(); // Advantage Player 2
        
    echo $tennisGame->renderScore(); // output string 'advantage player two';

In order to win the game, players must score a minimum of `forty` points and have at least two points more than the competing player.
Calls to `renderScore()` will show the winner in the same `x-y` string format. 

The example below show player two as the winner.

    $tennisGame->playerOneWinsShot(); // 15
    
    $tennisGame->playerTwoWinsShot(); // 15
    $tennisGame->playerTwoWinsShot(); // 30
    $tennisGame->playerTwoWinsShot(); // 40
    $tennisGame->playerTwoWinsShot(); // Player 2 Win
        
    echo $tennisGame->renderScore(); // output string 'fifteen-win';

## Unit Tests

Unit test can be run using [PHPUnit](https://phpunit.de/).

    php vendor/bin/phpunit
