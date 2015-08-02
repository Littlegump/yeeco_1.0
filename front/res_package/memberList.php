<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../background/conf/connect.php');
$sId=$_POST['sId'];
$depName=$_POST['depName'];

//获取用户社团关系信息
$user_society_r=mysql_query("select userId,isManage,depBelong,position from user_society_relation where societyId='$sId' and depBelong='$depName'");
if($user_society_r && mysql_num_rows($user_society_r)){
	    while($row = mysql_fetch_assoc($user_society_r)){			
			$user_r[]=$row;
			$uInfo[]=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$row[userId]'"));
			$ueInfo[]=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$row[userId]'"));
		}
}
echo "<script>var depName='$depName';</script>";
?>
<ul class="table">
                <li><span>选择</span><span>姓名</span><span>专业班级</span><span>手机号码</span><span>部门</span><span>职位</span><span>操作</span></li>
<?php 
		$i=0;
		if($user_r){
			foreach($user_r as $value_2){
				if($depName=='0'){
					$depName='未分配';
				}
?>				
                <li>
                <span><input type="checkbox" id="<?php echo $value_2['userId']?>" value="<?php echo $value_2['userId']?>" name="member_<?php echo $depName?>[]"/></span><span><img src="../<?php echo $uInfo[$i]['userFace']?>"/><?php echo $ueInfo[$i]['userName']?><?php echo $ueInfo[$i]['userSex']?></span><span><?php echo $ueInfo[$i]['userClass']?></span><span><?php echo $ueInfo[$i]['userTel']?></span><span><?php echo $depName?></span><span class="limit"><?php echo $value_2['position']?></span><span class="cap"><a href="javascript:void(0)" class="table_b">删除</a><a href="javascript:void(0)" class="table_c">调换部门</a><a href="javascript:void(0)" class="table_d">发送通知</a></span>
                             
                </li>
<?php 
				$i++;
			}
		}	
?>     
                <li><span><input type="checkbox" class="check_all" id="all_<?php echo $depName?>" value="<?php echo $depName?>" onchange="select_all()"/></span><span style="border-right:0;"><label for="all_<?php echo $depName?>">全选</label></span><a href="" id="load_more">加载更多<i></i></a></li>
              </ul>
        	  <div class="handle">
                <p>操作：</p><a href="javascript:void(0)" id="h1" class="h1">删除</a><a href="javascript:void(0)" id="h2" class="h2">调换部门</a><a href="javascript:void(0)" id="h3" class="h3">发送通知</a>
              </div>
            <div style="clear:both;"></div>
