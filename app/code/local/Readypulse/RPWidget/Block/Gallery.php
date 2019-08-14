<?php

class Readypulse_RPWidget_Block_Gallery extends Readypulse_RPWidget_Block_Abstract implements Mage_Widget_Block_Interface {

    public function __construct() {
        parent::__construct();

        // set the template
        $this->setTemplate('rpwidget/gallery.phtml');
    }

}
