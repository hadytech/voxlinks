<?php 

if (class_exists('RvxOxyElement')) {
    return;
}

Class RvxOxyElement{

    function __construct() {

        $this->load_files();

    }

    function load_files() {

        // Single Product
        include_once "elements/rvx-stats.class.php";
        include_once "elements/rvx-summary.class.php";
        include_once "elements/rvx-criteria-graph.class.php";
        include_once "elements/rvx-review-list.class.php";

        // auto include new elements
        $element_filenames = glob(plugin_dir_path(__FILE__)."elements/*.php");
        foreach ($element_filenames as $filename) {
            include_once $filename;
        }
        
    }

}