<script>
 	var jsTarget='#content_'+depName;

	//权限管理
	if($('#authority').val()=='成员'){
		
		$(".table_b").remove();
		$(".table_c").remove();
		$(".h1").remove();
		$(".h2").remove();
		$(".h3").css({
			"margin":"0 65px",
			"width":"200px"
		});
	}
	//单选与全选
	$(jsTarget+" :checkbox").click(function(){
		var depName = $(this).attr("value");
		if($(this).attr("id")== "all_"+depName){
			//获取所要全选的部门的dId，该ID存储在全选按钮的value值当中	
			if(this.checked){
				$(":checkbox[name='member_"+depName+"[]']").prop('checked',true)
				$(":checkbox[name='member_"+depName+"[]']").parent().parent().css("background","#ffffd7");
			}else{
				$(":checkbox[name='member_"+depName+"[]']").prop('checked',false)
				$(":checkbox[name='member_"+depName+"[]']").parent().parent().css("background","#fff");
			}
		}else{
			if(this.checked){
				$(this).parent().parent().css("background","#ffffd7");
			}else{
				$(this).parent().parent().css("background","#fff");
			}
		}	
	})
	
	//删除单一成员 table_b
	$(jsTarget+" .table_b").click(function(){
		var uId=new Array();
		var i=0;
		uId[i] = $(this).parent().parent().find(":checkbox").attr("value");
		var depName = $(this).parent().parent().parent().find(".check_all").attr("value");
		var sId=$("#sId").val();
		if($('#authority').val()=='创建人'){
			if($('#uId').val()==uId[i]){
				alert("您是该社团创建人，无法删除自己！");
			////**************************************在这里执行异步提交以后的内容
			}else{
				i++;
				$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}
											
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})	
			}
		}else if($('#authority').val()=='管理员'){
			if($('#uId').val()==uId[i]){
				alert("您是该社团部门管理员，无法删除自己！");
			}else if($('#user_dep').val()==depName){
				i++;
				$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}
											
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})	
			}else{
				alert("您只能删除自己部门的成员！");				
			}
		}
	})
	//调换单一成员部门 table_c
	$(jsTarget+" .table_c").click(function(){
		var uId = $(this).parent().parent().find(":checkbox").attr("value");
		position = $(this).parent().parent().find(".limit").text();
		//设置权限
		if($('#authority').val()=='创建人'){
			if($('#uId').val()==uId){
				alert("您是该社团创建人，无法调换自己！");
			}else if(position!='成员'){
				alert("只能调换成员！");
			}else{
				var target = $(this).parent().parent();
				var html = "<input type='hidden' name='aim_member[]' value='"+uId+"'/>";
				$(html).appendTo(".change_dep form");
				$(".change_dep").appendTo(target).show();
				$(document).one("click", function (){//对document绑定一个影藏Div方法
					$(".change_dep").hide();
				});
				event.stopPropagation();
			}
		}else{
			alert("只有社团创建人可以调换部门！");
		}
	})
	//批量调换
	$(jsTarget+" .h2").click(function(){
		var depName = $(this).parent().parent().find(".check_all").attr("value");
		var c=0;
		var t=0;
		var html="";
		$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
			if (this.checked){ 
				c++;
				var limit = $(this).parent().parent().find(".limit").text();
				if(limit != '成员'){
					t++;
				}
			}
		})
		if(c==0){
			alert("您没有勾选任意一个成员！");
		}else if(t!=0){
			alert("您只能调换成员，请重新勾选！");
		}else{
			var uId=new Array();
			var i=0;
			$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
				if (this.checked){ 									
					uId[i] = $(this).parent().parent().find(":checkbox").attr("value");
					html = "<input type='hidden' name='aim_member[]' value='"+uId[i]+"'/>";
					$(html).appendTo(".change_dep form");
					i++;
				}
			})
			if($('#authority').val()=='创建人'){
				var target = $(this).parent().parent();
				//alert(x)
				
				$(".change_dep").appendTo(target).show();
				$(document).one("click", function (){//对document绑定一个影藏Div方法
					$(".change_dep").hide();
				});
				event.stopPropagation();
			}else{
				alert("只有社团创建人可以调换部门！");
			}
		}
	})
	$(".change_dep").click(function (event){
		event.stopPropagation();//阻止事件向上冒泡
	});
	
	//发送通知 table_d
	$(jsTarget+" .table_d").click(function(){
		var x = $(this).parent().parent().find(":checkbox").attr("value");
		alert(x)
	})
	
	//批量删除选中的指定部门的成员
	$(jsTarget+" .h1").click(function(){
		var depName = $(this).parent().parent().find(".check_all").attr("value");
		var sId=$("#sId").val();
		var c=0;
		var t=0;
		$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
			if (this.checked){ 
				c++;
				var limit = $(this).parent().parent().find(".limit").text();
				if(limit != '成员'){
					t++;
				}
			}
		})
		if(c==0){
			alert("您没有勾选任意一个成员！");
		}else if(t!=0){
			alert("您只能删除成员，请重新勾选！");
		}else{
			var uId=new Array();
			var i=0;
			$("input[name='member_"+depName+"[]']:checkbox").each(function () { 
				if (this.checked){ 									
					uId[i] = $(this).parent().parent().find(":checkbox").attr("value");
					i++;
				}
			})
			if($('#authority').val()=='创建人'){
				$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}
											
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})	
			}else if($('#authority').val()=='管理员'){
				if($('#user_dep').val()==depName){
					$.ajax({
						type:"POST",
						url:"../background/background_society/society_modify_form.php?action=del_societyMembers&sId="+sId+"&depName="+depName,
						data:{
							uId:uId,
						},
						success:function(data){
							for(var j=0;j<i;j++){
								$('#'+uId[j]).parent().parent().remove();
							}
											
						},
						error:function(jqXHR){alert("操作失败"+jqXHR.status);}
					})	
				}else{
					alert("您只能删除自己部门的成员！");				
				}
			}
		}
		})

</script>