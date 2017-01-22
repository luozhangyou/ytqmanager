<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var tableList="tableList_role";
	var auForm="addForm_role";
	var saveBtn="saveBtn_role";
	var addDiv="addDiv_role";
	var cancelBtn="cancelBtn_role";
	
	var th = $(".top").height();
	th = 111-th
	var wh = $(window).height()-th;
	var pr = 30;
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#"+tableList).datagrid({
		//title:'用户列表',
		idField:'id',
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		method:'get',
		sortName:'id',
		sortOrder:'desc',
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100],
		url:'/taoyongjin/Admin/Role/pageList',
		rownumbers:true,
		fitColumns:true,
		nowrap:true,
		selectOnCheck:false,
		animate:true,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			
		},
		toolbar:[{
		iconCls: 'fa fa-easyui fa-plus-square',
			text : '添加',
			handler: function(){
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					'data[status]':1,
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[name]':selectedRow.name,
						'data[title]':selectedRow.title,
						'data[level]':selectedRow.level,
						'data[status]':selectedRow.status,
						'data[pid]':selectedRow.pid,
						'data[type]':selectedRow.type,
						'data[remark]':selectedRow.remark,
					});
					$("#"+addDiv).window('open');
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-key',
			text : '授权',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var o={};
					o['role_id']=selectedRow.id;
					var rows=ajaxReturnList("/taoyongjin/Admin/Role/getRoleAccess",o);
					var node=null;
					for(var i=0;i<rows.length;i++){
						 node = $('#authTree').tree('find', rows[i].node_id);
						 if(node!=null){
							 $('#authTree').tree('check', node.target);
						 }
					}
					$("#authDiv_role").window("open");
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-times',
			text : '删除',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsDatagrid('/taoyongjin/Admin/Role/delRows',ids,tableList);
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-bolt',
			text : '更新缓存',
			handler: function(){
				
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-check-square-o',
			text : '取消选择',
			handler: function(){
				$('#'+tableList).datagrid('clearSelections'); 
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-retweet',
			text : '重载',
			handler: function(){
				$("#"+tableList).datagrid('reload');
			}
		}],
		frozenColumns:[[   
		    {field:'name',title:'标题',width:200,sortable:true}
		]],
		columns:[[  
			{field:'status',title:'状态',width:100,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '可用'; 
			          }else{  
			              return '不可用';  
			          }  
			   }  	
			},
			{field:'remark',title:'备注',width:100,sortable:true},
			{field:'create_time',title:'创建时间',width:100,sortable:true,formatter:formatDatebox},
			{field:'update_time',title:'修改时间',width:100,sortable:true,formatter:formatDatebox},
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/taoyongjin/Admin/Role/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
	$("#saveBtn_auth_role").click(function(){
		var selectedRow=$('#'+tableList).datagrid('getSelected');
		var o={};
		o['data[id]']=selectedRow.id;
		var nodes = $('#authTree').tree('getChecked');
    	var nodeIds=[];
    	for(var i=0;i<nodes.length;i++){
    		nodeIds.push(nodes[i].id);
    	}
    	o['data[nodeIds]']=nodeIds; 
    	var obj=ajaxReturnList("/taoyongjin/Admin/Role/authorization",o);
    	if(obj.flag){
    		$("#authDiv_role").window("close");
    	}
    	
	});
	$("#cancelBtn_auth_role").click(function(){
		$('#authDiv_role').window('close');
	});
	
	$('#authTree').tree({
		url:'/taoyongjin/Admin/Node/getCombotree',
		editable:true,
		checkbox:true,
		cascadeCheck:false,
		lines:true,method:'get'
	});
});

</script>
<div>
	<table id="tableList_role"></table>
</div>
<div id="addDiv_role" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_role" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    			<td>状态:</td>
		    			<td>
		    				<select name="data[status]" class="easyui-combobox" name="language" style="width:200px;height:30px;" >
		    					<option value="1">可用</option>
		    					<option value="0">不可用</option>
		    				</select>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">备注:</div></td>
		    			<td colspan="3"><input class="easyui-textbox" name="data[remark]" data-options="multiline:true" style="height:100px;width:455px;"></input></td>
		    		</tr>
		    	</table>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_role" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_role" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>

<div id="authDiv_role" class="easyui-window" title="授权" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="authForm_role" class="easyui-form" method="post" data-options="novalidate:true">
				<ul id="authTree"></ul>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_auth_role" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_auth_role" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>