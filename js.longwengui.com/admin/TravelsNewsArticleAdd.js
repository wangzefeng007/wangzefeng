$(function(){
     //游记攻略
    $("#CreatePlan").click(function(){
        var num=$('#TripDays').val();
        if(!isNaN(num) && num>0){
            $('.TripPlans').remove();
            for(num;num>0;num--){
                var plan='<tr class="TripPlans">';
                    plan+='<td class="t-r">第'+num+'天:</td>';
                    plan+='<td>';
                    plan+='<div class="col-sm-4">';
                    plan+='<textarea name="TripPlans['+(num-1)+']" rows="2" class="form-control"></textarea> ';
                    plan+='</div>';
                    plan+='</td>';
                    plan+='</tr>';
               $('#TripPlansBlock').after(plan);
           }           
        }else{
            alert("输入的出行天数不是数字或值小于0");
            $('#TripDays').focus();
        }
    })
     
    //篇幅新增
    $("#AddTravelsContent").click(function(){
        var num=$('.TravelsContent').length;
            var t_c_str='<tr class="TravelsContent">';
                //t_c_str+='<td class="t-r"> 篇幅'+(num+1)+'：<br><input class="btn btn-danger DelTravelsContent" type="button" value="删除篇幅" style="margin-top:10px;"/></td>';
                t_c_str+='<td class="t-r"> 篇幅'+(num+1)+'：</td>';
                t_c_str+='<td>';
                t_c_str+='<div class="col-sm-2">';
                t_c_str+='<input name="Content['+num+'][Title]" type="text" value="" class="form-control">';
                t_c_str+='</div>';
                t_c_str+='<span style="position:relative;top:6px;">篇幅标题</span><br><br>';
                t_c_str+='<div class="col-sm-12">';
                t_c_str+='<script id="editor'+num+'" name="Content['+num+'][Content]" type="text/plain" style="width:1024px;height:400px"></script>';
                t_c_str+='<script>';
                t_c_str+="var ue = UE.getEditor('editor"+num+"',{initialContent:'',initialFrameWidth:1024,initialFrameHeight:400,autoHeightEnabled:false});";
                t_c_str+='</script>';
                t_c_str+='</div>';
                t_c_str+='</td>'
                t_c_str+='</tr>';
        $(this).parents('tr').before(t_c_str);
    })
     
//    $('body').delegate('.DelTravelsContent','click',function(){
//        $(this).parents('tr.TravelsContent').remove();
//     })

})