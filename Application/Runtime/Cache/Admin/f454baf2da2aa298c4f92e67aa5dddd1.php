<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	
	$('#form_route_route').combobox({
	    url:'/ytqmanager/Admin/Route/getAll',
	    valueField:'id',
	    textField:'name'
	});
	
	$('#form_route_provider').combobox({
	    url:'/ytqmanager/Admin/Provider/getAll',
	    valueField:'id',
	    textField:'name'
	});
	
	$('#form_route_platform').combobox({
	    url:'/ytqmanager/Admin/Platform/getAll',
	    valueField:'id',
	    textField:'name'
	});
	
	var tableList="tableList_order";
	var auForm ="addForm_order";
	var saveBtn="saveBtn_order";
	var addDiv="addDiv_order";
	var cancelBtn="cancelBtn_order";
	
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
		fix:true, 
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		method:'get',
		sortName:'id',
		sortOrder:'desc',
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100],
		url:'/ytqmanager/Admin/Order/pageList',
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
					
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.orderr.alert('警告','请先选择一行！','warning');
				}else{
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[start_time]':selectedRow.start_time,
						'data[end_time]':selectedRow.end_time,
						'data[record_time]':selectedRow.record_time,
						'data[number]':selectedRow.number,
						'data[name]':selectedRow.name,
						'data[mobile]':selectedRow.mobile,
						'data[number]':selectedRow.number,
						'data[route_id]':selectedRow.route_id,
						'data[provider_id]':selectedRow.provider_id,
						
						'data[sale_price]':selectedRow.sale_price,
						'data[purchase_price]':selectedRow.purchase_price,
						'data[pay_price]':selectedRow.pay_price,
						'data[platform_id]':selectedRow.platform_id,
						
						'data[remark]':selectedRow.remark,
					});
					$("#"+addDiv).window('open');
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-times',
			text : '删除',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.orderr.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsDatagrid('/ytqmanager/Admin/Order/delRows',ids,tableList);
				}
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
		    
		]],
		columns:[[  
			{field:'start_time',title:'出发',width:40,sortable:true},
			{field:'end_time',title:'完团',width:40,sortable:true},
			{field:'record_time',title:'登记',width:40,sortable:true},
			{field:'number',title:'人数',width:40,sortable:true},
			{field:'name',title:'名称',width:40,sortable:true},
			{field:'mobile',title:'手机',width:40,sortable:true},
			{field:'route_name',title:'行程',width:40,sortable:true},
			{field:'provider_name',title:'专线',width:40,sortable:true},
			
			{field:'sale_price',title:'卖价',width:40,sortable:true},
			{field:'purchase_price',title:'接价',width:40,sortable:true},
			{field:'pay_price',title:'现收',width:40,sortable:true},
			{field:'platform_name',title:'平台',width:40,sortable:true},
			{field:'store_name',title:'店名',width:40,sortable:true},
			{field:'tax',title:'税点（%）',width:40,sortable:true},
			
			{field:'create_user',title:'创建人',width:40,sortable:true,
				formatter: function(value,row,index){
					if (row.createUser){
						return row.createUser.nickname;
					} else {
						return value;
					}
				}	
			},
			
			{field:'create_time',title:'创建时间',width:40,sortable:true,formatter:formatDatebox},
			{field:'update_user',title:'修改人',width:40,sortable:true,
				formatter: function(value,row,index){
					if (row.updateUser){
						return row.updateUser.nickname;
					} else {
						return value;
					}
				}		
			},
			{field:'update_time',title:'修改时间',width:40,sortable:true,formatter:formatDatebox},
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/ytqmanager/Admin/Order/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
	
	
});

</script>

<div>
 	<div id="search_order" class="easyui-panel" title="搜索面板" style="padding:5px;background:#fafafa;height:80px;" data-options="iconCls:'fa fa-easyui fa-search',collapsible:true">
 		<table>
			<tr>
				<td><div style="width:32px;text-align: right;">行程:</div> </td>
				<td><select id="search_order_route" class="easyui-combobox" panelHeight="auto" style="width:200px;height:26px;"></select></td>
				
				<td><div style="width:32px;text-align: right;">专线:</div> </td>
				<td><select id="search_order_provider" class="easyui-combobox" panelHeight="auto" style="width:200px;height:26px;"></select></td>
			
				<td><div style="width:32px;text-align: right;">平台:</div> </td>
				<td><select id="search_order_provider" class="easyui-combobox" panelHeight="auto" style="width:200px;height:26px;"></select></td>
				
				<td><div style="width:42px;text-align: right;">关键字:</div> </td>
				<td><select id="search_order_provider" class="easyui-textbox" panelHeight="auto" style="width:200px;height:26px;"></select></td>
				
				<td><a id="btn" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'">搜索</a></td>
				
			</tr>
		</table>
		
	</div>
	<table id="tableList_order"></table>

