<?php

    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);

    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php, .class.php');
    
    function entra( $class, $ruta=NULL){
        if ($ruta==Null) {$ruta="./";}

        $filename = $class . '.php';
        $file =$ruta . $filename;
        if (file_exists($file)){
            include $file;
            return TRUE;
        }
        if ($dh = opendir($ruta)) {
            while (($file = readdir($dh)) !== false) {
                if (is_dir($ruta . $file) && $file!="." && $file!=".."){
                    if (entra($class, $ruta . $file . "/")){
                        closedir($dh);
                        return TRUE;
                    }
                }
            }
            closedir($dh);
        }
        return FALSE;
    }

    /*** register the loader functions ***/

    /*
     * WEB APP
     */
      spl_autoload_register('entra');