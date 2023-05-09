<?php
    namespace Aminpciu\CrudAutomation\app\Repository;
    use Aminpciu\CrudAutomation\app\Interfaces\BaseInterface;
    class BaseRepository implements BaseInterface{
        protected $model;protected $rowPerPage=100;
        protected $requestData=null;protected $modelElo;
        public function setRequest($data){
            $this->requestData=$data;
            return $this;
        }
        public function getModel(){
            return $this->modelElo;
        }
        public function setModel($model){
            $this->modelElo=$model;
            $this->model=$model::query();
            return $this;
        }
        public function getQuery(){return $this->model;}
        public function setQuery($query){
            $this->model=$query;
        }
        public function save($data=[]){

        }
        public function delete($id){
            $this->model->find($id)->delete();
            return 1;
        }
        public function paginate(){
            return $this->model->paginate($this->rowPerPage);
        }
        public function get(){
            return $this->model->get();
        }
    }

?>
