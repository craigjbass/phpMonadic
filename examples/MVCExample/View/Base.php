<?php
class View_Base
{

    private $vars = [];

    private $appended = [];


    function &__get($name)
    {
        if( isset( $this->vars[$name] ) && ! $this->vars[$name] instanceof IO ) {
            return $this->vars[$name]; //This would purify the string/array/etc too, but this is a demo!
        }else{
            throw new Exception();
        }
    }

    function __set($name, $value)
    {
        $this->vars[ $name ] = $value;
    }

    function __isset($name)
    {
        return isset( $this->vars[$name] );
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    function __call( $name, $arguments )
    {
        if( isset( $this->vars[ $name ] ) && $this->vars[$name] instanceof IO ) {

            /* @var $io IO */
            $io = $this->vars[ $name];

            $io = $io->shove()->pipe(
                function( $value ) {
                    return htmlentities( $value );
                }
            )->retrn();

            return IO::out( $io )->evaluate();

        } else {
            throw new BadMethodCallException();
        }
    }


    public function append( $template )
    {
        $this->appended[] = $template;
    }

    public function render()
    {

        foreach( $this->appended as $template ) {
            require __DIR__ . '/' . $template;
        }

    }



}
