<?php
    namespace Aminpciu\CrudAutomation\app\Interfaces;
    interface CrudApiInterface{
        public function setFormId($id);
        public function paginate($params=[]);
        public function get($params=[]);
    }
?>
