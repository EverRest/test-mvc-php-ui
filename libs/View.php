<?php
class View {

    public static $data = false;

    public function __construct()
    {
    }

    public function assign($data = false) {

        self::$data = $data;
    }
    public function render($name, $noInclude = false) {

        if($noInclude == true) {
            require 'views/'.$name.'.php';
        } else {
            require 'views/header.php';
            require 'views/'.$name.'.php';
            require 'views/footer.php';
        }
    }
}
?>