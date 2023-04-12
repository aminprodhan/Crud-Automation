<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('aminpciu/crudautomation/assets/js/select2.min.js') }}"></script>
{{-- <script>
    window.addEventListener("click", function (e) {
        console.log('ee=',e);
        if (
            e.target.classList.contains("nav-top-arrow-left") ||
            e.target.classList.contains("nav-top-left-icon")
        ) {
            navbarTop.scrollLeft -= 100;
        }
        if (
            e.target.classList.contains("nav-top-arrow-right") ||
            e.target.classList.contains("nav-top-right-icon")
        ) {
            navbarTop.scrollLeft += 100;
        }
    });
</script> --}}
<script>
    var form_name_id_keyboard_shorcut='';
    let timerInterval='';let b_loader_content ='';
    $(document).ready(function(){
        select2Modal('select2_custom','modal_select2');
    });
    function closeAlert(){
        Swal.close();
    }
    function customAlert(title,html='',loader=false){

        const init={
            title: title,
            html: 'I will close in <b></b> milliseconds.',
            //timer: 2000,
            //timerProgressBar: true,
        };
        if(html != '')
            init['html']=html;
        if(loader){
            init['didOpen']=() => {
                Swal.showLoading();
            }
        }
        Swal.fire(init)
        .then((result) => {
            /* Read more about handling dismissals below */
            // if (result.dismiss === Swal.DismissReason.timer) {
            //     console.log('I was closed by the timer')
            // }
        })
    }

    const updateKeyboardShortcutFormId=(form_key_id)=>{
        form_name_id_keyboard_shorcut='crud-setup-form';
    }
    let keysStep=[];
    const input_config=[
        {
            form_id:'crud_setup_form',
            inputs:[
                {name:'form_name',next:'model_name',previous:''},
                {name:'model_name',next:'table_name',previous:'form_name'},
                {name:'table_name',next:'migration_path',previous:'model_name'},
                {name:'migration_path',next:'migration_status',previous:'table_name'},
                {name:'migration_status',next:'route_name',previous:'migration_path'},
                {name:'route_name',next:'middleware_name',previous:'migration_status'},
                {name:'middleware_name',next:'form_style',previous:'route_name'},
                {name:'form_style',next:'data_sort_id',previous:'middleware_name'},
                {name:'data_sort_id',next:'data_label_name',previous:'form_style',initRow:1},
                {name:'data_label_name',next:'data_input_type',previous:'data_sort_id'},
                {name:'data_input_type',next:'data_display_type',previous:'data_label_name'},
                {name:'data_display_type',next:'data_options_data',previous:'data_input_type'},
                {name:'data_options_data',next:'data_field_name',previous:'data_display_type'},
                {name:'data_field_name',next:'data_field_type',previous:'data_options_data'},
                {name:'data_field_type',next:'data_data_length',previous:'data_field_name'},
                {name:'data_data_length',next:'data_default_value',previous:'data_field_type'},
                {name:'data_default_value',next:'',previous:'data_data_length'},
                //{name:'data-options_data',next:'data-',previous:'data-display_type'},
            ]
        }
    ];
    const keyType=[
        {code:40,key_name:'name',type:'RowChange',inc:1,pressType:'Bottom'},
        {code:39,key_name:'next',type:'sameRow',inc:0,pressType:'Right'},
        {code:13,key_name:'next',type:'sameRow',inc:0,pressType:'Right'},
        {code:38,key_name:'name',type:'RowChange',inc:-1,pressType:'Up'},
        {code:37,key_name:'previous',type:'sameRow',inc:0,pressType:'Left'},
        {code:-1,key_name:'name',type:'RowChange',inc:1,pressType:'Bottom'},
        //{code:8,key_name:'previous',type:'sameRow',inc:0,pressType:'Left'},
    ];
    $(document).on("keypress",".keyboard",function(e){
        var code = e.keyCode ? e.keyCode : e.which;
        console.log("keypress=",code);
        initKey($(this).attr("id"),code);
    });
    $(document).on("click",".keyboard option",function(e){
        var code = e.keyCode ? e.keyCode : e.which;
        console.log('code=',code);
    });
    $(document).on("keyup",".keyboard",function(e){
        var code = e.keyCode ? e.keyCode : e.which;

        if(code == 13)
            return;
        initKey($(this).attr("id"),e.which);
    });

    const initKey=(input,which_key)=>{

        var idSplit=input.split('-');
        console.log('split=',idSplit);
        var rowId=idSplit[1];
        var classKey=idSplit[0];

        var formId=$(`#${input}`).attr('form_name_attr');
        keysStep=input_config.find(row => row.form_id == formId);
        if(keysStep != undefined){
            keysStep=keysStep['inputs'];
            //console.log('formId',keysStep);
            handleKeyPress(rowId,which_key,classKey);

        }

        //var classKey=$(this).attr("data-classkey");
    }

    function handleKeyPress(rowId,keyCode,classKey){
        let isExistKeyType=keyType.find(row => row.code == keyCode);
        let isExistKeyStep=keysStep.find(row => row.name == classKey);
        console.log('is exist=',isExistKeyType);
        console.log('is setup=',isExistKeyStep);
        if(isExistKeyType != undefined && isExistKeyStep != undefined){
            var nextRowId=parseInt(rowId) + isExistKeyType.inc;
            console.log('next='+("#"+isExistKeyStep[isExistKeyType.key_name]+"-"+nextRowId) );
            setTimeout(() => {
                if(isExistKeyStep[isExistKeyType.key_name] == '')
                    {
                        nextRowId++;
                        isExistKeyType=keyType[keyType.length - 1];
                        isExistKeyStep=keysStep.find(row => row.initRow == 1);
                        console.log('next=',isExistKeyStep);
                    }
                $("#"+isExistKeyStep[isExistKeyType.key_name]+"-"+nextRowId).focus();
            }, 100);

        }
    }

    // $(document).on("keyup",".keyboard",function(e){
    //     var rowId=$(this).attr("data-rowid");
    //     var classKey=$(this).attr("data-classkey");
    //     handleKeyPress(rowId,e.which,classKey);
    // });

    const select2Modal = (cls, modal_name) => {
            $('.' + cls).select2({
                dropdownParent: $("." + modal_name),
                //allowClear: true,
                width: '100px',
                height: '34px',
                placeholder: 'select..'
            });
        }
    const getBinderLogic=(object,input,key_splited,default_value)=>{

        var obj_key=key_splited ?? input.attr('key');

       /* var obj_key_split=key_splited ?? input.attr('key').split(":");
        var obj=`['${obj_key_split[0]}']`;
        for(var i=1;i<obj_key_split.length;i++){
            if(!Array.isArray(eval('object'+obj)))
                obj+=`['${obj_key_split[i]}']`;
            else
                {
                    //console.log(obj);
                    obj=`[`+obj+']'+`[${obj_key_split[i]}]`;
                }
        }
        var value=key_splited ? default_value : input.val();
        //var logic='object'+obj+'='+(typeof value == "number" ? value : `'${value}'`);*/
        var value=key_splited ? default_value : input.val();
        if(!key_splited){
            if(input.attr('type') == 'checkbox' || input.attr('type') == 'radio'){
                if(input.is(":checked"))
                    value=1;
                else
                    value=0;
            }

        }
        var logic='copyObj.'+obj_key+'='+(typeof value == "number" ? value : `'${value}'`);

        //var logic='object'+obj;
        return logic;
    }
    const handleAddRemoveLib=(index,type,data_post,callback)=>{
            if(type == 1){
                var clone= Object.assign({}, init_obj);
                var len=data_post.fields.length;
                clone.sort_id=(data_post.fields[len - 1]['sort_id']) + + 1;
                data_post.fields.push(clone);
                callback(data_post);
                //console.log('pre=',data_post);
            }
            else{
                const filtered=data_post.fields.filter((item,i) => {
                    if(i != index)
                        return true;
                    return false;
                });
                data_post.fields=filtered;
                callback(data_post);
            }
        }
    const updateBinderLib=async(index,object,value,callback)=>{
        //var obj_key=$(input);
        console.log("index=",index);
        var len=object['fields'].length;
        for (let i = (index +1),j=1; i < len; i++,j++) {
            //const element = object['fields'][i];
            //obj_key=['fields',i,'sort_id'];
            obj_key='fields['+i+'].sort_id';
            var logic=getBinderLogic(object,null,obj_key,(parseInt(value) + parseInt(j)));
            //console.log(logic);
            //var copyObj=await deepClone(object);
            let copyObj = JSON.parse(JSON.stringify(object));
            eval(logic);
            object=copyObj;
        }
        //console.log(object);
        callback(object);

    }
    const getCrudRow=(index,data_post,callback)=>{
            callback(data_post.fields[index],data_post);
    }
    async function deepClone(obj) {


        console.log("clone obj4=",obj);
        if (obj === null || typeof obj !== 'object') {
            return obj;
        }
        let clonedObj = Array.isArray(obj) ? [] : {};
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                clonedObj[key] = await deepClone(obj[key]);
            }
        }
        //console.log("clone obj=",clonedObj);
        return clonedObj;
    }

    const dataBinder = (bind_key, object, callback) => {
            var handler=$(`[${bind_key}]`).attr(bind_key);
            //console.log("change=",handler);
            $(`[${bind_key}]`).on('keyup mouseup change', async function (event) {
                    let element = event.target;
                    if(event.which == 13)
                        return;
                    if(handler == 'change')
                    {
                        initKey($(this).attr("id"),13);
                    }
                    var obj_key=$(this);

                    var logic=getBinderLogic(object,obj_key);
                    //console.log('logic22=',element.value);

                    let copyObj = JSON.parse(JSON.stringify(object));
                    //var copyObj=await deepClone(object);
                    //console.log("copy=",object);
                    //copyObj[['fields']][1]['index_db']['index_type']='index';
                    eval(logic);
                    object=copyObj;
                    console.log("obj=",object);

                    //eval(logic);
                    //console.log('logic=',object[['fields']][1]['index_db']);

                    callback(object,element);
            })
        }
    const ajaxCall = (url, method, data = {}, callback, callbackError) => {
        customAlert('Loading...','<h1>Pls wait some moments</h1>',true);
        console.log(data);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: method,
            data: data,
            success: function (data) {
                console.log(data);
                callback(data);
                closeAlert();
            },
            error: function (error) {
                closeAlert();
                //callSweetAlert('error', '<p class="text-danger">Something Went Wrong..!!!!</p>');
                //console.log(data);
                if (typeof callbackError != 'undefined') {
                    callbackError(error);
                }
            }
        });
    }
    const ajaxCallWithFormData = (url, method, formData = {}, callback, callbackError) => {
        $('#loader').show();
        $.ajax({
            url: url,
            method: method,
            data: formData,
            // dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data);
                // $('#loader').hide();
                callback(data);
            },
            error: function (error) {
                callSweetAlert('error', '<p class="text-danger">Something Went Wrong..!!!!</p>');
                console.log(error);
                if (typeof callbackError != 'undefined') {
                    callbackError(error);
                }
            }
        });
    }
</script>
