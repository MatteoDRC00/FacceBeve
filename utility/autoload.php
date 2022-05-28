<?php

function my_autoload($className) {

    $firstLetter = $className[0];
    switch ($firstLetter) {
        case 'E':
            include_once( 'Entity/'. $className . '.php' );
            break;

        case 'F':
            include_once( 'Foundation/'. $className . '.php' );
            break;

        case 'V':
            include_once( 'View/'. $className . '.php' );
            break;

        case 'C':
            include_once( 'Controller/'. $className . '.php' );
            break;

   /*     case 'I':
            include_once( $className . '.php' );
            break;*/

    }
  }
}

spl_autoload_register('my_autoload');

?>
