@section("custom_script_amin_pciu_before_amin_pciu")
    <script>
        var form_info=@json($form_info);
        var editable=@json($editable);
        async function handleChangeCrudAuto(v,id,edit_id=''){
            var selectorId=$(v).val();
            var row=form_info.form_details.find(row => row.id == id);
            // console.log("row=",edit_id);
            // console.log("row=",selectorId);
            var selector_id=$(v).attr("selector_id");
            var db_field_name=$(`#${selector_id}`).attr("name");
            var edit_id=editable ? editable[db_field_name] : '';
            console.log("row=",edit_id);
            await ajaxCallCrudAuto(`${row.event_actions.api}`,`${row.event_actions.method}`,{id:selectorId},function(res){
                var options=`<option value='0'>Select</option>`;
                res.map((item) => {
                    var sel='';
                    if(item.id == edit_id)
                        sel=`selected='selected'`;
                    options+=`<option ${sel} value='${item.id}'>${item.name}</option>`;
                });
                $(`#${selector_id}`).html(options);
                select2CustomCrudAuto(`#${selector_id}`);
            });
        }
    </script>
@endsection
