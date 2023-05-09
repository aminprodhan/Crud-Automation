@extends('lca-amin-pciu::index')
@section('title','Crud')
@section ('content_page_amin_pciu')
    <div class="mt-2">
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        List
                    </div>
                    <div class="">
                        <button onclick="handleCreate()" id="btn_create" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            Create
                        </button>

                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div>
                    <table class="bs_datatable">
                        <thead>
                            <tr>
                                <td class="table-primary">
                                    SL
                                </td>
                                <td class="table-light">
                                    Actions
                                </td>
                                <td class="table-secondary">Form Name</td>
                                <td class="table-success">Table Name</td>
                                <td class="table-danger">Route Name</td>
                                <td class="table-warning">Middleware Name</td>
                                <td class="table-info">Created At</td>
                                <td class="table-light">Updated At</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list->chunk(20) as $items)
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>
                                            <button
                                                onclick="handleEdit(this,{{$item->id}})"
                                                class="btn btn-warning btn-sm">Edit</button>
                                            <button
                                                onclick="handleTruncateCrudAuto({{$item->id}})"
                                                class="btn btn-danger btn-sm">Truncate</button>
                                        </td>
                                        <td>{{$item['form_name']}}</td>
                                        <td>{{$item['table_name']}}</td>
                                        <td>
                                            {{$item['route_name']}}
                                            <a target="_blank" href="/{{str_replace('.','/',$item['route_name']).'/index'}}">Index</a>
                                            <a target="_blank" href="/{{str_replace('.','/',$item['route_name']).'/create'}}">Create</a>
                                        </td>
                                        <td>{{$item['middleware_name']}}</td>
                                        <td>{{$item['created_at']}}</td>
                                        <td>{{$item['updated_at']}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section("drawer_content")
        @include('lca-amin-pciu::components.form_crud')
    @endsection
    @include('lca-amin-pciu::components.drawer')
@endsection


@section('custom_script_amin_pciu')
    <script>
        const data_types=@json($data_types);
        const input_types=@json($input_types);
        const display_types=@json($display_types);
        const db_index_types=@json($db_index_types);
        const list=@json($list);
        const event_actions=@json($event_actions);
        let flag_status_onchange=1;
        event_actions.unshift({name:'None',value:'0'});
        db_index_types.unshift({name:'None',value:'0'});
        $(document).ready(function(){
            initForm();
        });
        function handleTruncateCrudAuto(id,type=1){
            //console.log(id);
            let message='truncate';
            let deleteRoute='/crud-automation/aminpciu/input/truncate';
            if(type == 2)
                {
                    deleteRoute='/crud-automation/aminpciu/input/migrate-fresh';
                    message='migrate fresh';
                }

            const successAlert={
                    title: 'Confirmation',
                    html:`<h1>Are you sure to ${message}?</h1>`,
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
                                            //window.location.reload();
                                        }
                                    }
                                };
                                customAlertCrudAuto(successAlert);
                            },(error)=>{
                                console.log('error',error);
                                const errorAlert={
                                    icon: 'error',
                                    title: 'Oops...',
                                    html:`<h1>${error.responseJSON}</h1>`,
                                    confirmButtonText:'Cancel',
                                    confirmButtonColor: '#3085d6',
                                    callback:(res) => {
                                        //window.location.reload();
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
        let init_form_data={
            form_name:'',
            model_name:'',
            table_name:'',
            route_name:'',
            migration_path:'',
            migration_status:0,
            model_status:0,
            middleware_name:'',
            form_style:'',
            soft_delete:1,
            migrate_status:0,
            timestamp:1,
            view_format:'',
            style:{
                no_cols_per_row:2,
                offset:12,
                css:'',
                no_cols_per_row_index:2,
                offset_index:12,
                css_index:'',
            },
            db:{
                where_con:'',
                row_per_page:'',
                where_has:'',
                where_doesnt_have:'',
                where_null:'',
                where_not_null:'',
                order_by:'',
                group_by:'',
                init_data:[],
            }
        }
        let data_post={
            ...init_form_data,
            fields:[]
        };
        const init_obj={
            id:'',
            index:0,
            sort_id:0,
            field_name:'',
            relation_name:'',
            label_name:'',
            input_type:input_types[0]['id'],
            options_data:'',
            options_query:'',
            options_api:'',
            field_type:data_types[0]['type'],
            data_length:'',
            default_value:'',
            display_type:display_types[0]['id'],
            session_name_func:'',
            validation:'',
            comments:'',
            nullable:1,
            auto_increment:0,
            filterable:0,
            auto_code:{
                start_range:1,
                prefix:'',
                suffix:'',
                where_con:'',
            },
            event:{
                name:'',
                api:'',
                selector:'',
                ref_selector:'',
                method:'get',
            },
            index_db:{
                index_name:'',
                index_type:'',
            },
            options:{},
            file_location:"",
        };
        function handleCreate(){
            handleReset();
        }
        const handleEdit=(v,id)=>{
            //handleCreate();
            let row=list.find(row=> row.id == id);
            let fields=[];
            row.form_details.map(row=> {
                let json_obj=row.db_info;
                //let json_obj=JSON.parse(row.db_info);
                if(row.validation == 'null' || !row.validation)
                    row.validation='';
                if(row.relation_name == 'null' || !row.relation_name)
                    row.relation_name='';
                if(row.label_name == 'null' || !row.label_name)
                    row.label_name='';
                if(json_obj.field_name == 'null' || !json_obj.field_name)
                    json_obj.field_name='';
                if(json_obj.data_length == 'null' || !json_obj.data_length)
                    json_obj.data_length='';
                if(json_obj.default_value == 'null' || !json_obj.default_value)
                    json_obj.default_value='';
                if(json_obj.comments == 'null' || !json_obj.comments)
                    json_obj.comments='';
                if(json_obj.file_location == 'null' || !json_obj.file_location)
                    json_obj.file_location='';
                if(json_obj.auto_code){
                    if (json_obj.auto_code.prefix == 'null' || !json_obj.auto_code.prefix)
                        json_obj.auto_code.prefix='';
                    if(json_obj.auto_code.suffix == 'null' || !json_obj.auto_code.suffix)
                        json_obj.auto_code.suffix='';
                    if(json_obj.auto_code.start_range == 'null' || !json_obj.auto_code.start_range)
                        json_obj.auto_code.start_range='';
                    if(json_obj.auto_code.where_con == 'null' || !json_obj.auto_code.where_con)
                        json_obj.auto_code.where_con='';
                }

                let event=row.event_actions;
                if(event.ref_selector == undefined)
                    event.ref_selector='';
                //let event=JSON.parse(row.event_actions);
                //console.log("ev=",event);
                let init_obj_local={
                    ...init_obj,
                    id:row.id,
                    index:0,
                    sort_id:row.sort_id,
                    auto_code:json_obj.auto_code ? json_obj.auto_code : init_obj.auto_code,
                    field_name:json_obj.field_name,
                    label_name:row.label_name,
                    input_type:row.input_type,
                    session_name_func:row.session_name_func,
                    relation_name:row.relation_name,
                    options_data:'',
                    options_query:'',
                    options_api:'',
                    field_type:json_obj.field_type,
                    data_length:json_obj.data_length,
                    default_value:json_obj.default_value,
                    display_type:row.display_type,
                    validation:row.validation,
                    comments:json_obj.comments,
                    nullable:json_obj.nullable,
                    filterable:row.filterable,
                    auto_increment:0,
                    event:event,
                    index_db:{
                        index_name:json_obj.index_db.index_name,
                        index_type:json_obj.index_db.index_type,
                    },
                    options:{},
                    file_location:json_obj.file_location,
                };

                if(!row.options || row.options == 'null')
                    row.options='';

                if(row.options_data_type == '1')
                    init_obj_local.options_data=row.options;
                if(row.options_data_type == '2')
                    init_obj_local.options_query=row.options;
                if(row.options_data_type == '3')
                    init_obj_local.options_api=row.options;
                fields.push(init_obj_local);
            })

            if(row.table_cond != undefined){

                if(row.table_cond.where_con == 'null' || !row.table_cond.where_con)
                    row.table_cond.where_con='';
                if(row.table_cond.where_has == 'null' || !row.table_cond.where_has)
                    row.table_cond.where_has='';
                if(row.table_cond.where_doesnt_have == 'null' || !row.table_cond.where_doesnt_have)
                    row.table_cond.where_doesnt_have='';
                if(row.table_cond.where_null == 'null' || !row.table_cond.where_null)
                    row.table_cond.where_null='';
                if(row.table_cond.order_by == 'null' || !row.table_cond.order_by)
                    row.table_cond.order_by='';
                if(row.table_cond.group_by == 'null' || !row.table_cond.group_by)
                    row.table_cond.group_by='';
                if(row.table_cond.row_per_page == 'null' || !row.table_cond.row_per_page)
                    row.table_cond.row_per_page='';
                row.table_cond.init_data=JSON.parse(row.table_cond.init_data);
            }
            console.log("row=",row.table_cond);

            let form={
                id:row.id,
                style:{
                    no_cols_per_row:2,
                    offset:12,
                    css:'',
                    no_cols_per_row_index:2,
                    offset_index:12,
                    css_index:'',
                    ...row.style_custom ?? ''
                },
                db:{
                    where_con:'',
                    where_in:'',
                    where_not_in:'',
                    where_has:'',
                    where_doesnt_have:'',
                    where_null:'',
                    where_not_null:'',
                    order_by:'',
                    group_by:'',
                    row_per_page:'',
                    init_data:[],
                    ...row.table_cond ?? ''
                },
                form_name:row.form_name,
                model_name:row.model_name,
                table_name:row.table_name,
                route_name:row.route_name,
                migration_path:row.migration_path,
                middleware_name:row.middleware_name,
                form_style:row.style_custom,
                soft_delete:row.has_softdelete,
                migrate_status:row.migrate_status,
                timestamp:row.has_timestamp,
                fields:fields,
            };

            data_post={
                ...init_form_data,
                ...form
            };
            console.log("init form=",data_post);
            updateBinder(0);
            $('#offcanvasNavbar').offcanvas('show');
        }
        const getDbIndexOptions=(index_value)=>{
            const list=db_index_types.map(row => {
                let sel='';
                if(row.value == index_value)
                    sel=`selected='selected'`;
                return (`<option ${sel} value='${row.value}'>${row.name}</option>`)
            });
            return list;
        }
        const getInputTypes=(value)=>{
            console.log("input types=",value);
            const list=input_types.map(row => {
                let selected='';
                if(row.id == value)
                    selected=`selected='selected'`;
                return (`<option ${selected} value='${row.id}'>${row.name}</option>`);
            });
            return list;
        }
        const getFieldTypes=(value)=>{
            //console.log("input types=",value);
            const list=data_types.map(row => {
                let selected='';
                if(row.type == value)
                    selected=`selected='selected'`;
                return (`<option ${selected} value='${row.type}'>${row.name}</option>`);
            });
            return list;
        }
        const getDisplayTypes=(value)=>{
            //console.log("input types=",value);
            const list=display_types.map(row => {
                let selected='';
                if(row.id == value)
                    selected=`selected='selected'`;
                return (`<option ${selected} value='${row.id}'>${row.name}</option>`);
            });
            return list;
        }
        let db_index_type_options='';
        const initForm=()=>{
            const fields=[];
            for(var i=0;i<10;i++)
                {
                    var clone= Object.assign({}, init_obj);
                    clone.index=i;
                    clone.sort_id=(i + + 1);
                    fields.push(clone);
                }
            data_post=Object.assign({},init_form_data);
            data_post.fields=fields;
            updateBinder(0);
            //handleAddRemove(-1);
        }
        const handleReset=()=>{
            initForm();
        }
        const bindHtml=()=>{
            formdataBinderCrudAuto('event_keyup_mouseup_handle');
            //formdataBinderCrudAuto('event_keyup_mouseup_handle');
            //formdataBinderCrudAuto('event_change_handle');
        }
        const formdataBinderCrudAuto = (event) => dataBinderCrudAuto(event, data_post, (obj,element) => {
            console.log("test....",element);
            data_post=obj;

            var method=$(element).attr("method");
            var key=$(element).attr("key");
            const match = key.match(/\d+/); // match will be an array with ["123"]
            const index = match ? parseInt(match[0]) : NaN; // num will be 123
            if(!isNaN(index) && method != undefined)
                {
                    let row=data_post.fields[index];
                    setTimeout(async() => {
                        //addRow(row,index,1);
                        updateBinder(0);
                    }, 1000);
                }

            //console.log("index no=",key);
            //trRows();
        });
        const handleTableCols=(v)=>{
            var table_name=$(v).val();
            ajaxCallCrudAuto(`/crud-automation/aminpciu/crud/table-columns?table_name=${table_name}`,'get',{},function(res){
                data_post.fields=[];
                data_post.table_name=table_name;
                if(res.info != 'null' && res.info){
                    data_post.model_name=res.info['model_path'];
                }
                res.cols.map((row,index) => {
                    var clone= Object.assign({}, init_obj);
                    clone.index=index;
                    clone.sort_id=(index + + 1);
                    console.log("row=",row);
                    clone.field_name=row['field_name'];
                    clone.label_name=row['label_name'];
                    data_post.fields.push(clone);
                });
                console.log("field=",data_post.fields);
                updateBinder(0);
            },(error)=>{

            });
        }
        const handleSave=()=>{
            let style=$("#style_css-0").val();
            let style_index=$("#style_css_index-0").val();
            let init_data=$("#db_init_data-0").val();
            data_post.style.css=style;
            data_post.style.css_index=style_index;
            data_post.db.init_data=init_data;
            console.log("obj=",data_post);
            ajaxCallCrudAuto(`/crud-automation/aminpciu/crud/create`,'post',data_post,function(res){
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
                const errors=error.responseJSON.errors;
                let html='';
                for(error in errors){
                    errors[error].map(row => {
                        console.log("error=",row);
                        html+=`<p style='margin:0;padding:0'>${row}</p>`;
                    });
                }
                if(html == '')
                    html=`<h1>${error.responseJSON}</h1>`;
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
            });
        }
        function trRows(data_default){
            $("#crud_rows").empty();
            const data=(data_default ?? data_post);
            for (let key in data) {
               if(key != 'fields'){
                    var type_attr=$(`#${key}-0`).attr("type");

                    if(type_attr == 'checkbox' || type_attr == 'radio'){
                        if($(`#${key}-0`).is(":checked") || data[key] == 1)
                            $(`#${key}-0`).prop('checked',true)
                        else
                            $(`#${key}-0`).prop('checked',false)
                    }
                    else if(type_attr != 'selection')
                        {
                            if(typeof data[key] === 'object'){
                                for (let obj_key in data[key]) {
                                    //console.log(`#${key}.${obj_key}-0`);
                                    $(`#${key}_${obj_key}-0`).val(data[key][obj_key]);

                                    let string=$(`#${key}_${obj_key}-0`).val();
                                    if(string != undefined && string != '')
                                        $(`#${key}_${obj_key}-0`).val(string.replace(/[<]br[^>]*[>]/gi,""));
                                    console.log("id5=",`#${string}-0`);
                                    //$(`#${obj_key}-0`).val(data[key][obj_key]);
                                }
                            }
                            else{
                                $(`#${key}-0`).val(data[key]);
                                let string=$(`#${key}-0`).val();
                                if(string != undefined)
                                {
                                    console.log("id-string=",`#${string}-0`);
                                    $(`#${key}-0`).val(string.replace(/[<]br[^>]*[>]/gi,""));
                                }
                            }
                            //console.log("id=",`#${key}-0`);
                            //console.log("value=",`${data[key]}`);

                        }
                    else{
                        $(`#${key}-0`).val(data[key]).trigger('change');
                    }
                    //$('#model_name-0').val(data.model_name);
               }
            }
            data_post=data;
            data.fields.map((row,index) => {
                addRow(row,index);
            });
        }
        const handleAddRemove=(index,type)=>handleAddRemoveLibCrudAuto(index,type,data_post,(res) => {
            data_post=res;
            trRows();
            bindHtml();
            select2ModalCrudAuto('select2_custom','modal_select2');
        });
        const updateBinder=(index) => updateBinderLibCrudAuto(index,data_post,data_post.fields[index]['sort_id'],(res_obj)=>{

                data_post=res_obj;
                console.log("log",data_post);
                trRows();
                bindHtml();
                select2ModalCrudAuto('select2_custom','modal_select2');

                //getOptionsEvent(0);
        })
        const getEventActions=(name)=>{
            return event_actions.map(row => {
                let selected='';
                if(row.value == name)
                    selected=`selected='selected'`;
                return (`<option ${selected} value='${row.value}'>${row.name}</option>`);
            });
        }
        const getOptionsEvent=(data,index,name)=>{
            let label_name=data.fields[index].label_name;
            const options_api=data.fields.filter(row => row.input_type == 'selection' && row.label_name != label_name);
            console.log("options api=",name);
            let options='';
            options_api.unshift({field_name:'0',label_name:'None'});
            options_api.map(row => {

                let selected='';
                if(row.label_name == name)
                    selected=`selected='selected'`;

                options+=`<option ${selected} value='${row.label_name}'>${row.label_name}</option>`;
            });
            return options;
        }
        function handleRefSelector(v,selector){
            //let selector=row.label_name;
            var sname=$(v).val();
            const options_api=data_post.fields.find(row => row.label_name == sname);
            console.log('exit=',options_api);
            if(options_api != undefined){
                //ref_selector
                options_api.event['ref_selector']=selector;
            }
            else{
                const options_api=data_post.fields.find(row => row.event.ref_selector == selector);
                if(options_api != undefined)
                    options_api.event['ref_selector']='';
            }

        }
        async function addRow(row,index,isUpdate){
            //var types_options=`<option value='1'>Active</option>`;
            //keyup mouseup
            let div_db_index_content='';let is_nullable='';let event_content='';
            let ftype=data_post.fields[index].field_name;
            let is_filterable='';
            if(row.nullable)
                is_nullable='checked';
            if(row.filterable)
                is_filterable='checked';

            let cmp_auto_code='';
            if(data_post.fields[index].input_type == 'auto_code' ){
                data_post.fields[index].field_name=ftype != '' ? ftype : 'code';
                data_post.fields[index].field_type='string';
                data_post.fields[index].data_length=100;
                cmp_auto_code=`
                            <div>
                                <span class='form_label_required'>
                                    Prefix
                                </span>
                            </div>
                            <div class='mb-1'>
                                <input
                                    key='fields[${index}].auto_code.prefix'
                                    id='data_autocode_prefix-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    placeholder='Prefix'
                                    form_name_attr='crud_setup_form'
                                    value='${row.auto_code.prefix}'
                                    class='keyboard' />
                            </div>
                            <div>
                                <span class='form_label_required'>
                                    Start Range
                                </span>
                            </div>
                            <div class='mb-1'>
                                <input
                                    key='fields[${index}].auto_code.start_range'
                                    type='number'
                                    id='data_autocode_start_range-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    placeholder='Start Range'
                                    form_name_attr='crud_setup_form'
                                    value='${row.auto_code.start_range}'
                                    class='keyboard' />
                            </div>
                            <div>
                                <span class='form_label_required'>
                                    Suffix
                                </span>
                            </div>
                            <div class='border_top'>
                                <input
                                    key='fields[${index}].auto_code.suffix'
                                    id='data_autocode_suffix-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    placeholder='Suffix'
                                    form_name_attr='crud_setup_form'
                                    value='${row.auto_code.suffix}'
                                    class='keyboard' />
                            </div>
                            <div>
                                <span class='form_label_required'>
                                    Where Cond.
                                </span>
                            </div>
                            <div class='border_top'>
                                <input
                                    key='fields[${index}].auto_code.where_con'
                                    id='data_autocode_where_con-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    placeholder='"id"=>1,"name"=>"function()"'
                                    form_name_attr='crud_setup_form'
                                    value='${row.auto_code.where_con}'
                                    class='keyboard' />
                            </div>
                    `;
            }
            else{
                data_post.fields[index].auto_code.prefix='';
                data_post.fields[index].auto_code.start_range='';
                data_post.fields[index].auto_code.suffix='';
                data_post.fields[index].auto_code.where_con='';
            }

            if(data_post.fields[index].input_type == 'primary_auto_inc'){
                data_post.fields[index].field_name=ftype != '' ? ftype : 'id';
                data_post.fields[index].field_type='unsignedInteger';
                data_post.fields[index].data_length='';
            }

            type_options=getFieldTypes(data_post.fields[index].field_type);
            input_types_options=getInputTypes(data_post.fields[index].input_type);
            db_index_type_options=getDbIndexOptions(data_post.fields[index].index_db.index_type);
            display_types_options=getDisplayTypes(data_post.fields[index].display_type);
            let eventActions=getEventActions(data_post.fields[index].event.name);

            let session_component='';event_content='';file_location_cmp='';
            if(data_post.fields[index].input_type == 'image_file'){
                file_location_cmp=`<div>
                                        <span class='form_label_required'>
                                            File Location
                                        </span>
                                    </div>
                                    <div class='border_top'>
                                        <input
                                            key='fields[${index}].file_location'
                                            event_keyup_mouseup_handle='keyup'
                                            form_name_attr='crud_setup_form'
                                            placeholder='Location'
                                            value='${row.file_location}'
                                            id='data_session_name_func-${index}'
                                            class='form_input_width keyboard'
                                            placeholder='Location'  />
                                    </div>`;
            }
            if(data_post.fields[index].input_type == 'session'){
                session_component=`
                                <div>
                                    <span class='form_label_required'>Session Name or Helper Func.</span>
                                </div>
                                <div class='border_top'>
                                    <input
                                        key='fields[${index}].session_name_func'
                                        event_keyup_mouseup_handle='keyup'
                                        form_name_attr='crud_setup_form'
                                        placeholder='Session Name or Helper Func.'
                                        value='${row.session_name_func}'
                                        id='data_session_name_func-${index}'
                                        class='form_input_width keyboard' />
                                </div>
                                `;
            }

            if(data_post.fields[index].event.name == 'onchange'){
                let options_event=getOptionsEvent(data_post,index,row.event.selector);
                event_content=`
                    <div>
                        <span class='form_label_required'>Api</span>
                    </div>
                    <div class='border_top'>
                        <input
                            key='fields[${index}].event.api'
                            event_keyup_mouseup_handle='keyup'
                            form_name_attr='crud_setup_form'
                            placeholder='Api'
                            value='${row.event.api}'
                            id='data_event_api-${index}'
                            class='form_input_width keyboard' />
                    </div>
                    <div>
                        <span class='form_label_required'>Method</span>
                    </div>
                    <div class='border_top'>
                        <input
                            key='fields[${index}].event.method'
                            event_keyup_mouseup_handle='keyup'
                            form_name_attr='crud_setup_form'
                            placeholder='GET or POST'
                            value='${row.event.method}'
                            id='data_event_method-${index}'
                            class='form_input_width keyboard' />
                    </div>
                    <div>
                        <span class='form_label_required'>Selector</span>
                    </div>
                    <div class='border_top'>
                        <select
                            onchange='handleRefSelector(this,"${row.label_name}")'
                            key='fields[${index}].event.selector'
                            id='data_event_selector-${index}'
                            event_keyup_mouseup_handle='change'
                            form_name_attr='crud_setup_form'
                            class='form-control select2_custom keyboard'>
                            ${options_event}
                        </select>
                    </div>
                `;
            }else{
                data_post.fields[index].event.api='';
                data_post.fields[index].event.selector='';
            }


            //console.log('index type=',data_post.fields[index].index_db.index_type);
            if(data_post.fields[index].index_db.index_type == 'index')
                {
                    div_db_index_content=`<input
                                                key='fields[${index}].index_db.index_name'
                                                event_keyup_mouseup_handle='keyup'
                                                form_name_attr='crud_setup_form'
                                                placeholder='Index Name'
                                                value='${row.index_db.index_name}'
                                                id='data_index_name-${index}'
                                                class='form_input_width keyboard' />`;
                }
            else
                data_post.fields[index].index_db.index_name='';



            let cmp_selection='';
            if(data_post.fields[index].input_type == 'selection' || data_post.fields[index].input_type == 'session'){
                cmp_selection=`<div class=''>
                                <textarea
                                    key='fields[${index}].options_data'
                                    id='data_options_data-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    placeholder='1=>"Option1",2=>"Option2"'
                                    class='keyboard'>${row.options_data}</textarea>
                            </div>
                            <div style='color:red;font-weight:bold;'>OR</div>
                            <div class='border_top'>
                                <textarea
                                    key='fields[${index}].options_api'
                                    id='data_options_api-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    placeholder='Helper Function Name'
                                    class='keyboard'>${row.options_api}</textarea>
                            </div>
                            <div style='color:red;font-weight:bold;'>OR</div>
                            <div class='border_top'>
                                <textarea
                                    key='fields[${index}].options_query'
                                    id='data_options_query-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    placeholder='select id,name from table_name'
                                    class='keyboard'>${row.options_query}</textarea>
                            </div>`;
            }
            else if(data_post.id == '' || !data_post.id){
                data_post.fields[index].options_data='';
                data_post.fields[index].options_api='';
                data_post.fields[index].options_query='';
            }

            let cmp_filterable=`<div class='border_top'>
                                    <input
                                        type='checkbox'
                                        key='fields[${index}].filterable'
                                        event_keyup_mouseup_handle='keyup'
                                        form_name_attr='crud_setup_form'
                                        id='data_filterable-${index}'
                                        class='keyboard' ${is_filterable} /> <span style='color:red;'>Filterable ?</span>
                                </div>`;
            if(data_post.fields[index].input_type == 'image_file')
                {
                    data_post.fields[index].filterable=0;
                    cmp_filterable='';
                }

            let tr=`<tr class='tr-form-crud-${index}'>
                        <td>
                                <button
                                    onclick=handleAddRemove(${index},1)
                                    type="button" class="btn btn-danger btn-sm">+</button>
                                <button
                                    onclick=handleAddRemove(${index},2)
                                    type="button" class="btn btn-danger btn-sm">x</button>
                        </td>
                        <td>
                            <div class='mb-1'>
                                <input
                                    key='fields[${index}].label_name'
                                    id='data_label_name-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.label_name}'
                                    class='keyboard' />
                            </div>
                            ${cmp_filterable}

                        </td>
                        <td>
                            <div class='mb-1'>
                                <select
                                    key='fields[${index}].input_type'
                                    id='data_input_type-${index}'
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'
                                    method=handleDBIndex()
                                    class='form-control select2_custom keyboard'>
                                        ${input_types_options}
                                </select>
                            </div>
                            ${cmp_auto_code}
                            <div class='border_top'>
                                <select
                                    key='fields[${index}].display_type'
                                    id='data_display_type-${index}'
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'
                                    class='form-control select2_custom keyboard'>
                                        ${display_types_options}
                                </select>
                            </div>
                            ${file_location_cmp}
                            ${session_component}
                            <div class='border_top'>
                                <select
                                    key='fields[${index}].event.name'
                                    id='data_event-${index}'
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'
                                    method=handleDBIndex()
                                    class='form-control select2_custom keyboard'>
                                        ${eventActions}
                                </select>
                            </div>
                            ${event_content}

                        </td>
                        <td>
                            ${cmp_selection}
                        </td>
                        <td>
                            <input
                                key='fields[${index}].validation'
                                event_keyup_mouseup_handle='keyup'
                                form_name_attr='crud_setup_form'
                                value='${row.validation}'
                                id='data_validation-${index}'
                                class='form_input_width keyboard' />
                        </td>
                        <td>
                            <div class='mb-1'>
                                <input
                                    key='fields[${index}].field_name'
                                    id='data_field_name-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    class='keyboard'
                                    form_name_attr='crud_setup_form'
                                    value='${row.field_name}'
                                />
                            </div>
                            <div class='d-flex flex-grow-1 border_top mb-1'>
                                <select
                                    key='fields[${index}].field_type'
                                    event_keyup_mouseup_handle='change'
                                    id='data_field_type-${index}'
                                    form_name_attr='crud_setup_form'
                                    class='form-control select2_custom keyboard'>
                                    ${type_options}
                                </select>
                            </div>
                            <div class='d-flex flex-grow-1 border_top mb-1'>
                                <input
                                    key='fields[${index}].data_length'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    id='data_data_length-${index}'
                                    value='${row.data_length}'
                                    class='keyboard'
                                />
                            </div>
                            <div class='d-flex flex-grow-1 border_top'>
                                <input
                                    key='fields[${index}].default_value'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.default_value}'
                                    id='data_default_value-${index}'
                                    class='keyboard' />
                            </div>
                            <div class='d-flex flex-grow-1 border_top'>
                                <input
                                    key='fields[${index}].comments'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.comments}'
                                    id='data_comments-${index}'
                                    class='keyboard' />
                            </div>
                            <div class='d-flex flex-grow-1 border_top'>
                                <input
                                    key='fields[${index}].relation_name'
                                    placeholder='rel_name:display_col_name'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.relation_name}'
                                    id='data_relation_name-${index}'
                                    class='keyboard' />
                            </div>
                            <div class='border_top'>
                                <input
                                    type='checkbox'
                                    key='fields[${index}].nullable'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    id='data_nullable-${index}'
                                    class='keyboard' ${is_nullable} /> Nullable
                            </div>
                        </td>

                        <td>
                            <div>
                                <select
                                    key='fields[${index}].index_db.index_type'
                                    id='data_index_type-${index}'
                                    method=handleDBIndex()
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'
                                    class='form-control select2_custom keyboard'>
                                        ${db_index_type_options}
                                </select>
                            </div>
                            ${div_db_index_content}
                        </td>
                        <td>

                            <div class=''>
                                <input
                                    key='fields[${index}].sort_id'
                                    event_keyup_mouseup_handle='keyup mouseup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.sort_id}'
                                    type="number"
                                    id='data_sort_id-${index}'
                                    class="form_input_width keyboard"
                                    placeholder="Sort Id" />

                                    <button
                                        key='fields[${index}].sort_id'
                                        onclick=updateBinder(${index}) type="button" class="btn btn-primary btn-sm">Update Below Sort</button>
                            </div>
                        </td>
                    </tr>`;

            if(isUpdate == undefined)
                {
                    //flag_status_onchange=0;
                    $("#crud_rows").append(tr);
                }
            else{
                //$(`.tr-form-crud-${index}`).empty();
                $(`.tr-form-crud-${index}`).replaceWith(tr);
                bindHtml();
                console.log('eco-'+index);
                //var yourElement = document.getElementById('crud_drawer_content');
                //yourElement.style.height = yourElement.offsetHeight + 'px';
                select2ModalCrudAuto(`select2_custom`,'modal_select2');
            }
            //if(isUpdate == undefined){
                flag_status_onchange=1;
                //$(`#data_index_type-${index}`).off("select2:select select2:unselect");
                //$(`#data_index_type-${index}`).val(row.index_db.index_type).trigger("change");
                console.log('val=',row.index_db.index_type);
                await changeSelect2(index,row,(res)=>{
                    setTimeout(() => {
                        flag_status_onchange=0;
                    }, 2000);
                });

            //}

        }
        const changeSelect2=async(index,row,callback)=>{
            //$(`#data_index_type-${index}`).val(row.index_db.index_type).trigger('change');
            //$(`#data_input_type-${index}`).val(row.input_type).trigger('change');
            //$(`#data_field_type-${index}`).val(row.field_type).trigger('change');
            //$(`#data_display_type-${index}`).val(row.display_type).trigger('change');
            callback(1);
        }
    </script>
@endsection
