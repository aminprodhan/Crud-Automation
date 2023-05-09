<?php
    namespace Aminpciu\CrudAutomation\app\Interfaces;
    interface BaseInterface{
        public function save($data=[]);
        public function delete($id);
        public function paginate();
        public function get();
    }
?>
