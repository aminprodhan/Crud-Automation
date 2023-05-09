<?php
    namespace Aminpciu\CrudAutomation\app\Interfaces;
    interface CrudInterface{
        public function indexQuery($formInfo);
        public function store();
    }
?>
