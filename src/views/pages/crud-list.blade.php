@extends('lca-amin-pciu::index')
@section('title','Crud')
@section ('content_page_amin_pciu')
    @include('lca-amin-pciu::styles.common')
    <style>
        {!!  strip_tags($form_info->style_custom->css_index ?? '') !!}
    </style>
    <?php use Aminpciu\CrudAutomation\app\Helper\HelperTrait; ?>
    @php
        $form_class=str_replace(' ','_',$form_info->form_name);
        $col_per_row=6;
        if(!empty($form_info->style_custom->no_cols_per_row_index))
            $col_per_row=floor(12 / $form_info->style_custom->no_cols_per_row_index);
    @endphp
    <div class="mt-2 {{$form_class}}_main_div_index">
        <div class="card {{$form_class}}_card_index">
            <h5 class="card-header {{$form_class}}_card_header_index">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        List
                    </div>
                    <div class="">
                        <a
                            href="{{route($base_route.'.create')}}"
                            class="navbar-toggler" >
                            Create
                        </a>

                    </div>
                </div>
            </h5>
            <div class="card-body {{$form_class}}_card_body_index">
                @php
                    $form_thead=$form_info->form_details ?? [];
                @endphp

                <div class="row">
                    <div class="card mb-2">
                        <div class="card-body">
                            <form method="get" action="{{route($base_route.'.index')}}">
                                <div class="col-12">
                                    <div class="row">
                                        @php
                                            $form_class=str_replace(' ','_',$form_info->form_name);
                                        @endphp
                                        @forelse ($form_thead->where("filterable",1) as $form)
                                            @php
                                                $db_info=($form->db_info);
                                                $db_field_name=($form->db_info->field_name);
                                                $class_label=str_replace(' ','_',$form->label_name);
                                            @endphp
                                            <div class="col-sm-4">
                                                <div class="input-group mb-1">
                                                    <span class="input-group-text form_label_width {{$form_class}}_label_index {{$form_class}}_{{$class_label}}_label_index">
                                                        {{$form->label_name}}
                                                    </span>
                                                    @if($form->input_type == 'checkbox' || $form->input_type == 'radio')
                                                        @php
                                                            $is_list=HelperTrait::getSelectionFormData($form);
                                                        @endphp
                                                        @if (count($is_list) > 0)
                                                            @foreach($is_list as $key =>$input)
                                                                <input
                                                                    class="{{$form_class}}_input {{$form_class}}_{{$class_label}}_input"
                                                                    type="{{$form->input_type}}"
                                                                    value="<?=$input->id ?? 0?>"
                                                                    name="<?=$db_field_name?>" @if($editable && $editable->$db_field_name == $input->id) checked @elseif($key == 0) checked @endif /> {{$input->name}}
                                                            @endforeach
                                                        @endif
                                                    @elseif($form->input_type == 'selection' || $form->input_type == 'session')
                                                        @php
                                                            $options=HelperTrait::getSelectionFormData($form);
                                                        @endphp
                                                        <select
                                                            type="selection"
                                                            class="keyboard form-control select2_custom_crud_auto {{$form_class}}_input {{$form_class}}_{{$form->db_info->field_name}}_input"
                                                            name="<?=$form->db_info->field_name?>"
                                                            key='{{str_replace(' ','_',$form->label_name)}}'
                                                            selector_id="{{str_replace(' ','_',$form->event_actions->selector)}}-0"
                                                            id="{{str_replace(' ','_',$form->label_name)}}-0"
                                                            @if(!empty($form->event_actions->name) && $form->event_actions->name == 'onchange')
                                                                onchange="handleChangeCrudAuto(this,{{$form->id}})"
                                                            @endif
                                                            event_keyup_mouseup_handle='change'
                                                            form_name_attr='crud_setup_form'>
                                                                <option value="0">All</option>
                                                                @foreach ($options as $option)
                                                                    <option value="{{$option->id}}">{{$option->name}}</option>
                                                                @endforeach
                                                        </select>
                                                    @else
                                                        <input name="<?=$form->db_info->field_name?>" class="form-control {{$form_class}}_input_index {{$form_class}}_{{$class_label}}_input_index" />
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div>No Filter</div>
                                        @endforelse ($form_thead as )
                                        <div class="col-sm-3">
                                            <div class="input-group mb-1">
                                                <span class="">
                                                    &nbsp;
                                                </span>
                                                <button class="btn btn-danger btn-sm">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="display bs_datatable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Actions</th>
                                @foreach ($form_thead as $form)
                                    @if(HelperTrait::willDisplayFormInput($form->display_type,3))
                                        <th>{{$form->label_name}}</th>
                                    @endif
                                @endforeach
                                @if($form_info->has_timestamp)
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <a href="{{route($base_route.'.edit',['id' => $item->id])}}" class="btn btn-warning btn-sm">Edit</a>
                                        <button onclick="handleDeleteCrudAuto({{$item->id}})" class="btn btn-danger btn-sm">X</button>
                                    </td>
                                    @foreach ($form_thead as $form)
                                        @if(HelperTrait::willDisplayFormInput($form->display_type,3))
                                            @php
                                                $col=$form->db_info->field_name;
                                                $relation_name=$form->relation_name;
                                            @endphp
                                            <th>
                                                @if(!empty($relation_name))
                                                    @php
                                                        $rnames=explode('.',$hasRel['rel_data'][$relation_name]['name']);
                                                        $r_sym=$hasRel['rel_data'][$relation_name]['sym'];
                                                        $r_cols=$hasRel['rel_data'][$relation_name]['cols'];
                                                        $rname=$rnames[0];
                                                        foreach ($rnames as $key => $value) {
                                                            if($key == 0)
                                                                continue;
                                                            $rname=$item->$rname->$value ?? '';
                                                        }
                                                        //echo $rname;
                                                        if(count($rnames) > 1)
                                                            $rel_data=$rname;
                                                        else
                                                            $rel_data=$item->$rname;
                                                        $data_ara=[];
                                                        foreach ($r_cols as $key => $value) {
                                                            if(empty($rel_data->$value))
                                                                continue;
                                                           $data_ara[]=$rel_data->$value;
                                                        }
                                                        $data_con=implode($r_sym,$data_ara);
                                                    @endphp
                                                    {{$data_con}}
                                                @elseif($form->input_type == 'image_file' && $item->$col)
                                                    @forelse (json_decode($item->$col) as $file)
                                                        <a target="_blank" href="{{ asset($form->db_info->file_location."/".$file) }}">
                                                            {{$file}}
                                                        </a>
                                                    @empty
                                                        <div>Empty</div>
                                                    @endforelse
                                                @else
                                                    @if(!empty($form->options))
                                                        {{HelperTrait::getSelectionNameForDyCrud($form,$item->$col)}}
                                                    @else
                                                        {{$item->$col}}
                                                    @endif
                                                @endif
                                            </th>
                                        @endif
                                    @endforeach
                                    @if($form_info->has_timestamp)
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $list->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@include('lca-amin-pciu::scripts.common-script')
@section('custom_script_amin_pciu')
    <script>
        var deleteRoute=@json(route($base_route.'.delete'));
        function handleDeleteCrudAuto(id){
            //console.log(id);
            const successAlert={
                    title: 'Confirmation',
                    html:'<h1>Are you sure to delete ?</h1>',
                    confirmButtonText:'Confirm',
                    showCloseButton:true,
                    showCancelButton:true,
                    callback:(res) => {
                        if(res){
                            ajaxCallCrudAuto(deleteRoute,'post',{id:id},
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
                };
            customAlertCrudAuto(successAlert);
        }
    </script>
@endsection
