var init_treeview = function (condition_id) {
    $('#condition_'+condition_id).find('.logic_tree').jstree({
        "core" : {
            "themes" : {
                "responsive": false
            }            
        },
        "types" : {
            "default" : {
                "icon" : "fa fa-folder icon-state-warning icon-lg"
            },
            "file" : {
                "icon" : "fa fa-file icon-state-warning icon-lg"
            }
        },
        "plugins": ["types"]
    });    
    $('#condition_'+condition_id).find('.logic_tree').on('select_node.jstree', function(e, data) { 
        if (data.node.children.length>1) {
            return;
        }
        e.preventDefault();
        var str = $.trim($('#' + data.selected).text());
        var logiccontent=$(this).parent().siblings(".logic-content");
        var qt_type_in= $(this).parent().siblings(".qt_type");
        var qt_nm = $(this).siblings(".qt_name");

        var name= str.split(".");
        if (name.length>1) {
            var qt_id = name[0];
            $.ajax({
                data: {id: qt_id},
                url: siteinfo.url_root + "/user/questions/get_info",
                type: "GET",
                dataType: 'json',
                success: function (response) {
                    var type = response['data']['questiontype'];
                    var html_append = ``;
                    qt_type_in.val(type);
                    qt_nm.html(response['in_html']);
                    if (type == 1) {
                        var content = JSON.parse(response['data']['content']);
                        var img_name = response['data']['questionimage'];
                        var img_path = "";
                        if (img_name != null && img_name != "")
                            img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                        html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `" >
                                        <div class="col-7 form-group logic_check">`;
                        for (var i = 0; i < content.length - 2; i++) {
                            var is_checked = "";
                            if (content[i]['is_checked'] == 1) {
                                is_checked = "checked";
                            }
                            var score = content[i]['score'];
                            var label = content[i]['label'];
                            html_append += `<div class="checkbox"><label>
                                                <input class="checkbox_` + i + ` check_box_q" type="checkbox" value="` + score + `" ` + is_checked + ` >` + label + `
                                            </label></div>`;
                        }

                        html_append += `</div>                
                                        <div class="col-4">
                                            <div class="form-body">                                    
                                                <div class="form-group ">`;
                                                if (img_path!='')
                                                html_append += `
                                                    <img class="display-image-preview" src="` + img_path + `"
                                                    style="max-height: 150px;">`;

                        html_append += `        </div>
                                            </div>
                                        </div>                   
                                    </div>`;
                    }
                    else if (type == 2 || type == 5 || type == 6 || type == 8) {
                        var content = JSON.parse(response['data']['content']);
                        var img_name = response['data']['questionimage'];
                        var img_path = "";
                        if (img_name != null && img_name != "")
                            img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                        html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >       
                                <div class="col-7 form-group logic_radio">`;
                        for (var i = 0; i < content.length - 2; i++) {
                            var is_checked = "";
                            if (content[i]['is_checked'] == 1) {
                                is_checked = "checked";
                            }
                            var score = content[i]['score'];
                            var label = content[i]['label'];
                            html_append += `<div class="radio"><label>
                                            <input class="radio_` + i + `" type="radio" name="radio_logic_` + condition_id + `" value="` + score + `" `+is_checked+`>` + label + `</label>                      
                                        </div>`;
                        }
                        html_append += `</div>                
                                        <div class="col-4">
                                            <div class="form-body">                                    
                                                <div class="form-group ">`;
                                                if (img_path!='')
                                                html_append += `
                                                    <img class="display-image-preview" src="` + img_path + `"
                                                    style="max-height: 150px;">`;

                        html_append += `       </div>
                                            </div>
                                        </div>                    
                                    </div>`;
                    }
                    else if (type == 3) {
                        var content = JSON.parse(response['data']['content']);
                        html_append = `<div class="row main-content logic_img" id="cond_` + response['data']['id'] + `"  >`;
                        var images = content[0]['image'];
                        var scores = content[0]['score'];
                        for (var i = 0; i < images.length; i++) {
                            var image = "";
                            if (images[i] != null && images[i] != "")
                                image = siteinfo.url_root+"/public/uploads/image/" + images[i];
                            html_append += `<div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                                <div class="checkbox">
                                                    <input class="imagebox_` + i + `" type="checkbox" class="img_check` + i + `" value="` + scores[i] + `">                      
                                                </div>`;
                            if (image!='')
                            html_append += `    <img src="` + image + `"  width="50px" height="50px" style="object-fit:fill">`;
                            html_append += `</div>`;
                        }
                        html_append += `</div>`;
                    }
                    else if (type == 4) {
                        var img_name = response['data']['questionimage'];
                        var img_path = "";
                        if (img_name != null && img_name != "")
                            img_path = siteinfo.url_root+"/public/uploads/image/" + img_name;
                        var content = response['data']['content'];
                        html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >
                                            <div class="col-12 form-group">` + content;
                        html_append += `</div> 
                                        <div class="col-4">
                                            <div class="form-body">                                    
                                                <div class="form-group ">`;
                                                if (img_path!='')
                                                html_append += `
                                                    <img class="display-image-preview" src="` + img_path + `"
                                                    style="max-height: 150px;">`;
                    html_append += `            </div>
                                            </div>
                                        </div>                   
                                    </div>`;
                    }
                    else {
                        var content = JSON.parse(response['data']['content']);
                        html_append = `<div class="row main-content" id="cond_` + response['data']['id'] + `"  >
                                        <div class="col-8 form-group">
                                            <div class="form-group form-md-line-input">
                                                <textarea class="form-control" rows="1"></textarea>
                                                <label for="form_control_1">Please enter/select the value</label>
                                            </div>  
                                    
                                        </div>
                                        <div class="col-4">
                                            <div class="form-body">                                    
                                                <div class="form-group ">`;
                                            if (response['data']['questionimage']!=null && response['data']['questionimage']!='')    
                        html_append += `            <img class="display-image-preview" src="/uploads/image/` + response['data']['questionimage'] + `" style="max-height: 150px;" />`;
                        html_append += `     </div>
                                
                                            </div>
                                        </div>
                                    </div> `;
                    }
                    logiccontent.html(html_append);
                    $('.custom-hide').remove();


                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
        $(this).hide();
    });

    $(".logic_tree").hide();
}
var add_condition = function() {
    $('.ajax-loading').show();
    var t_c = $('#sortable-14').children('.condition').last().attr('id');
    var condition_id = (t_c==null) ? 0 : parseInt(t_c.split('_')[1])+1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: siteinfo.url_root + "/user/questions/ajax_add_condition",
        type: "POST",
        data: {
            condition_id: condition_id
        },
        dataType: 'html',
        success: function (res) {
            $('.ajax-loading').fadeOut(100);
            if (res!='') {
                $('#sortable-14').append(res);
                $( document ).ready(function() {
                    init_treeview(condition_id);
                });
            }
        },
        error: function (response) {
            $('.ajax-loading').hide();
            swal("Error", 'Can not add condition', "error");
        }
    });
}
var del_condition = function( condition_id ) {
    $('#condition_'+condition_id).remove();
}
var clone_condition = function( condition_id ) {
    var t_c = $('#sortable-14').children('.condition').last().attr('id');
    var new_condition_id = (t_c==null) ? 0 : parseInt(t_c.split('_')[1])+1;
    var in_html = $('#condition_'+condition_id).html();
    in_html = in_html.replaceAll('condition('+condition_id+')', 'condition('+new_condition_id+')');
    var new_html = '<div class="row mt-3 condition" id="condition_'+new_condition_id+'">'+ in_html + '</div>';
    $('#sortable-14').append(new_html);
    $('#condition_'+new_condition_id+' .qt_name').html($('#condition_'+condition_id+' .qt_name').html());
    $( document ).ready(function() {
        init_treeview(new_condition_id);
    });
}
var logic_build = function () {      
    var logic = [];
    $('.condition').map(function(i) {
        var obj = $(this);
        logic[i] =[];
        logic[i][0] = $(obj).find(".first_operator").val();                
        logic[i][1] = ($(obj).find(".main-content").attr('id')==null) ? '0': $(obj).find(".main-content").attr('id').split("_")[1];
        logic[i][2] = $(obj).find(".operators").val();
        var qt_type = $(obj).find(".qt_type").val();
        if(qt_type == 1)
        {
            var cnt=$(obj).find(".logic_check").children().length;
            //updated by Polaris
            let checkeds = 0;
            for (var j=0;j< cnt; j++)
            {
                if( $(obj).find(".logic_check  .checkbox_"+j).is(':checked') == true)
                    checkeds = $(obj).find(".logic_check  .checkbox_"+j).val();
                    //logic[i][3]+= Math.pow(2,cnt-j-1);
            }
            logic[i][3] = checkeds;
        }
        else if(qt_type == 2 || qt_type==5 || qt_type==6 || qt_type==8)
        {
            // radio box
            var cnt= $(obj).find(".logic_radio").children().length;//is(':checked');
            let checkeds = 0;
            for (var j=0;j< cnt; j++)
            {
                if($(obj).find(".logic_radio  .radio_"+j).is(':checked') == true)
                    checkeds = $(obj).find(".logic_radio  .radio_"+j).val();
                //logic[i][3]+= Math.pow(2,cnt-j-1);
            }
            logic[i][3] = checkeds;
        }
        else if(qt_type == 3)
        {
            var cnt=$(obj).children().length;//is(':checked');
            let checkeds = [];
            for (var j=0; j< cnt; j++)
            {
                let check_val = 0;
                if($(obj).find(".imagebox_"+j).is(':checked') == true)
                    check_val = 1;
                checkeds.push(check_val);
                    //logic[i][3]+= Math.pow(2,cnt-j-1);
            }
            logic[i][3] = JSON.stringify(checkeds);
        }
        else if(qt_type == 4) {
            let input_vals = [];
            let rowcnt = $("#text_" + k + " #" + id_list[k][i]).find('table tbody tr').length;
            let colcnt = $("#text_" + k + " #" + id_list[k][i]).find('table tbody th').length;
            let input_idx = 1;
            for (let i = 1; i < rowcnt; i++) {
                for (let j = 1; j < colcnt; j++) {
                    let input_val = $('#q_id'+input_idx).val();
                    input_vals.push(input_val);
                    input_idx++;
                }
            }
            logic[i][3] = JSON.stringify(input_vals);
            //logic[i][3] = $("#text_" + k + " #" + id_list[k][i]).find("textarea").val();
        }
        else
        {
            logic[i][3] = $(obj).find("textarea").val();
        }
    });
    return logic;
};
var QuestionCreate = function() {

    // Global var
    var currentRow = 1;
    var numberCol = 0;
    var numberRow = 0;
    
    $(document).on('click', '.qt_name', function (e) {
        $(".logic_tree").hide();
        $(this).siblings(".logic_tree").show();
    });

    document.addEventListener('click', event => {
        if (!$(event.target).hasClass('qt_name')
         && !$(event.target).hasClass('jstree-node') && !$(event.target).hasClass('jstree-anchor') 
         && !$(event.target).hasClass('jstree-icon') && !$(event.target).hasClass('jstree-children')
        ) {
            $(".logic_tree").hide();
        }
    });
    /**
    * On Question Input Type Change
    * Show the Relevant Question Box
    **/
    $('#question_type').change(function() {
        //Hide All Input Question Types
        $(".question-box").hide();
        
        var selected_text = parseInt($("#question_type option:selected").val());
        $("#more_than_one_answer_box").hide();
        $("#score-box").hide();
        switch (selected_text) {
            //Single Input
            case 0:
                $('#single_input_part').show();
                $("#more_than_one_answer_box").show();
                //$("#score-box").show();
                break;
            //Checkbox
            case 1:
                $('#checkbox_part').show();
                $("#score-box").hide();
                break;
            //RadioGroup
            case 2:
                $('#radiogroup').show();
                $("#score-box").hide();
                break;
            //ImagePart
            case 3:
                $('#image_part').show();
                break;
            //Matrix
            case 4:
                $('#matrix_part').show();
                break;
            //Rating
            case 5:
                $('#rating_part').show();
                var increment = 10;
                $("#rating_part .radio").each(function(){
                    $(this).find('.radio_label').val(increment);
                    increment+=10;
                });
                $("#score-box").hide();
                break;
            //Dropdown
            case 6:
                $('#dropdown_part').show();
                break;
            //File
            case 7:
                $('#file_upload_input').show();
                break;
            //Star
            case 8:
                $('#rating_part').show();
                var i = 1;
                $("#rating_part .radio").each(function(){
                    $(this).find('.radio_label').val(i++);
                });
                $("#score-box").hide();
                break;
            //Range
            case 9:
                $('#rangs_part').show();
                break;
            //€
            case 10:
                $('#euro_part').show();
                break;
            default:
                $('#single_input').show();
                break;
        }

    });

    var image_part_data = [];
    $(".image-upload-form").on('change', function(e) {
        e.preventDefault();
        var v = $('.image_score').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '/user/questions/upload-images',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response) {
                    if($('#question_id').val()){
                        if(e.target.type == "file"){
                            var imge_names = $(e.target).siblings();
                            $(imge_names[0]).val("");
                            var len = response.img_name.length;
                            $(imge_names[0]).val(response.img_name[len-1]);
                        }
                    }else{
                        var temp_img = {};
                        temp_img['image'] = response.img_name;
                        temp_img['score'] = v;
                        image_part_data = temp_img;
                        console.log(image_part_data);
                    }
                }

            },
            error: function(response) {
                console.log(response);
            }
        })
    });

    $("#img").on('change', function(e) {
        e.preventDefault();
        let formData = new FormData($("#question_type_image")[0]);
        var route = '/user/questions/upload-images';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: route,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                swal('success','Image uploaded to the server.','success');
                const preview = $('#preview.new-image');

                preview.find('.quiz_img').val(response.img_name);
                preview.removeClass('new-image');
            },
            error: function(response) {
                swal('error','Error in uploading the image.','error');
            }
        })
    });

    $('.remove-image').on('click', function() {
        this.parentElement.remove();
    });
    
    var check_id = 2;
    var col_add = 0;

    $('#checkbox_part').on('click', '.del-btnx', function() {
        // var parentID = $(this).parent().attr('id');
        // var id = parentID.split('_')[2];
        // console.log(id);
        $(this).parent().remove();
    });

    $("#check_add").on('click', function() {
        check_id++;
        $("#sortable-10").append(`
        <div class="checkbox">
            <label  style="color:transparent"><input type="checkbox" value="">Option 1 </label>  
            <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input type="text" class="checkbox_score" value="0" style="margin-right:1vw">
        
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="` + 12 + `">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>`);
    });
    
    $("#check_add_euro").on('click', function() {
        $("#euro_part #sortable-12").append(`
        <div class="checkbox">
            <label  style="color:transparent"><input type="checkbox" value="">Option 1 </label>  
            <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
            <label  >Score</label>
            <input type="text" class="checkbox_score" value="0" style="margin-right:1vw">
        
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="` + 12 + `">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>`);
    });

    $('#radio_part').on('click', '.del-btnx', function() {
        $(this).parent().remove();
    });
    
    $(document).on("click", "#euro_part #sortable-12 .checkbox .del-btnx", function(){
        $(this).parent().remove();
    })

    $("#radio_add").on('click', function() {
        check_id++;
        $("#sortable-11").append(`
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="opt_radiogroup">Option 1</label>
            <input class="radio_label" type="text" value="radio" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
            <label label>Score</label>
            <input class="radio_score" type="text"  style="margin-right:1vw">
        
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="` + 12 + `">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>`);
    });

    $('#dropdown_part').on('click', '.del-btnx', function() {
        $(this).parent().remove();
    });

    $("#dropdown_add").on('click', function() {
        check_id++;
        $("#sortable_drop").append(`
        <div class="radio">
            <label  style="color:transparent"><input type="radio" name="radio">Option</label>
            <input class="radio_label" type="text" value="` + check_id + `" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
            <label label>Score</label>
            <input class="radio_score" type="text"  style="margin-right:1vw">
        
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="` + 12 + `">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>`);
    });

    $('#rating_part').on('click', '.del-btnx', function() {
        $(this).parent().remove();
    });

    $('#rangs_part').on('click', '.del-btnx', function() {
        $(this).parent().remove();
    });

    $("#rating_add").on('click', function() {
        check_id++;
        $("#sortable_rating").append(`
        <div class="radio">
            <label  style=""><input type="radio" name="optradio" checked>Option</label>
            <input class="radio_label" type="text" value="` + check_id + `" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
            <label label>Score</label>
            <input class="radio_score" type="text"  style="margin-right:1vw">
        
            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="` + 12 + `">
                <i class="fa fa-trash" style="color:white"></i>
            </a>
        </div>`);
    });

    $('#image_panel').on('click', '.del-btnx', function() {
        $(this).parent().parent().parent().parent().parent().remove();
    });

    $('#col_panel').on('click', '.del-btnx', function() {
        $(this).parent().parent().remove();
    });

    $('#row_panel').on('click', '.del-btnx', function() {
        $(this).parent().parent().remove();
    });

    var html_cont;
    var questiontype = '';
    var row_column = 0;
    var matrix_data = '';
    $('#mat_update').on('click', function() {
        $('#real_matrix').children().remove();
        $('#score_matrix').children().remove();
        html_cont = `
                        <tr>
                            <td><input type="text" placeholder="" class="form-control" value="  " disabled></td>`;

        for (var i = 2; i <= $("#col_panel").children().length; i++) {
            html_cont += `<td>`;
            var caption = $("#col_panel div:nth-child(" + i + ")").find("input").val();
            html_cont += `<input type="text" placeholder="" class="form-control" value="` + caption + `" disabled>`;
            html_cont += `</td>`;
        }
        html_cont += `</tr>`;

        for (var j = 2; j <= $("#row_panel").children().length; j++) {
            html_cont += `<tr><td width="15%">`;
            var caption = $("#row_panel div:nth-child(" + j + ")").find("input").val();
            html_cont += `<input type="text" placeholder="" class="form-control" value="` + caption + `" disabled></td>`;

            for (var i = 2; i <= $("#col_panel").children().length; i++) {
                html_cont += `<td> <input type="text"  placeholder="" class="form-control" ></td>`;
            }
            html_cont += `</tr>`;
        }
        $("#real_matrix").append(html_cont);

        $("#score_matrix").append(html_cont);
    });

    $("#add_col").on('click', function(e) {
        if($('#add-matrix th').length == 0){
            e.preventDefault();
        }else{
            row_column = $('#add-matrix tr').length - 1;
            console.log(row_column);
            questiontype = $("#matrix_symbol").val();
            $('#row_add').data('columns',parseInt($("#row_add").data('columns'))+1);
            var add_q_id = 1;
            col_add++;
            var last_Q_id = parseInt($('#last_q_id').val());
            var q_id = last_Q_id + add_q_id;
            numberCol--;
            var scoreinput = '';
            var radiocol = '';
            if($(".selecttype").val() == "radio"){
                $("#add-matrix").attr('matrix-type', 'radio');
                scoreinput = '<input type="text" data-q_id="q_id'+col_add+'" data-value="" class="form-control col-10 d-inline radioscore" value=""  onchange="radioScore(this)">';
                radiocol = 'col-2';
            }
            if($('#add-matrix tr').length <= 2){
                var add_head_col = '<th scope="row" class="custom-border"><label contenteditable="true" class="form-label">Column</label></th>';
                var add_col = '<td class="custom-border"><input id="q_id'+col_add+'" type='+$(".selecttype").val()+' value="" name="matrix'+$(".selecttype").val()+row_column+'" class="form-control radioselected d-inline '+radiocol+' q_id[q_id]'+col_add+'" onchange="inputToData(this)" data-questiontype="'+questiontype+'" data-value="" data-selected="false" data-q_id="q_id'+col_add+'">'+scoreinput+'</td>';
            }else{
                if(numberCol > 2){
                    var add_col = '<td class="custom-border"><input id="q_id'+col_add+'" type='+$(".selecttype").val()+' value="" name="matrix'+$(".selecttype").val()+row_column+'" class="form-control radioselected d-inline '+radiocol+'  q_id[q_id]'+col_add+'" onchange="inputToData(this)" data-questiontype="'+questiontype+'" data-value="" data-selected="false" data-q_id="q_id'+col_add+'">'+scoreinput+'</td>';
                }
            }
            $("#header_row_col"+(currentRow-1)).append(add_head_col);
            $("#mr"+(currentRow-1)).append(add_col);
            }
    });

    // Delete Row
    $("#add-matrix").on("click", "#delete_matrix_row", function() {
        $(this).closest("tr").remove();
        if($('#add-matrix tr').length == 1){
            $("#header_row_col"+(($('#add-matrix tr').length))).remove();
            $("#add_col").slideDown();
            $('#row_add').data('columns',0);
        }
        currentRow--;
        numberRow--;
     });

    $("#row_add").on('click', function() {
        var columns = parseInt($(this).data('columns'));
        if($('#add-matrix tr').length>=1){
            currentRow =  $('#add-matrix tr').length;
        }
        if($("#question_id").val()){
            col_add = $('#add-matrix tr td').length;
            columns = (col_add/(currentRow-2))-2;
        }
        numberCol = $("#add-matrix tr th").length;
        numberRow = $('#add-matrix tr').length;
        var row_column = numberRow - 1;
        // if($("#mr"+currentRow).length){
        //     currentRow = currentRow + 1;

        // }
        var add_row = '';
        if(numberRow <= 0){
            if(($('#add-matrix tr').length+1) == 1){
                add_row += '<tr id="header_row_col'+currentRow+'"><th class="custom-hide">Action</th><th class=""></th></tr>';
            }
        }
        
        var scoreinput = '';
        var radiocol = '';
        var add_col = '';
        
        if(currentRow > 1){
            row_column ++;
            $("#add_col").slideUp();
            for(var i=0;i<columns;i++){
                col_add++;
                var selecttype = "text";
                if($(".selecttype").val() == "radio" || $("#add-matrix").attr('matrix-type') == "radio"){
                    selecttype = "radio";
                    scoreinput = '<input type="text" data-q_id="q_id'+col_add+'" data-value="" class="form-control col-10 d-inline radioscore" value="" onchange="radioScore(this)">';
                    radiocol = 'col-2';
                }
                add_col += '<td class="custom-border"><input id="q_id'+col_add+'" type='+selecttype+' value="" name="matrix'+selecttype+row_column+'" class="form-control radioselected d-inline '+radiocol+' q_id[q_id]'+col_add+'" onchange="inputToData(this)" data-questiontype="'+questiontype+'" data-value="" data-selected="false" data-q_id="q_id'+col_add+'">'+scoreinput+'</td>';
            }

        }
        add_row += '<tr id="mr'+currentRow+'"><td class="custom-hide"><button class="btn btn-danger" id="delete_matrix_row"><i class="fa fa-trash"></i></button></td><td scope="row" class="custom-border"><label contenteditable="true" class="form-label ">Row</label></td></tr>';
        
        $("#add-matrix").append(add_row);        
        $("#mr"+currentRow).append(add_col);        
        currentRow++;
        numberCol++;
    });

    $("#width").on('change', function() {
        $(".main-content").css("width", $("#width").val());
    });

    $("#font_size").on('change', function() {
        $('div').css("font-size", parseInt($("#font_size").val()));
        $('input').css("font-size", parseInt($("#font_size").val()));
    });

    $("#indent").on('change', function() {
        $(".main-content").css("margin-left", parseInt($("#indent").val()));
    });

    $("#image_width").on('change', function() {
        $(".fileinput-preview").css("width", parseInt($("#image_width").val()));
    });

    $("#image_height").on('change', function() {
        $(".fileinput-preview").css("height", parseInt($("#image_height").val()));
    });

    $("#image_fit").on('change', function() {
        $(".fileinput-preview").css("object-fit", $("#image_fit option:selected").text());
    });

    $('.file').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('.display-image-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    
    $('#img').change(function() {
        let reader = new FileReader();

        reader.onload = (e) => {
            const preview = $('#preview-clone').clone(true).insertAfter('#preview-clone');
            
            preview.addClass('new-image');
            preview.removeClass('hidden');

            preview.attr('id', 'preview');

            preview.find('input').addClass('quiz_img');
            preview.find('img').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
    });

    $(".image-upload-form").on('click', '.add-btn', function() {
        var lsthmtl = $(".clone-sample").html();
        $(".increment").after(lsthmtl);
    });

    $(".image-upload-form").on("click", ".del-btn", function() {
        $(this).parents(".image_part_file").remove();
    });

    $(document).on('click', '#sortable-10 .check_box_q', function () {
        $('#sortable-10 .check_box_q').not(this).prop('checked', false);    
    });

    $(document).on('click', '.main-content .check_box_q', function () {
        var main_content = $(this).closest('.main-content');
        $(main_content).find(':checkbox').not(this).prop('checked', false);    
    });

    $('#save_data').on('click', function(e) {
        var bFlag=0;
        $('.qt_name').map(function() {
            if ($(this).html()=='')
            {
                var obj = $(this);
                swal({
                    title: 'Please select the Question in Condition Logic!',
                    showCancelButton: false,
                    confirmButtonText: 'Ok',
                    type: 'warning'
                }).then(function (result) {
                    obj.trigger('click');
                    return;
                });
                bFlag = 1;
                return;
            }
        }); 
        if (bFlag==1) return; bFlag=0;
        // If FormSubmitFlag is true then submit the form
        var formSubmitFlag = true;
        var errorMessage = "";
        
        //If the Question Text is Missing, Show Error Message
        // if(CKEDITOR.instances.question_content.getData().length<=0){
        //     swal("Warning","Please write the question!","warning");
        //     return;
        // }
        
        //Get Question Type
        var type_id = parseInt($("#question_type option:selected").val());
        //Get Score
        var score = $("#score").val();
        // if($("input[type='radio'].helpaccess").is(':checked')) {
            var hint = $("input[type='radio'].helpaccess:checked").val();
            var hintaccess = $("input[type='radio'].hintaccess:checked").val();
        // }
        
        // Content for Question Type
        var content;
        // Validate Form Based on the Question Type
        switch(type_id) {
            //Single Input
            case 0:
                var temp_arr = [];
                $value = $("#single_input_part").find("#single_input_value").val()
                temp_arr.push({
                    'value':$value,
                    'width': $("#single_input_part").find("#single_input_width").val(),
                    'height': $("#single_input_part").find("#single_input_height").val()
                })
                content = JSON.stringify(temp_arr);
                break;
            //Checkbox
            case 1:
                var temp_arr = [];
                $("#checkbox_part #sortable-10 .checkbox").each(function(e){
                    if($(this).find(".check_label").val().trim()==""){
                        formSubmitFlag = false;
                        errorMessage = "Checkbox Title Missing!";
                    }
                    var checkbox_content = {};
                    checkbox_content['label'] = $(this).find(".check_label").val();
                    checkbox_content['score'] = $(this).find(".checkbox_score").val().trim() ?? 0;
                    checkbox_content['is_checked'] =  $(this).find(".check_box_q").is(":checked") ? 1 : 0;
                    temp_arr.push(checkbox_content);
                });
                temp_arr.push({
                    'col' : $("#display_checkbox").val()
                });
                temp_arr.push({
                    'display' : $("#display_checkbox option:selected").text()
                });
                content = JSON.stringify(temp_arr);
                break;
            //RadioGroup
            case 2:
                var temp_arr = [];
                $("#radiogroup .radio").each(function(e){
                    if($(this).find(".radio_label").val().trim()==""){
                        formSubmitFlag = false;
                        errorMessage = "Radio Group Field Title Missing!";
                    }
                    var checkbox_content = {};
                    checkbox_content['label'] = $(this).find(".radio_label").val();
                    checkbox_content['score'] = $(this).find(".radio_score").val().trim() ?? 0;
                    checkbox_content['is_checked'] =  $(this).find("input[type='radio']").is(":checked") ? 1 : 0;
                    temp_arr.push(checkbox_content);
                });
                temp_arr.push({
                    'col' : $("#display_radiogroup").val()
                });
                temp_arr.push({
                    'display' : $("#display_radiogroup option:selected").text()
                });
                content = JSON.stringify(temp_arr);
                break;
            //Rating
            case 5:
            //Star
            case 8:
                var temp_arr = [];
                $("#rating_part #sortable_rating .radio").each(function(e){
                    if($(this).find(".radio_label").val().trim()==""){
                        formSubmitFlag = false;
                        errorMessage = "Radio Group Field Title Missing!";
                    }
                    var checkbox_content = {};
                    checkbox_content['label'] = $(this).find(".radio_label").val();
                    checkbox_content['score'] = $(this).find(".radio_score").val().trim() ?? 0;
                    checkbox_content['is_checked'] =  $(this).find("input[type='radio']").is(":checked") ? 1 : 0;
                    temp_arr.push(checkbox_content);
                });
                temp_arr.push({
                    'col' : $("#display_rating").val(),
                });
                temp_arr.push({
                    'display' : $("#display_rating option:selected").text(),
                });
                temp_arr.push({
                    'color' : $("#color").val()
                });
                content = JSON.stringify(temp_arr);
                break;
            //ImagePart
            case 3:
                var temp_arr = [];
                if($("#question_id").val()){
                    var v = $('.image_score').map(function(idx, elem) {
                        if($(elem).val() != ""){
                        return $(elem).val()}
                    }).get();

                    var images = $('.imge_names').map(function(idx, elem) {
                        if($(elem).val() != ""){
                            return $(elem).val()}
                    }).get();

                    var description = $('.image_description').map(function(idx, elem) {
                        if($(elem).val() != ""){
                            return $(elem).val()
                        }
                    }).get();

                    var temp_img = {
                        image: images,
                        score: v,
                        description
                    };

                    image_part_data = temp_img;
                    temp_arr.push(image_part_data);

                }else{
                    temp_arr.push(image_part_data);
                    // $("#image_part .image_part_file").each(function(e){
                    //     $(this).find(".image_score").val().trim()
                    //     if($(this).find(".image_score").val().trim() == ""){
                    //         formSubmitFlag = false;
                    //         errorMessage = "Image Score Missing!";
                    //     }
                    //     var image_files = {};
                    //     image_files['score'] = ($(this).find(".image_score").val().trim() == 'undefined')?0:$(this).find(".image_score").val().trim();
                    //     temp_arr.push(image_files);
                    // });
                }
                temp_arr.push({
                    'col' : $("#display_image").val()
                });
                temp_arr.push({
                    'display' : $("#display_image option:selected").text(),
                });
                content = JSON.stringify(temp_arr);
                $('#image_part').show();
                break;
            //Matrix
            case 4:
                let text_vals = [];
                let checked_vals = [];
                $('.radioselected').each(function(){
                    let vals = [];
                    vals.push($(this).data('q_id'));
                    vals.push($(this).val());
                    text_vals.push(vals);
                    if($(this).is(":checked")){
                        checked_vals.push($(this).data('q_id'));
                    }
                });
                $('#add-matrix td input[type="radio"]').each(function (i,ele) {
                    let id = $(ele).data("q_id");
                    if(checked_vals.includes(id)) {
                        $(ele).attr('checked', 'checked');
                    }else{
                        $(ele).removeAttr('checked');
                    }
                });
                
                // <tr><th>Value in "+$("#matrix_symbol").val()+"</th></tr>
                $('#add-matrix').before("<h1>"+$("#matrix_symbol").val()+"</h1>");
                $("#symbol_matrix_value").html("");
                $('#add-matrix td input[type="text"]').each(function (i,ele) {
                    // if($('#add-matrix').attr('matrix-type') == 'checkbox'){
                        let id = $(ele).data("q_id");
                        for(var i = 0; i < text_vals.length; i++) {
                            if(id == text_vals[i][0]) {
                                $(ele).attr('value', text_vals[i][1]);
                                break;
                            }
                        }
                    // }
                });
                $('#add-matrix td input[type="checkbox"]').each(function (i,ele) {
                    if($(ele).is(":checked")){
                        let vals = [];
                        checked_vals.push($(this).data('q_id'));
                    }
                });
                console.log(checked_vals);
                matrix_data = $("<div />").append($("#add-matrix").clone()).html();
                if($("#add-matrix tr").length > 1){
                    formSubmitFlag = true;
                }
                $('#matrix_part').show();
                break;
            //Dropdown
            case 6:
                var temp_arr = [];
                $("#dropdown_part #sortable_drop .radio").each(function(e){
                    if($(this).find(".radio_label").val().trim()==""){
                        formSubmitFlag = false;
                        errorMessage = "Radio Title Missing!";
                    }
                    var checkbox_content = {};
                    checkbox_content['label'] = $(this).find(".radio_label").val();
                    checkbox_content['score'] = $(this).find(".radio_score").val().trim() ?? 0;
                    checkbox_content['is_checked'] =  $(this).find("input[type='radio']").is(":checked") ? 1 : 0;
                    temp_arr.push(checkbox_content);
                });
                temp_arr.push($('#display_radio').val());
                content = JSON.stringify(temp_arr);
                break;
            //File
            case 7:
                $('#file_upload_input').show();
                var temp_arr = [];
                $value = $("#file_upload_input").find("#num_files").val();
                var file_acceptable_exts = $("#file_upload_input").find("#file_acceptable_exts").val();
                var file_max_size = $("#file_upload_input").find("#file_max_size").val();
                temp_arr.push({
                    'number':$value,
                    'file_acceptable_exts': file_acceptable_exts,
                    'file_max_size': file_max_size
                })
                content = JSON.stringify(temp_arr);
                break;
            //Range
            case 9:
                var temp_content = {};
                temp_content['min_value'] = $("#rangs_part #range_min_value").val() ?? 0 ;
                temp_content['max_value'] = $("#rangs_part #range_max_value").val() ?? 0;
                temp_content['steps'] = $("#step_value").val() ?? 0;
                score = $("#rangs_part .radio_score").val() ?? 0;
                temp_content['symbol'] = $("#rangs_part #range_symbol").val() ?? 0;
                temp_content['type'] = $("#rangs_part #range_type").val() ?? 0;
                content = JSON.stringify(temp_content);
                break;
            //€
            case 10:
                var temp_arr = [];
                $("#euro_part #sortable-12 .checkbox").each(function(e){
                    if($(this).find(".check_label").val().trim()==""){
                        formSubmitFlag = false;
                        errorMessage = "Checkbox Title Missing!";
                    }
                    var checkbox_content = {};
                    checkbox_content['label'] = $(this).find(".check_label").val();
                    checkbox_content['score'] = $(this).find(".checkbox_score").val().trim() ?? 0;
                    checkbox_content['is_checked'] =  $(this).find("input[type='radio']").is(":checked") ? 1 : 0;
                    checkbox_content['label'] = $(this).find(".check_label").val();
                    temp_arr.push(checkbox_content);
                });
                temp_arr.push({
                    'width': $("#euro_part").find("#euro_input_width").val(),
                    'height': $("#euro_part").find("#euro_input_height").val()
                })
                content = JSON.stringify(temp_arr);
                break;
            default:
                $('#single_input').show();
                break;
        }
        
        if(formSubmitFlag==false){
            swal("error",errorMessage,"error");
            return;
        }
        var selected = [],
            selected_cat = [];
        $('#tests_id option:selected').each(function() {
            selected[$(this).val()] = $(this).val();
        });
        
        var k = 0;
        for (var i = 0; i < selected.length; i++) {
            if (selected[i] != null) {
                selected_cat[k] = selected[i];
                k++;
            }
        }
        // Bilal Change
        // var route = '/user/questions/update';
        // Original One 
        var route = '/user/questions';
        var answerposition = $("#answerposition").val();
        var imageposition = $("#imageposition").val();
        var answer_aligment = $("#answer_aligment").val();
        var image_aligment = $("#image_aligment").val();
        var title_aligment = $("#title_aligment").val();
        var question_bg_color = $("#question_bg_color").val();

        var color1 = $("#color1").val();
        var color2 = $("#color2").val();
        
        var logic = logic_build();

        const questionImages = $(".quiz_img").map((_, element) => element.value).get();
        
        const imageForm = Object.fromEntries(
            new FormData($("#image_form")[0]).entries()
        );
        
        const answerForm = Object.fromEntries(
            new FormData($("#answer_form")[0]).entries()
        );
        
        const titleForm = Object.fromEntries(
            new FormData($("#title_form")[0]).entries()
        );

        if($("#question_id").val()){
        
            route = route + "/update";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            route = route ;  
                // Orignal Ajax 
         //fin ajax 
            $.ajax({
                    data : {
                        /**
                    * Form Data
                    **/
                   'question_id': $("#question_id").val(),
                   '_method' : 'PUT',
                   'type_id': type_id,
                   'test_ids': selected_cat,
                   'question': CKEDITOR.instances.question_content.getData(), //$("#question_content").val(),
                   'help_info': CKEDITOR.instances["help-editor"].getData(), //$("#help-editor").val(),
                   'hint_info': CKEDITOR.instances["hint-editor"].getData(), //$("#hint-editor").val(),
                   'questionimage': questionImages,
                   'score': score,
                   'hint': hint,
                   'hintaccess':hintaccess,
                   'content': content,
                   'logic': JSON.stringify(logic),
                   'answerposition' : answerposition,
                   'title_aligment' : title_aligment,
                   'image_aligment' : image_aligment,
                   'answer_aligment' : answer_aligment,
                   'imageposition' : imageposition,
                   'question_bg_color': question_bg_color,
                   //Properties
                   
                   //'page' : $("#question_page").val(),
                   //'order' :$("#question_order").val(),
                   'required': $("#required").is(":checked") ? 1 : 0,
                   'more_than_one_answer': $("#more_than_one_answer").is(':checked') ? 1 : 0,
                   'state': $("#state option:selected").val() ?? null,
                   
                   'titlelocation': $("#title_location option:selected").val() ?? null,
                   'help_info_location': $("#help_info_location option:selected").val() ?? null,
                   
                   'indent': $("#indent").val() ?? null,
                   'width': $("#width").val() ?? null,
                   'min_width': $("#min_width").val() ?? null,
                   'max_width': $("#max_width").val() ?? null,
                   
                   'size': $("#size").val() ?? null,
                   'fontsize': $("#font_size").val() ?? "",
                   
                   'imagefit': $("#image_fit option:selected").val() ?? '',
                   'imagewidth': $.trim($("#image_width").val()) ?? '',
                   'imageheight': $.trim($("#image_height").val()) ?? '',
                   'matrix_data' : matrix_data,
                   
                   'color1': color1,
                   'color2': color2,

                   ...imageForm,
                   ...answerForm,
                   ...titleForm,
                },
                ////url: "{{ route('questions.store') }}",
                url: route,
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    swal("Success", "Question Updated!", "success");
                    // location.href = location.href;
                },
                error: function(response) {
                    var responseTextObject = jQuery.parseJSON(response.responseText);
                    swal("Error!", "Fill in the form correctly!", "error");
                }
            });
        }
        else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                data: {
                    /**
                    * Form Data
                    **/
                    'type_id': type_id,
                    'test_ids': selected_cat,
                    'question': CKEDITOR.instances.question_content.getData(), //$("#question_content").val(),
                    'help_info': CKEDITOR.instances["help-editor"].getData(), //$("#help-editor").val(),
                    'hint_info': CKEDITOR.instances["hint-editor"].getData(), //$("#hint-editor").val(),
                    'questionimage': questionImages,
                    'score': score,
                    'hint': hint,
                    'hintaccess':hintaccess,
                    'content': content,
                    'logic': JSON.stringify(logic),
                    'answerposition' : answerposition,
                    'image_aligment' : image_aligment,
                    'answer_aligment' : answer_aligment,
                    'imageposition' : imageposition,
                    'question_bg_color': question_bg_color,
                    //Properties
                    
                    //'page' : $("#question_page").val(),
                    //'order' :$("#question_order").val(),
                    'required': $("#required").is(":checked") ? 1 : 0,
                    'more_than_one_answer': $("#more_than_one_answer").val() ?? 0,
                    'state': $("#state option:selected").val() ?? null,
                    
                    'titlelocation': $("#title_location option:selected").val() ?? null,
                    'help_info_location': $("#help_info_location option:selected").val() ?? null,
                    
                    'indent': $("#indent").val() ?? null,
                    'width': $("#width").val() ?? null,
                    'min_width': $("#min_width").val() ?? null,
                    'max_width': $("#max_width").val() ?? null,
                    
                    'size': $("#size").val() ?? null,
                    'fontsize': $("#font_size").val() ?? "",
                    
                    'imagefit': $("#image_fit option:selected").val() ?? '',
                    'imagewidth': $.trim($("#image_width").val()) ?? '',
                    'imageheight': $.trim($("#image_height").val()) ?? '',
                    'matrix_data' : matrix_data,

                    'color1': color1,
                    'color2': color2,

                   ...imageForm,
                   ...answerForm,
                   ...titleForm,
                },
                ////url: "{{ route('questions.store') }}",
                url: route,
                type: "POST",
                success: function(response) {
                    if(response.add == 1){
                        $("#add_another_question").css('display','inline');
                    }
                    swal("Success", "Question Created!", "success");
                },
                error: function(response) {
                    var responseTextObject = jQuery.parseJSON(response.responseText);
                    swal("Error!", "Fill in the form correctly!", "error");
                }
            });
        }
        //
    });

    return {
        init: function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    };    

}();