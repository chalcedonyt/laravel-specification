<?php
spl_autoload_register(function ($class) {
    if( strpos($class, 'DummySpecifications\\') === 0 ){
        include __DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR,$class). '.php';
    }
});
?>
