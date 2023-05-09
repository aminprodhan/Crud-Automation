<?php
    namespace Aminpciu\CrudAutomation\app\Repository;
    use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
    use Aminpciu\CrudAutomation\app\Interfaces\CrudApiInterface;
    use Aminpciu\CrudAutomation\app\Interfaces\CrudInterface;
    use Aminpciu\CrudAutomation\app\Models\DynamicCrudSetting;
    use Illuminate\Support\Facades\DB;
    class DynamicCrudRepository extends BaseRepository implements CrudApiInterface{
        private $form_data=null;private $crudRepo=null;
        public function __construct()
        {
            $this->setRequest(request());
            $this->crudRepo=new CrudRepository();
        }
        public function setFormId($id){
            $info=HelperTrait::getRouteInfo($this->requestData,$id);
            $form_data=$info['form_info'];
            $model=HelperTrait::getModelInfo($form_data);
            $this->setModel($model);
            $this->form_data=$form_data;
            $this->crudRepo->setModel($model)->indexQuery($form_data);
            return $this;
        }
        public function paginate($params=[]){
            if(!empty($params['row_per_page']))
                $this->rowPerPage=$params['row_per_page'];
            return $this->model->paginate();
        }
        public function get($params=[]){
            return $this->model->get();
        }
    }
