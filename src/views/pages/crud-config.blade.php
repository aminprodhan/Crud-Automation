
<?php
    use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
    $bladeName=CommonTrait::getBladeInfo();
?>
@extends($bladeName)
@section('title','Dynamic Crud Config')
@section ('content_page_amin_pciu')
@include('lca-amin-pciu::styles.common')
<div class="mt-2">
    <div class="card">
        <h5 class="card-header">
            <div class="d-flex">
                <div class="flex-grow-1">
                    Dynamic Crud Config
                </div>
                <div class=""></div>
            </div>
        </h5>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-6 mx-auto">
                    <form
                        id="crudForm"
                        method="post"
                        action="{{route('crud-automation.aminpciu.store')}}"
                        enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-10 col-lg-10">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text form_label_width">
                                            <span class="form_label_required">*</span> Navbar Title
                                        </span>

                                        <input
                                            name="navbar_title"
                                            placeholder="Navbar Title"
                                            value="<?=$config->navbar_title ?? '' ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-10 col-lg-10">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text form_label_width">
                                            Master Blade(Extends Name)
                                        </span>
                                        <input
                                            name="master_blade"
                                            placeholder="Master Blade"
                                            value="<?=$config->master_blade ?? '' ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-10 col-lg-10">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text form_label_width">
                                            Middleware Name
                                        </span>
                                        <input
                                            name="middleware_name"
                                            placeholder="middleware1,middleware2"
                                            value="<?=$config->middleware ?? '' ?>"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-10 col-lg-10">
                                    <div class="input-group mb-1">
                                        <span class="">
                                            &nbsp;
                                        </span>
                                        <button
                                            class="btn btn-primary btn-sm btn-block"
                                            type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_script_amin_pciu')
    <script>
        $('#crudForm').on('submit', function(event){
            event.preventDefault();
            var d = $(this).serializeArray();
            var url=$(this).attr("action");
            const callback = data => {
                const successAlert={
                    title: 'Success',
                    html:'',
                    confirmButtonText:'OK',
                    callback:(res) => {
                        if(res){
                            window.location.reload();
                        }
                    }
                    //loader:true,
                };
                customAlertCrudAuto(successAlert);
            }
            const handleError=(error)=>{
                console.log("error=",error.responseJSON.errors);
                const errors=error.responseJSON.errors;
                let html='';
                for(error in errors){
                    errors[error].map(row => {
                        console.log("error=",row);
                        html+=`<p style='margin:0;padding:0'>${row}</p>`;
                    });
                }
                const errorAlert={
                    icon: 'error',
                    title: 'Oops...',
                    html:html,
                    confirmButtonText:'Cancel',
                    confirmButtonColor: '#3085d6',
                    callback:(res) => {
                        console.log("callback=",res);
                    }
                    //loader:true,
                };
                customAlertCrudAuto(errorAlert);
            }
            ajaxCallWithFormDataCrudAuto(url, 'POST', new FormData(this), callback,handleError);
        });
    </script>
@endsection
