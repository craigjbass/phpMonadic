<?php
/**
 * Xi2.
 * License: GPLv2/BSD
 * User: craigjbass
 * Date: 05/11/12
 * Time: 21:45
 */
abstract class Monadic
{

    /* @var array */
    private $piped = array();

    abstract protected function _shove();

    abstract protected function _retrn();

    /**
     *
     *
     * @param callable $closure
     * @return void
     */
    private function pipe( \Closure $closure )
    {

        $this->piped[] = $closure;

    }

    /**
     * @return MonadicShover
     */
    public function shove()
    {

        return new MonadicShover(
            function( \Closure $closure ) {
                $this->pipe( $closure );
            },
            function( ) {
                return $this;
            }
        );


    }

    /**
     * @return $this
     * @throws Exception
     */
    public function execute()
    {
        $shove = $this->_shove();
        $_retrn = $this->_retrn();

        $workingValue = $shove( $this );

        foreach( $this->piped as $pipable )
        {

            $newValue = $pipable( $workingValue );

            //The God condition.
            if( !( ( !is_object( $workingValue ) && ( gettype( $workingValue ) === gettype( $newValue ) ) )
                || ( is_object( $workingValue ) && is_object( $newValue ) && get_class( $workingValue ) === get_class( $newValue ) )
                || !( is_object( $workingValue ) ^ is_object( $newValue ) ) ) ){

                throw new Exception();
            }

            $workingValue = $newValue;

        }

        return $_retrn( $workingValue );

    }

}

class MonadicShover {


    /* @var \Closure */
    private $_pipe;

    /* @var \Closure */
    private $_return;

    public function __construct( \Closure $pipe, \Closure $return )
    {

        $this->_pipe = $pipe;
        $this->_return = $return;

    }

    /**
     * @param callable $closure
     * @return $this
     */
    public function pipe( \Closure $closure )
    {
        $_pipe = $this->_pipe;

        $_pipe( $closure );

        return $this;
    }

    public function retrn()
    {

        $_return = $this->_return;

        return $_return();

    }


}
