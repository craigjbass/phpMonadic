<?php
require_once __DIR__.'/../Model/Example.php';
require_once __DIR__.'/../View/Base.php';

class Controller_Example
{
    private $time;

    private $view = null;
    private $model = null;

    public function __construct()
    {
        $this->time = microtime( true );
        $this->view = new View_Base();
        $this->model = new Model_Example();

    }

    public function __destruct()
    {

        $this->view->render();
        echo number_format( (microtime(true)-$this->time) *1000, 3 ) . ' ms';
        echo '<br />'.(memory_get_peak_usage( true )*0.000976562*0.000976562) . 'MB';
        echo '<br />'.(memory_get_peak_usage( false )*0.000976562*0.000976562) . 'MB';
    }

    public function example()
    {

        $id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0;

        $this->view->availableIds = $this->model->getAvailableIds();

        $this->view->aggregateData = ( new IO(
                function() use ( $id ) {

                    $values = $this->model->getAggregateForId( $id );
                    return implode( ' ', $values );

                }
            ))->shove()
            ->pipe(
                function( $value )
                {
                    return preg_replace( '/cheddar/', 'cheddar is good', $value );
                }
            )->retrn();

        $this->view->title = "Id Data";

        if( $id > 0 ) {
            $this->view->theThing = $this->model->getId( $id );
        }

        $this->view->append( 'Example.phtml' );

    }

}
