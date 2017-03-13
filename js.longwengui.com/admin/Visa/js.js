$(function(){
     $('#addMaterialRequested').click(function(){
                var num=$('.MaterialRequested').length;
//                var t_str= '<tr class="MaterialRequested">';
//                    t_str+='<td width="150px" align="center"><a href="javascript:;" style="color:red;" class="delMaterialRequested">-删除</a></td>';
//                    t_str+='<td></br><input type="text" name="MaterialRequested['+num+'][PersonType]" value=""/> （群体说明）</br></br>';
//                    t_str+='<script id="editor'+num+'" name="MaterialRequested['+num+'][Content]" type="text/plain"></script>';
//                    t_str+='<script>';
//                    t_str+="var ue = UE.getEditor('editor"+num+"',{initialContent:'',initialFrameWidth :1024,initialFrameHeight:300,autoHeightEnabled:false})";
//                    t_str+='</script></td></tr>';  

                 var t_str= '<tr class="MaterialRequested">';
                    t_str+='<td width="150px" align="center"><a href="javascript:;" style="color:red;" class="delMaterialRequested">-删除</a></td>';
                    t_str+='<td></br><input type="text" name="MaterialRequested['+num+'][PersonType]" value=""/> （群体说明）</br></br>';
                    t_str+='<textarea name="MaterialRequested['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:300px;"></textarea>';
                    t_str+='</td></tr>';  
                $('#MaterialRequested').before(t_str);
    })
    
    $('.delMaterialRequested').live('click',function(){
                $(this).parents('tr').remove();
    })    
    
    $('#addServer').click(function(){
        var num=$('.Server').length;
        var str='<div class="Server"><textarea name="Attention[Server]['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:40px;"></textarea> <a href="javascript:;" class="deltextarea" style="color:red">删除</a></div>';
        $(this).before(str);
    })
    
    $('#addInclude').click(function(){
        var num=$('.Include').length;
        var str='<div class="Include"><textarea name="Attention[Include]['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:40px;"></textarea> <a href="javascript:;" class="deltextarea" style="color:red">删除</a></div>';
        $(this).before(str);
    })
    
    $('#addNotice').click(function(){
        var num=$('.Notice').length;
        var str='<div class="Include"><textarea name="Attention[Notice]['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:40px;"></textarea> <a href="javascript:;" class="deltextarea" style="color:red">删除</a></div>';
        $(this).before(str);       
    })
    
    $('#addLiability').click(function(){
        var num=$('.Liability').length;
        var str='<div class="Include"><textarea name="Attention[Liability]['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:40px;"></textarea> <a href="javascript:;" class="deltextarea" style="color:red">删除</a></div>';
        $(this).before(str);           
    })
    
    $('#addImport').click(function(){
        var num=$('.Import').length;
        var str='<div class="Include"><textarea name="Attention[Import]['+num+'][Content]" style="margin-top:5px;margin-bottom:5px;width:1024px;height:40px;"></textarea> <a href="javascript:;" class="deltextarea" style="color:red">删除</a></div>';
        $(this).before(str);            
    })
    
    $('.deltextarea').live('click',function(){
        $(this).parent('div').remove();
    })
})
