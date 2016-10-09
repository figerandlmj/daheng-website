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
			<th width="10%">自提单价</th>
			<th width="10%">派送单价</th>
			<th width="*">最低派送费</th>
			<th width="*">最低自提费</th>
			<th width="30%"><?php echo L('operations_manage');?></th>
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
<td align="center"><?php echo $r['item_self_price']?></td>
<td align="center">+<?php echo $r['item_send_price']?></td>
<td align="center"><?php echo $r['lowest_price']?></td>
<td align="center"><?php echo $r['lowest_self_price']?></td>
<td align="center"><a href="javascript:edit('<?php echo $r['id']?>')"><?php echo L('edit');?></a> | <a href="javascript:;" onclick="data_delete(this,'<?php echo $r['id']?>','<?php echo trim(new_addslashes("删除？"));?>')"><?php echo L('delete')?></a> </td>
</tr>
<?php } ?>
	</tbody>
    </table>
    <div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
	<div id="pages"><?php echo $pages;?></div>
</div>

</div>
</form>
<form name="upload_form" action="?m=content&c=price_manage&a=import" method="post" enctype="multipart/form-data" >
	<input type="file" name="priceExcelFile" value=""  class="upload-btn" style="display:none;" />
	<input type="submit" name="doSubmit" value="提交" class="submit-btn" style="display:none;" />
</form>
<form action="?m=content&c=price_manage&a=clear" method="post" enctype="multipart/form-data" >
	<input type="submit" name="clearSubmit" value="清空" class="clear-btn" style="display:none;" />
</form>

<script type="text/javascript">
	<!--
	window.top.$('#display_center_id').css('display','none');
	function edit(id, name) {
		window.top.art.dialog({id:'edit'}).close();
		window.top.art.dialog({title:'修改信息',id:'edit',iframe:'?m=content&c=price_manage&a=edit&id='+id,width:'780',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
	}
	function data_delete(obj,id,name){
		window.top.art.dialog({content:name, fixed:true, style:'confirm', id:'data_delete'},
			function(){
				$.get('?m=content&c=price_manage&a=delete&id='+id+'&pc_hash='+pc_hash,function(data){
					if(data) {
						$(obj).parent().parent().fadeOut("slow");
					}
				})
			},
			function(){});
	};
	//-->
	$(function(){

	})
</script>
</body>
</html>
