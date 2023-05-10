@include('lca-amin-pciu::styles.common')
<div class="card crud-setup-form">
    <h5 class="card-header">
        <div class="d-flex">
            <div class="flex-grow-1">
                Create
            </div>
        </div>
    </h5>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="master-tab" data-bs-toggle="tab" data-bs-target="#master-tab-pane" type="button" role="tab" aria-controls="master-tab-pane" aria-selected="true">Master</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="db-tab" data-bs-toggle="tab" data-bs-target="#db-tab-pane" type="button" role="tab" aria-controls="db-tab-pane" aria-selected="false">Database</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="filter-tab" data-bs-toggle="tab" data-bs-target="#filter-tab-pane" type="button" role="tab" aria-controls="filter-tab-pane" aria-selected="false">Filter</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="style-tab" data-bs-toggle="tab" data-bs-target="#style-tab-pane" type="button" role="tab" aria-controls="style-tab-pane" aria-selected="false">Style</button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="init-data-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#init-data-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="init-data-tab-pane" aria-selected="false">Data Import</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent" style="margin-top: 5px">
            <div class="tab-pane fade show active" id="master-tab-pane" role="tabpanel" aria-labelledby="master-tab" tabindex="0">
                <div style="display: hidden;">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
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
                                <span class="input-group-text form_label_width" id="basic-addon1">
                                    Model Create or Update
                                </span>
                                <select
                                    type="selection"
                                    class="keyboard select2_custom"
                                    key='model_status'
                                    id='model_status-0'
                                    event_keyup_mouseup_handle='change'
                                    form_name_attr='crud_setup_form'>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                </select>
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
                    <div class="row" style="display: none">
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
                                        <div class="col-12">
                                            <input
                                                key='migrate_status'
                                                event_keyup_mouseup_handle='keyup'
                                                id="migrate_status-0"
                                                form_name_attr='crud_setup_form'
                                                type="checkbox"  /> Artisan Migrate ?
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
                                <th scope="col">
                                    Actions
                                    <button
                                        onclick=handleAddRemove(0,1)
                                        type="button" class="btn btn-danger btn-sm">+</button>
                                </th>
                                <th scope="col">Label Name</th>
                                <th scope="col">
                                    <div>Input Type</div>
                                    <div class="border_top">Display Type</div>
                                    <div class="border_top">Event</div>
                                </th>
                                <th scope="col">
                                    <div>Options <br> Data</div>
                                    <div class="border_top">Query</div>
                                </th>
                                <th scope="col">Validation</th>
                                <th scope="col">
                                    <div>Field Name</div>
                                    <div class="border_top">Field Type</div>
                                    <div class="border_top">Length</div>
                                    <div class="border_top">Default Value</div>
                                    <div class="border_top">Comments</div>
                                </th>

                                <th scope="col">Index</th>
                                <th scope="col">
                                    <p class="mn border_top">Sort Id</p>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="crud_rows"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div  class="tab-pane fade" id="db-tab-pane" role="tabpanel" aria-labelledby="db-tab" tabindex="0">
                <div style="display: hidden;">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width" id="basic-addon1">
                                    Where Con.
                                </span>
                                <input type="text"
                                    key='db.where_con'
                                    id="db_where_con-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder='"id"=>1,"name"=>"amin"'
                                    aria-label="Where Condition"
                                    aria-describedby="basic-addon1">

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width" id="basic-addon1">
                                    Where In
                                </span>
                                <input type="text"
                                    key='db.where_in'
                                    id="db_where_in-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder='col1:data1,data2;col2:data1,data2'
                                    aria-label="Where In Condition"
                                    aria-describedby="basic-addon1">

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width" id="basic-addon1">
                                    Where Not In
                                </span>
                                <input type="text"
                                    key='db.where_not_in'
                                    id="db_where_not_in-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder='col1:data1,data2;col2:data1,data2'
                                    aria-label="Where Not In Condition"
                                    aria-describedby="basic-addon1">

                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Where Has
                                </span>
                                <input
                                    type="text"
                                    key='db.where_has'
                                    id="db_where_has-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder="comments,posts"
                                    aria-label="comments,posts">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Where Doesnt Have
                                </span>
                                <input
                                    type="text"
                                    key='db.where_doesnt_have'
                                    id="db_where_doesnt_have-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder="comments,posts"
                                    aria-label="comments,posts">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Where Null
                                </span>
                                <input
                                    type="text"
                                    key='db.where_null'
                                    id="db_where_null-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder="col1,col2">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Where Not Null
                                </span>
                                <input
                                    type="text"
                                    key='db.where_not_null'
                                    id="db_where_not_null-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder="col1,col2">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Order By
                                </span>
                                <input
                                    type="text"
                                    key='db.order_by'
                                    id="db_order_by-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder='"id"=>"asc","name"=>"desc"'>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Group By
                                </span>
                                <input
                                    type="text"
                                    key='db.group_by'
                                    id="db_group_by-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    placeholder='id,name'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="tab-pane fade" id="filter-tab-pane" role="tabpanel" aria-labelledby="filter-tab" tabindex="0">
                <div style="display: hidden;">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width" id="basic-addon1">
                                    Row Per Page
                                </span>
                                <input type="text"
                                    key='db.row_per_page'
                                    type="number"
                                    id="db_row_per_page-0"
                                    event_keyup_mouseup_handle='keyup'
                                    class="keyboard form-control"
                                    form_name_attr='crud_setup_form'
                                    aria-describedby="basic-addon1">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="tab-pane fade" id="style-tab-pane" role="tabpanel" aria-labelledby="style-tab" tabindex="0">
                <div style="display: hidden;">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Style
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <textarea
                                        rows="4"
                                        key='style.css'
                                        id="style_css-0"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Form Col. Size
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <input
                                        key='style.offset'
                                        id="style_offset-0"
                                        event_keyup_mouseup_handle='keyup'
                                        class="form-control"
                                        form_name_attr='crud_setup_form'
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    No of cols per row
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <input
                                        key='style.no_cols_per_row'
                                        id="style_no_cols_per_row-0"
                                        event_keyup_mouseup_handle='keyup'
                                        class="form-control"
                                        form_name_attr='crud_setup_form'
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Style(List)
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <textarea
                                        rows="4"
                                        key='style.css_index'
                                        id="style_css_index-0"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    Form Col. Size(List)
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <input
                                        key='style.offset_index'
                                        id="style_offset_index-0"
                                        event_keyup_mouseup_handle='keyup'
                                        class="form-control"
                                        form_name_attr='crud_setup_form'
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text form_label_width">
                                    No of cols per row(List)
                                </span>
                                <div class="d-flex flex-grow-1 me-1">
                                    <input
                                        key='style.no_cols_per_row_index'
                                        id="style_no_cols_per_row_index-0"
                                        event_keyup_mouseup_handle='keyup'
                                        class="form-control"
                                        form_name_attr='crud_setup_form'
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="tab-pane fade" id="init-data-tab-pane" role="tabpanel" aria-labelledby="init-data-tab" tabindex="0">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="input-group mb-1">
                            <span class="input-group-text form_label_width">
                                Data
                            </span>
                            <div class="d-flex flex-grow-1 me-1">
                                <textarea
                                    rows="6"
                                    placeholder="[['name'=>'Active','status'=>1],['name'=>'Inactive','status'=>1]]"
                                    key='db.init_data'
                                    id="db_init_data-0"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="row mt-2" style="text-align: right">
            <button
                onclick="handleSave()"
                type="button"
                class="btn btn-info">Save</button>
         </div>


    </div>
</div>


