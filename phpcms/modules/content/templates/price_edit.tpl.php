<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<script type="text/javascript">
    <!--
    $(function(){
        $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
        $("#name").formValidator({onshow:"<?php echo L('type_name_tips')?>",onfocus:"<?php echo L("input").L('type_name')?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L("input").L('type_name')?>"});
    })
    //-->
</script>
<form action="?m=content&c=price_manage&a=edit" method="post" id="myform">
    <div style="padding:6px 3px">
        <div class="col-2 col-left mr6" style="width:440px">
            <h6><img src="<?php echo IMG_PATH;?>icon/sitemap-application-blue.png" width="16" height="16" /> <?php echo L('edit_type');?></h6>
            <table width="100%"  class="table_form">
                <tr>
                    <th>自提单价：</th>
                    <td class="y-bg"><input name="info[item_self_price]"style="width:300px;" value="<?php echo $item_self_price;?>"></td>
                </tr>
                <tr>
                    <th>派送单价：</th>
                    <td class="y-bg"><input name="info[item_send_price]"style="width:300px;" value="<?php echo $item_send_price;?>"></td>
                </tr>
                <tr>
                    <th>最低派送价格：</th>
                    <td class="y-bg"><input name="info[lowest_price]"style="width:300px;" value="<?php echo $lowest_price;?>"></td>
                </tr>
            </table>

            <div class="bk15"></div>
            <input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit');?>" />

        </div>
    </div>
    <input type="hidden"  name="id" value="<?php echo $id;?>">
    <input type="hidden" name="catids_string" value="<?php echo $catids_string;?>">
</form>
</body>
</html>