</div>
<div id="addDiv_order" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:700px;height:600px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_order" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>   			
		    			<td><div style="width:62px;text-align: right;">出发:</div></td>
		    			<td><input class="easyui-datebox" name="data[start_time]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>	
		    			
		    			<td><div style="width:62px;text-align: right;">完团:</div></td>
		    			<td><input class="easyui-datebox" name="data[end_time]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>	
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">登记:</div></td>
		    			<td><input class="easyui-datebox" name="data[record_time]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>		    			
		    		
		    			<td><div style="width:62px;text-align: right;">人数:</div></td>
		    			<td><input class="easyui-numberbox" name="data[number]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">姓名:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>		    			
		    		
		    			<td><div style="width:62px;text-align: right;">手机:</div></td>
		    			<td><input class="easyui-textbox" name="data[mobile]" data-options="required:true" style="width:230px;height:30px;" type="text"></input></td>		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;"></div></td>
		    			<td colspan="3">
		    				<div><a id="add_idcard_route" href="javascript:add_idcard_route();" class="easyui-linkbutton"><i class="fa fa-plus-square-o fa-lg"></i>添加身份信息</a></div>
		    				<div id="idcard_container_route">
		    					
		    				</div>
		    			</td>				
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">行程:</div> </td>
						<td><select id="form_route_route" name="data[route_id]" class="easyui-combobox" panelHeight="auto" style="width:230px;height:26px;"></select></td>
						
						<td><div style="width:62px;text-align: right;">专线:</div> </td>
						<td><select id="form_route_provider" name="data[provider_id]" class="easyui-combobox" panelHeight="auto" style="width:230px;height:26px;"></select></td>	    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">卖价:</div> </td>
						<td><input class="easyui-numberbox" id="sale_price_route" name="data[sale_price]" data-options="required:true,min:0,precision:2" style="width:230px;height:30px;" type="text"></input></td>
						
						<td><div style="width:62px;text-align: right;">接价:</div> </td>
						<td><input class="easyui-numberbox" id="purchase_price_route" name="data[purchase_price]" data-options="required:true,precision:2" style="width:230px;height:30px;" type="text"></input></td>    			
		    		</tr>
		    		<tr>
						<td><div style="width:62px;text-align: right;">收现:</div> </td>
						<td><input class="easyui-numberbox" id="pay_price_route" name="data[pay_price]" data-options="precision:2" style="width:230px;height:30px;" type="text"></input></td>    			
		    		
		    			<td><div style="width:62px;text-align: right;">平台:</div> </td>
						<td><select id="form_route_platform" name="data[platform_id]" class="easyui-combobox" panelHeight="auto" style="width:230px;height:26px;"></select></td>	    									
		    		</tr>
		    		<tr>
						<td><div style="width:62px;text-align: right;"></div> </td>
						<td colspan="3">
							<center>
								<div style="width:200px;">
									<div style="height:30px;width:100px;float:left;padding-top:3px;"><a id="count_profit_route" href="javascript:count_profit_route();" class="easyui-linkbutton">计算利润</a></div>
									<div id="display_profit_route" style="background:#FF0000;color:#FFFFFF;height:30px;width:100px;text-align: center;line-height: 30px;float:left;"></div>
								</div>
							</center>
						</td>    	
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">备注:</div></td>
		    			<td colspan="3"><input class="easyui-textbox" name="data[remark]" data-options="multiline:true," style="height:100px;width:550px;"></input></td>
		    		</tr>
		    	</table>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_order" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_order" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>

<script>

function add_idcard_route(){
	$("#idcard_container_route");
}

function count_profit_route(){
	var sale_price=$("#sale_price_route").numberbox('getValue');
	var purchase_price=$("#purchase_price_route").numberbox('getValue');
	
	var o={};
	o['id']=$("#form_route_platform").combobox('getValue');
	var rtr=ajaxReturnRow("/ytqmanager/Admin/Platform/getTax",o);
	var tax=rtr['tax'];
	if(sale_price!=""&&purchase_price!=""&&tax!=null){

		if($("#pay_price_route").numberbox('getValue')==null||$("#pay_price_route").numberbox('getValue')==""){
			var pay_price=0;
		}else{
			var pay_price=parseFloat($("#pay_price_route").numberbox('getValue'));
		}
		
		var count=(sale_price-(purchase_price))*((100-tax)/100)+pay_price;
		$("#display_profit_route").text(count);
		
	}else{
		$.messager.show({
			title:'系统提示',
			msg:'请先填写售价，接价，以及选择平台！',
			showType:'fade',
			style:{
				right:'',
				bottom:''
			}
		});
		return;
	}
}
</script>