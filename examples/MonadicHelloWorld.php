<?php
require_once __DIR__.'/../src/Monadic.php' ;
require_once __DIR__.'/../src/IO.php' ;


$io = new IO( "hello world" );

$io = $io
    ->shove()
    ->pipe(
        function( $string ) {
            return preg_replace( '/h/', 'ch', $string );
        }
    )->retrn();

$ioAction = IO::out( $io );

$ioAction->execute();
