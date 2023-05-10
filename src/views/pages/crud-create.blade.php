<?php
    use Aminpciu\CrudAutomation\app\Helper\CommonTrait;
    use Aminpciu\CrudAutomation\app\Helper\HelperTrait;
    $bladeName=CommonTrait::getBladeInfo();
?>
@extends($bladeName)
@section('title',$form_info->form_name)
@section ('content_page_amin_pciu')
    @include('lca-amin-pciu::styles.common')
    <style>
        {!!  strip_tags($form_info->style_custom->css ?? '') !!}
    </style>
    @php
        $form_class=str_replace(' ','_',$form_info->form_name);
        $col_per_row=6;
        if(!empty($form_info->style_custom->no_cols_per_row))
            $col_per_row=floor(12 / $form_info->style_custom->no_cols_per_row);
    @endphp
    <div class="mt-2 {{$form_class}}_main_div">
        <div class="card {{$form_class}}_card">
            <h5 class="card-header {{$form_class}}_card_header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        {{$form_info->form_name}}
                    </div>
                    <div class="">
                        <a
                            href="{{route($routeIndex.'.index')}}"
                            class="navbar-toggler" >
                            List
                        </a>
                    </div>
                </div>
            </h5>
            <div class="card-body {{$form_class}}_card_body">
                <form id="crudForm" method="post" action="{{route($routeIndex.'.store')}}" enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        @csrf
                        <input type="hidden" value="{{$form_info->id}}" name="form_id"/>
                        <input type="hidden" value="{{$editable->id ?? 0}}" name="update_id"/>
                        <div class="col-lg-{{$form_info->style_custom->offset}} mx-auto">
                            <div class="row">
                                @foreach ($form_info->form_details as $form)
                                    @if($form->display_type == 1 || $form->display_type == 4)
                                        @continue
                                    @endif
                                    @php
                                        $db_info=($form->db_info);
                                        $db_field_name=($form->db_info->field_name);
                                        $others=str_replace(' ','_',$form->label_name);
                                    @endphp
                                    <div class="col-12 col-sm-{{$col_per_row}} col-lg-{{$col_per_row}} col-md-{{$col_per_row}}">
                                        <div class="input-group mb-1">
                                            <span class="input-group-text form_label_width {{$form_class}}_label {{$form_class}}_{{$others}}_label" id="basic-addon1">
                                                @if (HelperTrait::hasRequiredInValidation($form->validation))
                                                    <span class="form_label_required">*</span>
                                                @endif
                                                {{$form->label_name}}
                                            </span>
                                            @if($form->input_type == 'checkbox' || $form->input_type == 'radio')
                                                @php
                                                    $is_list=HelperTrait::getSelectionFormData($form);
                                                @endphp
                                                @if (count($is_list) > 0)
                                                    @foreach($is_list as $key =>$input)
                                                        <input
                                                            class="{{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                            type="{{$form->input_type}}"
                                                            value="<?=$input->id ?? 0?>"
                                                            name="<?=$db_field_name?>" @if($editable && $editable->$db_field_name == $input->id) checked @elseif($key == 0) checked @endif /> {{$input->name}}
                                                    @endforeach
                                            @endif
                                            @elseif($form->input_type == 'selection')
                                                @php
                                                    //if($form->options_data_type == 1)
                                                    $options=HelperTrait::getSelectionFormData($form);
                                                @endphp
                                                <select
                                                    {{-- @if(HelperTrait::hasRequiredInValidation($form->validation))
                                                        required
                                                    @endif --}}
                                                    type="selection"
                                                    class="keyboard select2_custom_crud_auto {{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                    name="<?=$form->db_info->field_name ?? $others?>"
                                                    key='{{str_replace(' ','_',$form->label_name)}}'
                                                    selector_id="{{str_replace(' ','_',$form->event_actions->selector)}}-0"
                                                    id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                    @if(!empty($form->event_actions->name) && $form->event_actions->name == 'onchange')
                                                        onchange="handleChangeCrudAuto(this,{{$form->id}})"
                                                    @endif
                                                    event_keyup_mouseup_handle='change'
                                                    form_name_attr='crud_setup_form'>
                                                        @foreach ($options as $option)
                                                            <option @if ($editable && $editable->$db_field_name == $option->id)
                                                                selected
                                                            @endif value="{{$option->id}}">{{$option->name}}</option>
                                                        @endforeach
                                                </select>
                                            @elseif ($form->input_type == 'textarea')
                                                <textarea
                                                    key='{{str_replace(' ','_',$form->label_name)}}'
                                                    id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                    name="<?=$db_field_name ?? $others?>"
                                                    event_keyup_mouseup_handle='keyup'
                                                    class="form-control {{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                    form_name_attr='crud_setup_form'
                                                    placeholder="{{$form->label_name}}"
                                                    aria-label="{{$form->label_name}}"
                                                    aria-describedby="basic-addon1"
                                                    ><?=$editable->$db_field_name ?? ''?></textarea>
                                            @elseif($form->input_type == 'image_file')
                                                <input
                                                    type="file"
                                                    {{-- @if(HelperTrait::hasRequiredInValidation($form->validation))
                                                        required
                                                    @endif --}}
                                                    key='{{str_replace(' ','_',$form->label_name)}}'
                                                    id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                    name="<?=$db_field_name?>[]"
                                                    class="form-control {{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                    form_name_attr='crud_setup_form'
                                                    placeholder="{{$form->label_name}}"
                                                    aria-label="{{$form->label_name}}"
                                                    aria-describedby="basic-addon1" multiple />
                                            @elseif($form->input_type == 'auto_code')
                                                <span class="input-group-text {{$form_class}}_group_label {{$form_class}}_{{$others}}_label">
                                                    {{$db_info->auto_code->prefix ?? ''}}
                                                </span>
                                                @php
                                                    $code=$editable->$db_field_name ?? null;
                                                    $auto_code=null;
                                                    if(!empty($code))
                                                        {
                                                            $len=strlen($code);
                                                            $lenPre=strlen($db_info->auto_code->prefix);
                                                            $lenSuffix=strlen($db_info->auto_code->suffix);
                                                            $auto_code=substr($code,$lenPre,$len-$lenSuffix-$lenPre);

                                                            if(!is_numeric($auto_code))
                                                                $auto_code=null;
                                                            //dd($auto_code);
                                                        }

                                                        if(empty($auto_code)){
                                                            $auto_code=HelperTrait::generateAutoCode($form_info,$form->field_name);
                                                            //dd($u)
                                                        }

                                                @endphp
                                                <input
                                                    type="number"
                                                    class="form-control {{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                    key='{{str_replace(' ','_',$form->label_name)}}'
                                                    id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                    name="<?=$db_field_name ?? $others?>"
                                                    value="<?=$auto_code ?>"
                                                    >
                                                <span class="input-group-text {{$form_class}}_group_label {{$form_class}}_{{$others}}_label2">
                                                    {{$db_info->auto_code->suffix ?? ''}}
                                                </span>
                                            @else
                                                <input
                                                    type="{{$form->input_type}}"
                                                    {{-- @if(HelperTrait::hasRequiredInValidation($form->validation))
                                                        required
                                                    @endif --}}
                                                    @if($form->input_type == 'time' || $form->input_type == 'datetime-local')
                                                        min="00:00"
                                                        max="23:59"
                                                        step="1"
                                                    @endif
                                                    key='{{str_replace(' ','_',$form->label_name)}}'
                                                    id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                    name="<?=$db_field_name ?? $others?>"
                                                    value="<?=$editable->$db_field_name ?? ''?>"
                                                    event_keyup_mouseup_handle='keyup'
                                                    class="form-control {{$form_class}}_input {{$form_class}}_{{$others}}_input"
                                                    form_name_attr='crud_setup_form'
                                                    placeholder="{{$form->label_name}}"
                                                    aria-label="{{$form->label_name}}"
                                                    aria-describedby="basic-addon1" />
                                            @endif
                                        </div>
                                        @if(!empty($editable->$db_field_name) && $form->input_type == 'image_file')
                                            @php
                                                $files=json_decode($editable->$db_field_name);
                                            @endphp
                                            @foreach ($files as $file)
                                                <div>
                                                    <div>
                                                        <a target="_blank" href="{{ asset($form->db_info->file_location."/".$file) }}">
                                                            {{$file}}
                                                        </a>
                                                        <button
                                                            onclick="handleFileRemoveCrudAuto('<?=$db_field_name?>','<?=$file?>')"
                                                            type="button"
                                                            class="btn-close"
                                                            aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-{{$form_info->style_custom->offset}} mx-auto">
                            <div class="input-group mb-1">
                                <span class="form_label_width">
                                   &nbsp;
                                </span>
                                <button
                                    class="btn btn-primary btn-sm btn-block {{$form_class}}_button {{$form_class}}_{{$others}}_button" type="submit">Submit</button>
                            </div>
                        </div>
                      </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('lca-amin-pciu::scripts.common-script',["form_info"=>$form_info,"editable" => $editable])
