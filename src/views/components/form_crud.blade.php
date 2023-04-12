<style>
    .form_label_width{
        width: 110px;
        font-size: 14px;
        white-space: inherit !important;
    }
    .select2_table_name .select2_container{
        width:
    }
    .form_input_width{
        max-width: 100px;
    }
    .form_label_required{
        color: red;
        font-weight: bold;
    }
    thead {
        position: sticky;
        top: 0;
        background-color: #fff;
    }
    .mb-1{
        margin-bottom: 0.3rem !important;
    }
    .select2-container {
        flex: 1 1 auto;
    }
    .div_btn_reset{
        display: flex;
        justify-content: center;
        align-items: center
    }
    .mn{
        margin: 0;padding: 0;
    }
    .border_top{
        border-top: 1px dotted;
    }
</style>
<div class="card crud-setup-form">
    <h5 class="card-header">
        <div class="d-flex">
            <div class="flex-grow-1">
                Create
            </div>
        </div>
    </h5>
    <div class="card-body">
        <div style="display: hidden;">
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width" id="basic-addon1">
                            <span class="form_label_required">*</span>
                            Form Title
                        </span>
                        <input type="text"
                            key='form_name'
                            id="form_name-0"
                            event_keyup_mouseup_handle='keyup'
                            class="keyboard"
                            form_name_attr='crud_setup_form'
                            placeholder="Form Title"
                            aria-label="Form Title"
                            aria-describedby="basic-addon1">

                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width">
                            <span class="form_label_required">*</span>
                            Model Name
                        </span>
                        <input
                            type="text"
                            key='model_name'
                            id="model_name-0"
                            event_keyup_mouseup_handle='keyup'
                            class="keyboard"
                            form_name_attr='crud_setup_form'
                            placeholder="Model Name"
                            aria-label="Model Name">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width">
                            <span class="form_label_required">*</span>
                            Table Name
                        </span>
                        <input
                            type="text"
                            key='table_name'
                            id="table_name-0"
                            event_keyup_mouseup_handle='keyup'
                            class="keyboard"
                            form_name_attr='crud_setup_form'
                            placeholder="Table Name"
                            aria-label="Table Name"/>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width">
                        is table exist ?
                        </span>
                        <div class="d-flex flex-grow-1">
                            <select
                                type="selection"
                                onchange="handleTableCols(this)"
                                class='select2_custom'>
                                <option value="0"></option>
                                @foreach ($tables as $table)
                                    <option value="{{$table['table']}}">{{$table['table']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-sm-6">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width" id="basic-addon1">
                            Migration Path
                        </span>
                        <input
                            type="text"
                            key='migration_path'
                            id="migration_path-0"
                            event_keyup_mouseup_handle='keyup'
                            class="form-control keyboard"
                            form_name_attr='crud_setup_form'
                            placeholder="/folder_name/folder_name under migrations folder default is : /migratinos" />
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width" id="basic-addon1">
                            Migr. Create or Update
                        </span>
                        <select
                            type="selection"
                            class="keyboard select2_custom"
                            key='migration_status'
                            id='migration_status-0'
                            event_keyup_mouseup_handle='change'
                            form_name_attr='crud_setup_form'>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-1">

                        <span class="input-group-text form_label_width" id="basic-addon1">
                            <span class="form_label_required">*</span> Route Name
                        </span>
                        <input
                            key='route_name'
                            event_keyup_mouseup_handle='keyup'
                            placeholder="module.group.menu.name"
                            id="route_name-0"
                            form_name_attr='crud_setup_form'
                            type="text" class="form-control keyboard" />

                        <span class="input-group-text form_label_width" id="basic-addon1">
                            Middleware Name
                        </span>
                        <input
                            key='middleware_name'
                            event_keyup_mouseup_handle='keyup'
                            id="middleware_name-0"
                            form_name_attr='crud_setup_form'
                            type="text" class="form-control keyboard" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="input-group mb-1">
                        <span class="input-group-text form_label_width">
                            Style
                        </span>
                        <div class="d-flex flex-grow-1 me-1">
                            <textarea
                                key='form_style'
                                event_keyup_mouseup_handle='keyup'
                                id="form_style-0"
                                form_name_attr='crud_setup_form'
                                class="form-control keyboard"></textarea>
                        </div>
                        <div class="div_btn_reset me-1">
                            <div class="row">
                                <div class="col-12">
                                    <input
                                        key='timestamp'
                                        event_keyup_mouseup_handle='keyup'
                                        id="timestamp-0"
                                        form_name_attr='crud_setup_form'
                                        type="checkbox"  /> Timestamp ?
                                </div>
                                <div class="col-12">
                                    <input
                                        key='soft_delete'
                                        event_keyup_mouseup_handle='keyup'
                                        id="soft_delete-0"
                                        form_name_attr='crud_setup_form'
                                        type="checkbox"  /> SoftDelete ?
                                </div>
                            </div>
                        </div>
                        <div class="div_btn_reset me-1">
                            <div>
                                <button
                                    onclick="handleReset()"
                                    type="button"
                                    class="btn btn-danger btn-sm">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Actions</th>
                        <th scope="col">Label Name</th>
                        <th scope="col">
                            <div>Input Type</div>
                            <div class="border_top">Display Type</div>
                        </th>
                        <th scope="col">
                            <div>Options <br> Data</div>
                            <div class="border_top">Query</div>
                        </th>
                        <th scope="col">
                            <div>Field Name</div>
                            <div class="border_top">Field Type</div>
                            <div class="border_top">Length</div>
                            <div class="border_top">Default Value</div>
                        </th>
                        <th scope="col">Validation</th>
                        <th scope="col">Index</th>
                        <th scope="col">
                            <p class="mn">Comments</p>
                            <p class="mn border_top">Sort Id</p>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="crud_rows"></tbody>
                </table>
            </div>
            <div class="row mt-2" style="text-align: right">
                <button
                    onclick="handleSave()"
                    type="button"
                    class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
</div>
@section('custom_script')
    <script>
        const data_types=@json($data_types);
        const input_types=@json($input_types);
        const display_types=@json($display_types);
        const db_index_types=@json($db_index_types);
        let flag_status_onchange=1;
        db_index_types.unshift({name:'None',value:'0'});

        const getDbIndexOptions=(index_value)=>{
            const list=db_index_types.map(row => {
                let sel='';
                if(row.value == index_value)
                    sel=`selected='selected'`;
                return (`<option ${sel} value='${row.value}'>${row.name}</option>`)
            });
            return list;
        }
        let db_index_type_options='';


        const types_options=data_types.map(row => (`<option value='${row.type}'>${row.name}</option>`))
        const input_types_options=input_types.map(row => {
            let selected='';
            if(row.id == 'textarea')
                selected='selected';
            return (`<option selected='${selected}' value='${row.id}'>${row.name}</option>`);
        })
        const display_types_options=display_types.map(row => (`<option value='${row.id}'>${row.name}</option>`))

        let init_form_data={
            form_name:'',
            model_name:'',
            table_name:'',
            route_name:'',
            migration_path:'',
            migration_status:0,
            middleware_name:'',
            form_style:'',
            soft_delete:1,
            timestamp:1,
            view_format:'',
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
            label_name:'',
            input_type:input_types[0]['id'],
            options_data:'',
            options_query:'',
            field_type:data_types[0]['type'],
            data_length:'',
            default_value:'',
            display_type:display_types[0]['id'],
            validation:'',
            comments:'',
            auto_increment:0,
            index_db:{
                index_name:'',
                index_type:'',
            },
            options:{},
        };

        $(document).ready(function(){
            initForm();
            //handleDBIndex('',0);
        });
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
            formDataBinder('event_keyup_mouseup_handle');
            //formDataBinder('event_keyup_mouseup_handle');
            //formDataBinder('event_change_handle');
        }
        const formDataBinder = (event) => dataBinder(event, data_post, (obj,element) => {
            console.log("test....",element);
            data_post=obj;

            var method=$(element).attr("method");
            var key=$(element).attr("key");
            const match = key.match(/\d+/); // match will be an array with ["123"]
            const index = match ? parseInt(match[0]) : NaN; // num will be 123
            if(!isNaN(index) && method != undefined)
                {
                    let row=data_post.fields[index];
                    //db_index_type_options=getDbIndexOptions(row.index_db.index_type);
                    //console.log('val=',db_index_type_options);
                    setTimeout(async() => {
                        addRow(row,index,1);
                    }, 500);
                }

            //console.log("index no=",key);
            //trRows();
        });
        const handleTableCols=(v)=>{
            var table_name=$(v).val();
            ajaxCall(`/config/table-columns?table_name=${table_name}`,'get',{},function(res){
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
            console.log("obj=",data_post);
            ajaxCall(`/crudautomation/aminpciu/crud/create`,'post',data_post,function(res){});
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
                        $(`#${key}-0`).val(data[key]);
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
        const handleAddRemove=(index,type)=>handleAddRemoveLib(index,type,data_post,(res) => {
            data_post=res;
            trRows();
            bindHtml();
            select2Modal('select2_custom','modal_select2');
        });
        const updateBinder=(index) => updateBinderLib(index,data_post,data_post.fields[index]['sort_id'],(res_obj)=>{

                data_post=res_obj;
                console.log("log",data_post);
                trRows();
                bindHtml();
                select2Modal('select2_custom','modal_select2');
        })
        async function addRow(row,index,isUpdate){
            //var types_options=`<option value='1'>Active</option>`;
            //keyup mouseup
            let div_db_index_content='';let auto_inc='';
            if(row.auto_increment)
                auto_inc='checked';

            db_index_type_options=getDbIndexOptions(data_post.fields[index].index_db.index_type);
            console.log('index type=',data_post.fields[index].index_db.index_type);
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
            var tr=`<tr class='tr-form-crud-${index}'>
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

                        </td>
                        <td>
                            <div class='mb-1'>
                                <select
                                    key='fields[${index}].input_type'
                                    id='data_input_type-${index}'
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'
                                    class='form-control select2_custom keyboard'>
                                        ${input_types_options}
                                </select>
                            </div>
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

                        </td>
                        <td>
                            <div class=''>
                                <textarea
                                    key='fields[${index}].options_data'
                                    id='data_options_data-${index}'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    placeholder='1=>Option1,2=>Option2'
                                    class='keyboard'>${row.options_data}</textarea>
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
                            </div>
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
                            <div class='border_top mb-1'>
                                <select
                                    key='fields[${index}].field_type'
                                    event_keyup_mouseup_handle='change'
                                    id='data_field_type-${index}'
                                    form_name_attr='crud_setup_form'
                                    class='form-control select2_custom keyboard'>
                                    ${types_options}
                                </select>
                            </div>
                            <div class='border_top mb-1'>
                                <input
                                    key='fields[${index}].data_length'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    id='data_data_length-${index}'
                                    value='${row.data_length}'
                                    class='form_input_width keyboard'
                                />
                            </div>
                            <div class='border_top'>
                                <input
                                    key='fields[${index}].default_value'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.default_value}'
                                    id='data_default_value-${index}'
                                    class='form_input_width keyboard' />
                            </div>
                            <div class='border_top'>
                                <input
                                    type='checkbox'
                                    key='fields[${index}].auto_increment'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='1'
                                    value='${row.auto_increment}'
                                    id='data_auto_increment-${index}'
                                    class='form_input_width keyboard' ${auto_inc} /> Auto Increment
                            </div>
                        </td>
                        <td>
                            <input
                                key='fields[${index}].validation'
                                event_keyup_mouseup_handle='keyup'
                                form_name_attr='crud_setup_form'
                                value='${row.default_value}'
                                id='data_validation-${index}'
                                class='form_input_width keyboard' />
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
                            <div>
                                <input
                                    key='fields[${index}].comments'
                                    event_keyup_mouseup_handle='keyup'
                                    form_name_attr='crud_setup_form'
                                    value='${row.comments}'
                                    id='data_comments-${index}'
                                    class='form_input_width keyboard' />
                            </div>
                            <div class='border_top'>
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
                select2Modal(`select2_custom`,'modal_select2');
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
            $(`#data_input_type-${index}`).val(row.input_type).trigger('change');
            $(`#data_field_type-${index}`).val(row.field_type).trigger('change');
            $(`#data_display_type-${index}`).val(row.display_type).trigger('change');
            callback(1);
        }
    </script>
@endsection

