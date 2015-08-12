<?php namespace Eduardostuart\Samba\API;

use Eduardostuart\Samba\API\APIBase;
use \HTML;

class Player extends APIBase {


    public function __construct( $config )
    {
        $this->config = $config;
    }


    public function show( $playerHash, $embedId, $attributes = array() )
    {

        $src = 'http://fast.player.liquidplatform.com/pApiv2/embed/' . $playerHash . '/' . $embedId;

        $attributes = array_merge(array(
            'width'       => '100%',
            'height'      => 390,
            'scrolling'   => 'no',
            'frameborder' => '0',
            'src'         => $src
        ), $attributes );

        return '<iframe ' . HTML::attributes( $attributes ) . '></iframe>';
    }

}