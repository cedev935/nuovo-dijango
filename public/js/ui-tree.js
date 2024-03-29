var UITree = function () {
    var handleSample1 = function () {

        $('.tree_1').jstree({
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
        
        $('.tree_1').on('select_node.jstree', function(e,data) {
            console.log("tree1");
            var html_append=``;
            var str = $('#' + data.selected).text();
            var logiccontent=$(this).parent().siblings(".logic-content");
            var qt_type_in= $(this).parent().siblings(".qt_type");
            console.log(qt_type_in);
            var qt_nm = $(this).siblings(".qt_name");
            var name= str.split(".");
            var id = data.node.id.split("_");
            var route = "/user/questions/get_info";
            if (name.length>1)
            {
            var qt_id =name[0];
            e.preventDefault();
            $.ajax({
                data: {id:qt_id},
            //url: "{{ route('questions.store') }}",
                url: route,
                type: "GET",
                dataType: 'json',
                success: function(response){
                var type=response[0].questiontype;
                if(response[0].content != ""){
                    // var content= JSON.parse(response[0].content);
                    var content= response[0].content;
                    console.log(type);
                    qt_type_in.val(type);
                    qt_nm.val(response[0].id+"."+response[0].question);
    
    
                    if (type == 0)
                    {
                        html_append +=
                            `<div class="row main-content" id="cond_`+ response[0].id +`"  >
                                <div class="col-8 form-group">
                                
                                <div class="form-group form-md-line-input">
                                    <textarea class="form-control" rows="1"></textarea>
                                    <label for="form_control_1">Please enter/select the value</label>
                                </div>                     
                        
                                </div>
                                <div class="col-4">
                                    <div class="form-body">                                    
                                        <div class="form-group ">
                                            <img class="display-image-preview" src="/uploads/image/`+ response[0].questionimage+`"
                                             style="max-height: 150px;">
                                        </div>
                        
                                    </div>
                                </div>
                            </div> `;
                    }
    
                    if (type == 1)
                    {
                       var datacontent = JSON.parse(response[0].content);
                        html_append +=
                    `<div class="row main-content" id="cond_`+ response[0].id +`" >                    
                        <div class="col-7 form-group logic_check">`;
                        $.each(datacontent,function(index,value){
                            if(value.label){
                                var is_checked = "";
                                if('is_checked' in value){
                                    if (value.is_checked == 1) {
                                        is_checked = "checked";
                                    }
                                }
                                html_append +=
                                `<div  class="checkbox">
                                    <label><input class="checkbox_`+ index +` check_box_q" type="checkbox" value="`+ value.score +`" `+ is_checked +`>` + value.label+ `</label>                      
                                </div>`;
                            }
                            
                        });
                        html_append +=       
                                `</div>                
                                <div class="col-4">
                                    <div class="form-body">                                    
                                        <div class="form-group ">
                                            <img class="display-image-preview" src="/uploads/image/`+ response[0].questionimage+`"
                                            style="max-height: 150px;">
                                        </div>
                        
                                    </div>
                                </div>                    
                            </div>`;
                    // for(var i= 0; i< content.length; i++)    
                    //     html_append +=
                    //     `<div  class="checkbox">
                    //         <label><input class="checkbox_`+ i +`" type="checkbox" >` + content[i]+ `</label>                      
                    //     </div>`;
                    
                    // html_append +=       
                    //     `</div>                
                    //     <div class="col-4">
                    //         <div class="form-body">                                    
                    //             <div class="form-group ">
                    //                 <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
                    //                  style="max-height: 150px;">
                    //             </div>
                
                    //         </div>
                    //     </div>                    
                    // </div>`;
                    }
    
                    if (type == 2)
                    {
                        var datacontent = JSON.parse(response[0].content);
                        html_append +=`
                        <div class="row main-content" id="cond_`+ response[0].id +`"  >       
                            <div class="col-7 form-group logic_radio">`;
                            $.each(datacontent,function(index,value){
                                if(value.label){
                                    var is_checked = "";
                                    if(('is_checked' in value)){
                                        if (value.is_checked == 1) {
                                            is_checked = "checked";
                                        }
                                    }
                                    html_append +=
                                    `<div  class="radio">
                                        <label><input class="radio_`+ index  +`" name="opt_radiogroup" value="`+ value.score +`" type="radio" `+ is_checked +`>` + value.label+ `</label>                      
                                    </div>`;
                                }
                                
                            });
                                    
                            html_append +=       
                                `</div>                
                                <div class="col-4">
                                    <div class="form-body">                                    
                                        <div class="form-group ">
                                            <img class="display-image-preview" src="/uploads/image/`+ response[0].questionimage+`"
                                            style="max-height: 150px;">
                                        </div>
                        
                                    </div>
                                </div>                    
                            </div>`;
                    }
    
                    if (type == 3)
                    {
                        html_append +=`   
                        <div class="row main-content logic_img" id="cond_`+ content['id'] +`"  >    
                            `;           
                            var datacontent = JSON.parse(response[0].content);
                            for(var i=0;i< datacontent[0].image.length; i++)
                                html_append +=
                                `<div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
                                    <div  class="checkbox">
                                        <input class="imagebox_`+ i +`" type="checkbox" value="`+ datacontent[0].score[i] +`" class="img_check`+ i +`">                      
                                    </div>
                                    <img src="/uploads/image/` + datacontent[0].image[i]+`"  width="50px" height="50px" style="object-fit:fill">
                                </div>`;
    
                        html_append += `
                            </div>`;
                            
    
                    }
    
                    if (type == 4)
                    {
                        html_append =
                            `<div class="row main-content" id="cond_`+ response[0].id +`"  >
                                <div class="col-12 form-group">
                                
                                    <div class="form-group form-md-line-input">
                                        <textarea class="form-control" rows="1"></textarea>
                                        <label for="form_control_1">Please enter/select the value</label>
                                    </div>  
                                </div>
                            </div> `;
                            html_append = response[0].content;
                    }
                    if (type == 5) {
                        html_append = '<div class="col-12 form-group" id="sortable_rating">';
                        var cont = JSON.parse(content);
                        var len = 0;
                        for(var i = 0; i < cont.length; i++){
                            if(cont[i].label){
                                len++;
                            }
                        }
                        for(var i = 0; i < len; i++){
                            var is_checked = "";
                            if('is_checked' in cont[i]){
                                if (cont[i]['is_checked'] == 1) {
                                    is_checked = "checked";
                                }
                            }
                            html_append += `
                            <div class="radio">
                                <label  style="color:transparent"><input type="radio" class="radio_`+ i +`" `+ is_checked +` value="`+ cont[i].score +`" name="rating">Option</label>
                                <input class="radio_label" type="text" value="`+cont[i].label+`" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;" required>
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                            `;
                        }
                        html_append += `</div>`;
                    }

                    if (type == 6) {
                        html_append = `<div class="col-12  form-group " id="sortable_drop">`;
                        var cont = JSON.parse(content);
                        for(var i = 0; i < cont.length - 1; i++){
                            var is_checked = "";
                            if('is_checked' in cont[i]){
                                if (cont[i]['is_checked'] == 1) {
                                    is_checked = "checked";
                                }
                            }
                            html_append += `
                            <div class="radio">
                                <label  style="color:transparent"><input type="radio" class="radio_`+ i +`" value="`+ cont[i].score +`" `+ is_checked +` name="opt_dropdown">Option 1</label>
                                <input class="radio_label" type="text" value="`+cont[i].label+`" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                            `;
                        }
                        html_append += `</div>`;
                    }

                    if (type == 7) {
                        console.log('File');
                    }

                    if(type == 8){
                        html_append = `<div class="col-12  form-group " id="sortable_stars">`;
                        var cont = JSON.parse(content);
                        var len = 0;
                        for(var i = 0; i < cont.length; i++){
                            if(cont[i].label){
                                len++;
                            }   
                        }
                        for(var i = 0; i < len; i++){
                            var is_checked = "";
                            if('is_checked' in cont[i]){
                                if (cont[i]['is_checked'] == 1) {
                                    is_checked = "checked";
                                }
                            }
                            html_append += `
                            <div class="radio">
                                <label  style="color:transparent"><input type="radio" class="radio_`+ i +`" value="`+ cont[i].score +`" `+ is_checked +` name="stars">Option 1</label>
                                <input class="radio_label" type="text" value="`+cont[i].label+`" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                            `;
                        }
                        html_append += `</div>`;
                    }

                    if(type == 9){
                        var cont = JSON.parse(content);
                        html_append = `<div class="col-12">`;
                        html_append += `
                            <div class="col-12  form-group " id="sortable_drop1">
                                <div class="radio">
                                    <label  style="">
                                        Min Value
                                        <input id="range_min_value" type="text" name="optradio" value="`+cont.min_value+`">
                                    </label>
                                    Max Value 
                                    <input id="range_max_value" type="text" class="radio_label" value="`+cont.max_value+`">
                                    <label>Step</label>
                                    <input id="step_value" type="text"  class ="radio_score mr-2" placeholder="`+response[0]['score']+`">
                                </div>
                            </div>
                            <div class="col-12">
                            <div class="form-group">
                                <label>Select Symbol</label>
                                <select id="range_symbol" class="form-control">`;

                                if(cont.symbol == "0") html_append += `<option value="0" selected>None</option><option value="1">€</option></select>`;
                                if(cont.symbol == "1") html_append += `<option value="0">None</option><option value="1" selected>€</option></select>`;
                            html_append += `
                                </div>
                                    <div class="form-group">
                                        <label>Range Type</label>
                                        <select id="range_type" class="form-control">`;
                                if(cont.symbol == "0") html_append += `<option value="1" selected>Cursor Bar</option><option value="1">+/- Button</option></select>`;
                                if(cont.symbol == "1") html_append += `<option value="2">Cursor Bar</option><option value="1" selected>+/- Button</option></select>`;
                            html_append += `</div>`;
                        html_append += `</div>`;
                        html_append += `</div>`;
                    }

                    logiccontent.html(html_append);    
                }
                },
                error: function(response){
                console.log(response);
                }
            });
            }
            console.log(html_append);   
            $(this).hide();

    
        });
 
        // handle link clicks in tree nodes(support target="_blank" as well)       
       
    }

    var handleSample5 = function () {

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
        
        $('.logic_tree').on('select_node.jstree', function(e,data) { 
            
        //     var str = $('#' + data.selected).text();
        //     var logiccontent=$(this).parent().siblings(".logic-content");
        //     var qt_type_in= $(this).parent().siblings(".qt_type");
        //     var qt_nm = $(this).siblings(".qt_name");

        //     var name= str.split(".");
        //     if (name.length>1)
        //     {
        //     var qt_id =name[0];
        
        //     e.preventDefault();
        // // $(this).html('Sending..');

        //     $.ajax({
        //         data: {id:qt_id},
        //     //url: "{{ route('questions.store') }}",
        //         url: "get_info",
        //         type: "GET",
        //         dataType: 'json',
        //         success: function(response){
        //         var type=response[0]['questiontype']; 
        //         var content= JSON.parse(response[0]['content']);
        //         var html_append=``; 

        //         qt_type_in.val(type);
        //         qt_nm.val(response[0]['id']+"."+response[0]['question']);


        //         if (type == 0)
        //         {
        //             html_append =
        //                 `<div class="row main-content" id="cond_`+ response[0]['id'] +`"  >
        //                     <div class="col-8 form-group">
                            
        //                     <div class="form-group form-md-line-input">
        //                         <textarea class="form-control" rows="1"></textarea>
        //                         <label for="form_control_1">Please enter/select the value</label>
        //                     </div>                     
                     
                        
        //                     </div>
        //                     <div class="col-4">
        //                         <div class="form-body">                                    
        //                             <div class="form-group ">
        //                                 <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
        //                                  style="max-height: 150px;">
        //                             </div>
                    
        //                         </div>
        //                     </div>
        //                 </div> `;
        //         }

        //         if (type == 1)
        //         {
        //             html_append =
        //         `<div class="row main-content" id="cond_`+ response[0]['id'] +`" >                    
        //             <div class="col-7 form-group logic_check">`;
        //         for(var i= 0; i< content.length; i++)    
        //             html_append +=
        //             `<div  class="checkbox">
        //                 <label><input class="checkbox_`+ i +`" type="checkbox" >` + content[i]+ `</label>                      
        //             </div>`;
                
        //         html_append +=       
        //             `</div>                
        //             <div class="col-4">
        //                 <div class="form-body">                                    
        //                     <div class="form-group ">
        //                         <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
        //                          style="max-height: 150px;">
        //                     </div>
            
        //                 </div>
        //             </div>                    
        //         </div>`;
        //         }

        //         if (type == 2)
        //         {
        //             html_append =`
        //         <div class="row main-content" id="cond_`+ response[0]['id'] +`"  >       
        //             <div class="col-7 form-group logic_radio">`;
        //         for(var i= 0; i< content.length; i++)    
        //             html_append +=
        //             `<div  class="radio">
        //                 <label><input class="radio_`+ i +`" type="radio" name="optradio` + response[0]['id']+ `">` + content[i]+ `</label>                      
        //             </div>`;
                            
        //         html_append +=       
        //             `</div>                
        //             <div class="col-4">
        //                 <div class="form-body">                                    
        //                     <div class="form-group ">
        //                         <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
        //                         style="max-height: 150px;">
        //                     </div>
            
        //                 </div>
        //             </div>                    
        //         </div>`;
        //         }

        //         if (type == 3)
        //         {
        //             html_append =`   
        //             <div class="row main-content logic_img" id="cond_`+ response[0]['id'] +`"  >    
        //                 `;           
                    
        //                 for(var i=0;i< content.length; i++)
        //                     html_append +=
        //                     `<div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
        //                         <div  class="checkbox">
        //                             <input class="imagebox_`+ i +`" type="checkbox" class="img_check`+ i +`">                      
        //                         </div>
        //                         <img src="/uploads/image/` + content[i]+`"  width="50px" height="50px" style="object-fit:fill">
        //                     </div>`;

        //             html_append += `
        //                 </div>`;                       

        //         }

        //         if (type == 4)
        //         {
        //             html_append =
        //                 `<div class="row main-content" id="cond_`+ response[0]['id'] +`"  >
        //                     <div class="col-12 form-group">
                            
        //                         <div class="form-group form-md-line-input">
        //                             <textarea class="form-control" rows="1"></textarea>
        //                             <label for="form_control_1">Please enter/select the value</label>
        //                         </div>  
        //                     </div>
                            
        //                 </div> `;
        //         }
        //         logiccontent.html(html_append);
                
                
        //         },
        //         error: function(response){
        //         console.log(response);
        //         }
        //     });
        //     }
                
           //(this).hide();

    
        });
 
        // handle link clicks in tree nodes(support target="_blank" as well)       
       
    }

    var handleSample6 = function () {

        $('.textgroup_tree').jstree({
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
        
        $('.textgroup_tree').on('select_node.jstree', function(e,data) { 
            var str = $('#' + data.selected).text();
            $('#textgroup_name').val(str);
            // var logiccontent=$(this).parent().siblings(".logic-content");
            // var qt_type_in= $(this).parent().siblings(".qt_type");
            // var qt_nm = $(this).siblings(".qt_name");

            // var name= str.split(".");
            // if (name.length>1)
            // {
            // var qt_id =name[0];
        
            // e.preventDefault();
        // $(this).html('Sending..');

            // $.ajax({
            //     data: {id:qt_id},
            // //url: "{{ route('questions.store') }}",
            //     url: "get_info",
            //     type: "GET",
            //     dataType: 'json',
            //     success: function(response){
            //     var type=response[0]['questiontype']; 
            //     var content= JSON.parse(response[0]['content']);
            //     var html_append=``; 

            //     qt_type_in.val(type);
            //     qt_nm.val(response[0]['id']+"."+response[0]['question']);


            //     if (type == 0)
            //     {
            //         html_append =
            //             `<div class="row main-content" id="cond_`+ response[0]['id'] +`"  >
            //                 <div class="col-8 form-group">
                            
            //                 <div class="form-group form-md-line-input">
            //                     <textarea class="form-control" rows="1"></textarea>
            //                     <label for="form_control_1">Please enter/select the value</label>
            //                 </div>                     
                     
                        
            //                 </div>
            //                 <div class="col-4">
            //                     <div class="form-body">                                    
            //                         <div class="form-group ">
            //                             <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
            //                              style="max-height: 150px;">
            //                         </div>
                    
            //                     </div>
            //                 </div>
            //             </div> `;
            //     }

            //     if (type == 1)
            //     {
            //         html_append =
            //     `<div class="row main-content" id="cond_`+ response[0]['id'] +`" >                    
            //         <div class="col-7 form-group logic_check">`;
            //     for(var i= 0; i< content.length; i++)    
            //         html_append +=
            //         `<div  class="checkbox">
            //             <label><input class="checkbox_`+ i +`" type="checkbox" >` + content[i]+ `</label>                      
            //         </div>`;
                
            //     html_append +=       
            //         `</div>                
            //         <div class="col-4">
            //             <div class="form-body">                                    
            //                 <div class="form-group ">
            //                     <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
            //                      style="max-height: 150px;">
            //                 </div>
            
            //             </div>
            //         </div>                    
            //     </div>`;
            //     }

            //     if (type == 2)
            //     {
            //         html_append =`
            //     <div class="row main-content" id="cond_`+ response[0]['id'] +`"  >       
            //         <div class="col-7 form-group logic_radio">`;
            //     for(var i= 0; i< content.length; i++)    
            //         html_append +=
            //         `<div  class="radio">
            //             <label><input class="radio_`+ i +`" type="radio" name="optradio` + response[0]['id']+ `">` + content[i]+ `</label>                      
            //         </div>`;
                            
            //     html_append +=       
            //         `</div>                
            //         <div class="col-4">
            //             <div class="form-body">                                    
            //                 <div class="form-group ">
            //                     <img class="display-image-preview" src="/uploads/image/`+ response[0]['questionimage']+`"
            //                     style="max-height: 150px;">
            //                 </div>
            
            //             </div>
            //         </div>                    
            //     </div>`;
            //     }

            //     if (type == 3)
            //     {
            //         html_append =`   
            //         <div class="row main-content logic_img" id="cond_`+ response[0]['id'] +`"  >    
            //             `;           
                    
            //             for(var i=0;i< content.length; i++)
            //                 html_append +=
            //                 `<div class="col-md-3 col-sm-6 image_box" style="padding-left:20px;width:7vw;height:10vw;" display="inline-flex" >
            //                     <div  class="checkbox">
            //                         <input class="imagebox_`+ i +`" type="checkbox" class="img_check`+ i +`">                      
            //                     </div>
            //                     <img src="/uploads/image/` + content[i]+`"  width="50px" height="50px" style="object-fit:fill">
            //                 </div>`;

            //         html_append += `
            //             </div>`;                       

            //     }

            //     if (type == 4)
            //     {
            //         html_append =
            //             `<div class="row main-content" id="cond_`+ response[0]['id'] +`"  >
            //                 <div class="col-12 form-group">
                            
            //                     <div class="form-group form-md-line-input">
            //                         <textarea class="form-control" rows="1"></textarea>
            //                         <label for="form_control_1">Please enter/select the value</label>
            //                     </div>  
            //                 </div>
                            
            //             </div> `;
            //     }
            //     logiccontent.html(html_append);
                
                
            //     },
            //     error: function(response){
            //     console.log(response);
            //     }
            // });
            // }
                
            //$(this).hide();

    
        });
 
        // handle link clicks in tree nodes(support target="_blank" as well)       
       
    }

    return {
        //main function to initiate the module
        init: function () {
            handleSample1();//question-create
            handleSample5();//chart-create
            handleSample6();//chart-create

        }

    };

}();