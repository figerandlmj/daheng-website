<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<form name="myform" action="?m=content&c=type_manage&a=listorder" method="post">
<div class="pad_10">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
	<tr>
	<th width="5%">ID</th>
	<th width="10%">目的省</th>
	<th width="10%">目的市</th>
	<th width="10%">体积(㎥)</th>
	<th width="10%">重量(kg)</th>
	<th width="10%">是否自提</th>
	<th width="10%">计费单价(元)</th>
	<th width="10%">计费重量(kg)</th>
	<th width="10%">总价(元)</th>
	<th width="10%">咨询时间</th>
		<th width="*"><?php echo L('operations_manage');?></th>
	</tr>
        </thead>
    <tbody>
    

<?php
foreach($datas as $r) {
?>
<tr>
<td align="center"><?php echo $r['id']?></td>
<td align="center"><?php echo $r['to_province_name']?></td>
<td align="center"><?php echo $r['to_city_name']?></td>
<td align="center"><?php echo $r['volume']?></td>
<td align="center"><?php echo $r['weight']?></td>

<td align="center">
	<?php
	if($r['is_self']==1){
		echo "自提";
	}

	else{
		echo "配送";
	}
	?></td>
<td align="center"><?php echo $r['price']?></td>
<td align="center"><?php echo $r['count_weight']?></td>
<td align="center"><?php echo $r['total_price']?></td>
<td align="center"><?php echo $r['created_at']?></td>
	<td align="center"><a href="javascript:;" onclick="data_delete(this,'<?php echo $r['id']?>','<?php echo trim(new_addslashes("删除？"));?>')"><?php echo L('delete')?></a> </td>


	<?php } ?>
	</tbody>
    </table>
    <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
	<div id="pages"><?php echo $pages;?></div>
</div>

</div>
</form>

<script type="text/javascript">
	<!--
	window.top.$('#display_center_id').css('display','none');
//	function edit(id, name) {
//		window.top.art.dialog({id:'edit'}).close();
//		window.top.art.dialog({title:'修改信息',id:'edit',iframe:'?m=content&c=price_manage&a=edit&id='+id,width:'780',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
//	}
	function data_delete(obj,id,name){
		window.top.art.dialog({content:name, fixed:true, style:'confirm', id:'data_delete'},
			function(){
				$.get('?m=content&c=online_manage&a=delete&id='+id+'&pc_hash='+pc_hash,function(data){
					if(data) {
						$(obj).parent().parent().fadeOut("slow");
					}
				})
			},
			function(){});
	};
	//-->
</script>
</body>
</html>
