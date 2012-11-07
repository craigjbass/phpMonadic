<?php
class Model_Example
{

    /*
     * These functions are dummy functions and are meant to represent the concept of a DB connection
     */
    /**
     * @return array
     */
    public function getAggregateForId( $id )
    {
        sleep( 5 ); //Simulating an expensive operation
        return array(
            'foo' => 'bar',
            'cheese' => 'cheddar'
        );
    }

    public function getId( $id ) {

        $array = [ 'name' => 'dark'.$id, 'id' => $id, 'expand' => false ];

        if( $id == 2 ) {
            $array['expand'] = true;
        }

        return $array;

    }

    public function getAvailableIds()
    {
        return array(
            1,
            2,
            6,
            9
        );
    }

    /*
     * End dummy functions
     */



}
