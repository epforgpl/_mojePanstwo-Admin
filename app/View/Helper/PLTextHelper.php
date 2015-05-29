<?php

App::uses('AppHelper', 'View/Helper');

class PLTextHelper extends AppHelper {

    public function date($data, $options = array() ) {
        $_data = $data;
        $_parts = explode(' ', $data);

        if(strpos($_parts[0], '/')) {
            $parts = explode( '/', $_parts[0] );
            $data  = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $timestamp = strtotime( $data );
        if ( ! $timestamp ) {
            return false;
        }

        $data = date( 'Y-m-d', $timestamp );

        if ( $data == date( 'Y-m-d', time() ) ) // TODAY
        {
            $str = 'dzisiaj';

        } else {

            $___vars = array(
                'miesiace' => array(
                    'celownik' => array(
                        1  => 'stycznia',
                        2  => 'lutego',
                        3  => 'marca',
                        4  => 'kwietnia',
                        5  => 'maja',
                        6  => 'czerwca',
                        7  => 'lipca',
                        8  => 'sierpnia',
                        9  => 'września',
                        10 => 'października',
                        11 => 'listopada',
                        12 => 'grudnia',
                    ),
                ),
            );

            $parts = explode( '-', substr( $data, 0, 10 ) );
            if ( count( $parts ) != 3 ) {
                return $data;
            }

            $dzien   = (int) $parts[2];
            $miesiac = (int) $parts[1];
            $rok     = (int) $parts[0];

            $str = $dzien . ' ' . $___vars['miesiace']['celownik'][$miesiac] . ' ' . $rok . '&nbsp;r.';
        }

        if(isset($_parts[1]))
            $str .= ' ' . $_parts[1];

        $output = '<span class="_ds"';

        if( isset($options['itemprop']) && $options['itemprop'] )
            $output .= ' itemprop="' . $options['itemprop'] . '"';

        $output .= ' datetime="' . strip_tags( $data ) . '">' . $str . '</span>';

        return $output;
    }

}