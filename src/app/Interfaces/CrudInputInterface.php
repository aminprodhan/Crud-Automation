<?php
    namespace Aminpciu\CrudAutomation\app\Interfaces;
    interface CrudInputInterface{
        public function store();
        public function remove();
        public function truncate();
        public function migrateFresh();
    }
?>
