$(function(){
    $(".getinfo").click(function(){
        $.post("adminajax.html",{Intention:'GetUserInfo',ID:$(this).attr('data')},function(data){
            var data=eval('('+data+')');
            if(data.ResultCode==200){
                if(data.Data.Sex==1){
                    var Sex='男';
                }else{
                    var Sex='女';
                }
                if(data.Data.CardType==1){
                    var CardType='身&nbsp;&nbsp;份&nbsp;证';
                }else if(data.Data.CardType==2){
                    var CardType='护&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;照';
                }else{
                    var CardType='其&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;他';
                }
                       var str= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
                           str+='<tr height="86" >';
                           str+='<td class="t1">头&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;像:</td>';
                           str+='<td><img src="'+data.Data.Avatar+'" width="70" height="70"></td>';
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称:</td>';
                           str+='<td>'+data.Data.NickName+'</td>'         
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">等&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级:</td>';
                           str+='<td>LV.'+data.Data.Level+'</td>';  
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名:</td>';
                           str+='<td>'+data.Data.RealName+'</td>';
                           str+='</tr>';
                           str+='<tr height="26">'
                           str+='<td class="t1">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别:</td>';
                           str+='<td>'+Sex+'</td>';    
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">'+CardType+':</td>';
                           str+=' <td>'+data.Data.CardNum+'</td>';
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q:</td>';
                           str+=' <td>'+data.Data.QQ+'</td>';
                           str+='</tr>';
                           str+='<tr height="26">';
                           str+='<td class="t1">最后登录:</td>';
                           str+=' <td>'+data.Data.LastLogin+'</td>';
                           str+='</tr>';   
                           str+='</table>';
                           
                $('#modal-container-973559 .modal-body').html(str);
            }
        })
    })
})