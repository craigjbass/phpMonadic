<?php
require_once __DIR__.'/Monadic.php';

class IO extends Monadic
{

    /* @var mixed */
    private $value;

    public function __construct( $value )
    {

        if( is_string( $value ) ) {
            $this->value = $value;
        } else if ( $value === null ) {
            $this->value = null;
        } else {
            throw new Exception();
        }

    }

    /**
     * @return \Closure
     */
    protected function _shove()
    {
        return function( IO $io ) {
            return $io->value;
        };
    }

    /**
     * @return \Closure
     */
    protected function _return()
    {
        return function( $value ) {
            return new self( $value );
        };
    }


    /* ==== Actions =================================================================================================*/

    /**
     * This is a really simplistic example uses this logic to do the same as echo (but deferred)
     *
     * @example
     * @throws Exception
     * @param string $string
     * @return $this
     */
    public static function out( IO $io )
    {

        return $io->shove()->pipe( function( $value ) {

            if( !is_string( $value ) ) {
                throw new Exception();
            }

            echo $value;

            return null;
        } )->retrn();

    }

}
