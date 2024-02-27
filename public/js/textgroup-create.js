var radio_id= 50;
var save_data = function() {
    if ($('#tests_id').val().length<1) {
        swal({
            title: 'Please select the Test',
            showCancelButton: false,
            confirmButtonText: 'Ok',
            type: 'warning'
        }).then(function (result) {
            $('#tests_id').trigger('focus');
        });
        return;
    }
    if ($("#title").val().trim()=='') {
        swal({
            title: 'Please input the title!',
            showCancelButton: false,
            confirmButtonText: 'Ok',
            type: 'warning'
        }).then(function (result) {
            $("#title").trigger('focus');
        });
        return;
    }
    var bFlag = 0;
    $('.text_msg').map(function() {
        if ($(this).val()=='')
        {
            var obj = $(this);
            swal({
                title: 'Please input the Text!',
                showCancelButton: false,
                confirmButtonText: 'Ok',
                type: 'warning'
            }).then(function (result) {
                obj.trigger('focus');
                return;
            });
            bFlag = 1;
            return;
        }
    }); 
    if (bFlag==1) return; bFlag=0;
    $('.text_score').map(function() {
        if ($(this).val()=='')
        {
            $(this).trigger('focus');
            var obj = $(this);
            swal({
                title: 'Please input the Score!',
                showCancelButton: false,
                confirmButtonText: 'Ok',
                type: 'warning'
            }).then(function (result) {
                obj.trigger('focus');
            });
            bFlag=1;
            return;
        }
    }); 
    if (bFlag==1) return;
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

    logic = logic_build();
    var content=[];
    var score=[];

    $('.content-box').map(function() {
        content.push($(this).find('.text_msg').val());
        score.push($(this).find('.text_score').val());
    }); 

    var data = {
        'test_ids': JSON.stringify($('#tests_id').val()),
        'text_id': $("#textgroup_id").val(),
        'title': $("#title").val(),
        'score': JSON.stringify(score),
        'content': JSON.stringify(content),
        'logic': JSON.stringify(logic)
    };


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        data: {data:data} ,
        url: siteinfo.url_root + "/user/textgroups/update",
        type: "POST",
        dataType: 'json',
        success: function (response) {
            swal("Success", response.success, "success");
        },
        error: function (response) {
            swal("Error", response.error, "error");
            console.log('Error:', response);
        }
    });
};   
var init_treeview = function (text_id, condition_id) {
    $('#condition_'+text_id+'_'+condition_id).find('.logic_tree').removeAttr('class').addClass('logic_tree').jstree({
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
    $('#condition_'+text_id+'_'+condition_id).find('.logic_tree').on('select_node.jstree', function(e, data) { 
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
                url: siteinfo.url_root + "/user/textgroups/get_info",
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
                        radio_id++;
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
                                            <input class="radio_` + i + `" type="radio" name="optradio` + response['data']['id'] + `_` + radio_id + `" value="` + score + `" `+is_checked+`>` + label + `</label>                      
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
    $('#condition_'+text_id+'_'+condition_id).find('.logic_tree').hide();
}
var init_treeview_byText = function (text_id) {
    $('#text_'+text_id).find('.logic_tree').removeAttr('class').addClass('logic_tree').jstree({
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
    $('#text_'+text_id).find('.logic_tree').on('select_node.jstree', function(e, data) { 
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
                url: siteinfo.url_root + "/user/textgroups/get_info",
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
                        radio_id++;
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
                                            <input class="radio_` + i + `" type="radio" name="optradio` + response['data']['id'] + `_` + radio_id + `" value="` + score + `" `+is_checked+`>` + label + `</label>                      
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
    $('#text_'+text_id).find('.logic_tree').hide();
}
var del_text = function(text_id) {
    $('#text_'+text_id).remove();
}
var clone_text = function( text_id ) {
    var t = $('.text-box').children('.text').last().attr('id');
    var new_text_id = (t==null) ? 0 : parseInt(t.split('_')[1])+1;

    var in_html = $('#text_'+text_id).html();
    in_html = in_html.replaceAll('condition_'+text_id+'_', 'condition_'+new_text_id+'_');
    in_html = in_html.replaceAll('condition('+text_id+',', 'condition('+new_text_id+',');
    in_html = in_html.replaceAll('text('+text_id+')', 'text('+new_text_id+')');
    in_html = in_html.replaceAll('_condition('+text_id+')', '_condition('+new_text_id+')');
    in_html = '<div class="row text m-2 p-2 pb-3" id="text_'+new_text_id+'">'+ in_html + '</div>';
    $('.text-box').append(in_html);
    $('#text_'+new_text_id).children('.text-label').html(new_text_id+1);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: siteinfo.url_root + "/user/textgroups/ajax_add_tree_questions",
        type: "GET",
        dataType: 'html',
        success: function (response) {
            if (response!='') {
                $('#text_'+new_text_id).find('.logic_tree').html(response);
                $( document ).ready(function() {
                    init_treeview_byText(new_text_id);
                });
            }
        },
        error: function (response) {
            swal("Error", 'Can not add condition', "error");
        }
    });
}
var add_text = async function(add=true) {
    if ($('#tests_id').val().length<1) {
        swal({
            title: 'Please select the Test',
            showCancelButton: false,
            confirmButtonText: 'Ok',
            type: 'warning'
        }).then(function (result) {
            $('#tests_id').trigger('focus');
        });
        return;
    }

    var t = $('.text-box').children('.text').last().attr('id');
    var text_id = (t==null) ? 0 : parseInt(t.split('_')[1])+1;

    await $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    await $.ajax({
        url: siteinfo.url_root + "/user/textgroups/ajax_add_text",
        type: "POST",
        data: {
            text_id: text_id
        },
        dataType: 'html',
        success: function (response) {
            if (response!='') {
                $('.text-box').append(response);
            }
            
            if(add) add_condition(text_id);
        },
        error: function (response) {
            swal("Error", 'Can not add condition', "error");
        }
    });

    return text_id;
}
var add_condition = function(text_id) {
    if ($('#tests_id').val().length<1) {
        swal({
            title: 'Please select the Test',
            showCancelButton: false,
            confirmButtonText: 'Ok',
            type: 'warning'
        }).then(function (result) {
            $('#tests_id').trigger('focus');
        });
        return;
    }
    var t_c = $('#text_'+text_id).children('.condition-box').children('.condition').last().attr('id');
    var condition_id = (t_c==null) ? 0 : parseInt(t_c.split('_')[2])+1;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: siteinfo.url_root + "/user/textgroups/ajax_add_condition",
        type: "POST",
        data: {
            test_ids: JSON.stringify($('#tests_id').val()),
            text_id: text_id,
            condition_id: condition_id
        },
        dataType: 'html',
        success: function (res) {
            if (res!='') {
                $('#text_'+text_id).children('.condition-box').append(res);
                $( document ).ready(function() {
                    init_treeview(text_id, condition_id);
                });
            }
        },
        error: function (response) {
            swal("Error", 'Can not add condition', "error");
        }
    });
}
var del_condition = function(text_id, condition_id) {
    $('#condition_'+text_id+'_'+condition_id).remove();
}
var clone_condition = function( text_id, condition_id, new_text_id=null) {
    var t_c = $('#text_'+text_id).children('.condition-box').children('.condition').last().attr('id');
    var new_condition_id = new_text_id 
        ? condition_id
        : (t_c==null) ? 0 : parseInt(t_c.split('_')[2])+1;

    if(!new_text_id) {
        new_text_id = text_id;
    }
    
    var in_html = $('#condition_'+text_id+'_'+condition_id).html();
        in_html = in_html.replaceAll('condition('+text_id+', '+condition_id+')', 'condition('+new_text_id+', '+new_condition_id+')');

    var new_html = '<div class="row mt-3 condition" id="condition_'+new_text_id+'_'+new_condition_id+'">'+ in_html + '</div>';

    $('#text_'+new_text_id).children('.condition-box').append(new_html);
    $('#condition_'+new_text_id+'_'+new_condition_id+' .qt_name').html($('#condition_'+new_text_id+'_'+condition_id+' .qt_name').html());

    $('#condition_'+new_text_id+'_'+new_condition_id).find('input').each(function() {
        this.name += `${new_condition_id}_${new_text_id}`;
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: siteinfo.url_root + "/user/textgroups/ajax_add_tree_questions",
        type: "GET",
        dataType: 'html',
        success: function (response) {
            if (response!='') {
                $('#condition_'+new_text_id+'_'+new_condition_id).find('.logic_tree').html(response);
                $( document ).ready(function() {
                    init_treeview(new_text_id, new_condition_id);
                });
            }
        },
        error: function (response) {
            swal("Error", 'Can not add condition', "error");
        }
    });
}

async function clone_all_condition(text_id) {
    const new_text_id = await add_text(false);
    const qtd_conditions = $('#text_'+text_id).find('.condition').length;

    for (let i = 0; i < qtd_conditions; i++) {
        clone_condition(text_id, i, new_text_id);
    }
}

var logic_build = function () {      
    var logic = [];
    var id_list = $('.text-box .text').map(function() {
        return ($(this).attr('id')==null) ? '0' : $(this).attr('id').split('_')[1];
    }); 
    for (var k=0; k<id_list.length; k++ )
    {
        logic[k] =[];
        $('#text_'+id_list[k]).find('.condition').map(function(i) {
            var obj = $(this);
            logic[k][i] =[];
            logic[k][i][0] = $(obj).find(".first_operator").val();                
            logic[k][i][1] = ($(obj).find(".main-content").attr('id')==null) ? '0': $(obj).find(".main-content").attr('id').split("_")[1];
            logic[k][i][2] = $(obj).find(".operators").val();
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
                        //logic[k][i][3]+= Math.pow(2,cnt-j-1);
                }
                logic[k][i][3] = checkeds;
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
                    //logic[k][i][3]+= Math.pow(2,cnt-j-1);
                }
                logic[k][i][3] = checkeds;
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
                        //logic[k][i][3]+= Math.pow(2,cnt-j-1);
                }
                logic[k][i][3] = JSON.stringify(checkeds);
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
                logic[k][i][3] = JSON.stringify(input_vals);
                //logic[k][i][3] = $("#text_" + k + " #" + id_list[k][i]).find("textarea").val();
            }
            else
            {
                logic[k][i][3] = $(obj).find("textarea").val();
            }
        });
    }
    return logic;
};
document.addEventListener('click', event => {
    if (!$(event.target).hasClass('qt_name')
     && !$(event.target).hasClass('jstree-node') && !$(event.target).hasClass('jstree-anchor') 
     && !$(event.target).hasClass('jstree-icon') && !$(event.target).hasClass('jstree-children')
    ) {
        $(".logic_tree").hide();
    }
});
jQuery(document).ready(function(e) {       
    // $(document).on('click', ':checkbox', function () {
    //     var main_content = $(this).closest('.logic-content');
    //     $(main_content).find(':checkbox').not(this).prop('checked', false);    
    // });
    $(document).on('click', '.qt_name', function (e) {
        $(".logic_tree").hide();
        $(this).siblings(".logic_tree").show();
    });
    $('.logic_tree').jstree({
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
    $('.logic_tree').on('select_node.jstree', function(e, data) { 
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
                url: siteinfo.url_root + "/user/textgroups/get_info",
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
                                                    <div class="form-group ">
                                                        <img class="display-image-preview" src="` + img_path + `"
                                                        style="max-height: 150px;">
                                                    </div>
                                    
                                                </div>
                                            </div>                    
                                        </div>`;
                    }
                    else if (type == 2 || type == 5 || type == 6 || type == 8) {
                        var content = JSON.parse(response['data']['content']);
                        radio_id++;
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
                                            <input class="radio_` + i + `" type="radio" name="optradio` + response['data']['id'] + `_` + radio_id + `" value="` + score + `" `+is_checked+`>` + label + `</label>                      
                                        </div>`;
                        }
                        html_append += `</div>                
                                            <div class="col-4">
                                                <div class="form-body">                                    
                                                    <div class="form-group ">
                                                        <img class="display-image-preview" src="` + img_path + `"
                                                        style="max-height: 150px;">
                                                    </div>
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
                                                <div  class="checkbox">
                                                    <input class="imagebox_` + i + `" type="checkbox" class="img_check` + i + `" value="` + scores[i] + `">                      
                                                </div>
                                                <img src="` + image + `"  width="50px" height="50px" style="object-fit:fill">
                                            </div>`;
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
                                                <div class="form-group ">
                                                    <img class="display-image-preview" src="` + img_path + `"
                                                    style="max-height: 150px;">
                                                </div>
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
                                                <div class="form-group ">
                                                    <img class="display-image-preview" src="/uploads/image/` + response['data']['questionimage'] + `"
                                                    style="max-height: 150px;">
                                                </div>
                                
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
    var timer = setTimeout(function () {
        $('.ajax-loading').fadeOut(300);
        clearTimeout(timer);
    }, 1000);
});