@section("custom_script_amin_pciu")
    <script>
        var form_info=@json($form_info);
        var editable=@json($editable);
        let fileRemoveUrl=@json(route($routeIndex.".file-remove"));
        $(document).ready(function(){
            console.log('log',form_info);
            if(editable)
                dependenciesApiCrudAuto();
        });
        const handleFileRemoveCrudAuto=(name,file_name)=>{
            //console.log(routeIndex);
            let id=editable.id;
            const successAlert={
                    title: 'Confirmation',
                    html:'<h1>Are you sure to delete ?</h1>',
                    confirmButtonText:'Confirm',
                    showCloseButton:true,
                    showCancelButton:true,
                    callback:(res) => {
                        if(res){
                            ajaxCallCrudAuto(fileRemoveUrl,'post',{id:id,fileName:file_name,colName:name},
                            (res)=>{
                                const successAlert={
                                    title: 'Success',
                                    html:'',
                                    confirmButtonText:'OK',
                                    callback:(res) => {
                                        if(res){
                                            window.location.reload();
                                        }
                                    }
                                };
                                customAlertCrudAuto(successAlert);
                            },(error)=>{
                                const errorAlert={
                                    icon: 'error',
                                    title: 'Oops...',
                                    html:'<h1>Something went wrong!!</h1>',
                                    confirmButtonText:'Cancel',
                                    confirmButtonColor: '#3085d6',
                                    callback:(res) => {
                                        window.location.reload();
                                    }
                                    //loader:true,
                                };
                                customAlertCrudAuto(errorAlert);
                            });
                        }
                    }
                    //loader:true,
                };
            customAlertCrudAuto(successAlert);
        }
        const dependenciesApiCrudAuto=async()=>{
            const array_form_details=form_info.form_details;
            for (let index = 0; index < array_form_details.length; index++) {
                const element = array_form_details[index];

                var db_field_name=(element.db_info.field_name);
                console.log("db field name=",editable[db_field_name]);
                var edit_id=editable[db_field_name] ?? '';
                var sname=element.label_name.replace(/ /g,"_")+'-0';
                var v=$("#"+sname);

                //$(v).val(edit_id).trigger('change');


                if(element.event_actions.api && element.event_actions.api != 'null' && element.event_actions.api != null){
                    //$(v).val(edit_id);
                    console.log('testss--',element);
                    await handleChangeCrudAuto(v,element.id, edit_id);

                }
                else if(element.event_actions.ref_selector != ''){
                    console.log('select=',edit_id);
                    $(v).val(edit_id).trigger('change');
                }
            }
        }
        $('#crudForm').on('submit', function(event){
            event.preventDefault();
            $(this).attr('enctype', 'multipart/form-data');
            var d = $(this).serializeArray();
            console.log(d[3].value);
            var url=$(this).attr("action");
            const callback = data => {

                console.log("log success");
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



