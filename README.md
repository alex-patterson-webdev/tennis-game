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
    
Once created, we can record scores for `PlayerOne` and `PlayerTwo` by calling either `playerOneWinsShot()` or `playerTwoWinsShot()`.
Internally the `TennisGame` class will keep a record of each player's score, regardless of the order of the winning shots.

    $tennisGame->playerOneWinsShot(); // Increase PlayerOne score by 1 point
    $tennisGame->playerTwoWinsShot(); // Increase PlayerOne score by 1 point
    
By default, score for both players start at a value of `love` (zero). At any time we can review the score of each 
of the players by calling the `renderScore()` method. The score for both players will be returned as a string, `x-y` 
where `x` represents the first players' score and `y` represents the seconds players' score.
    
    echo $tennisGame->renderScore(); // output string 'love-love'
    
    $tennisGame->playerOneWinsShot();
    echo $tennisGame->renderScore(); // output string 'fifteen-love'
    
    $tennisGame->playerTwoWinsShot();
    echo $tennisGame->renderScore(); // output string 'fifteen-fifteen'
    
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
    $tennisGame->playerTwoWinsShot(); // advantage PlayerOne
        
    echo $tennisGame->renderScore(); // output string 'advantage PlayerTwo';

In order to win the game, players must have a score which exceeds `forty` points and have at least two points more than the competing player.
Calls to `renderScore()` will show the name of the player who is the winner. 

    $tennisGame->playerOneWinsShot(); // 15

    $tennisGame->playerTwoWinsShot(); // 15
    $tennisGame->playerTwoWinsShot(); // 30
    $tennisGame->playerTwoWinsShot(); // 40
    $tennisGame->playerTwoWinsShot(); // win
        
    echo $tennisGame->renderScore(); // output string 'win PlayerTwo';

## Unit Tests

Unit test can be run using [PHPUnit](https://phpunit.de/).

    php vendor/bin/phpunit
