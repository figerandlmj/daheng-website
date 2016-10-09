<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
    <!--
    $(function () {
        $.formValidator.initConfig({
            formid: "myform", autotip: true, onerror: function (msg, obj) {
                window.top.art.dialog({content: msg, lock: true, width: '200', height: '50'}, function () {
                    this.close();
                    $(obj).focus();
                })
            }
        });
        $("#name").formValidator({
            onshow: "<?php echo L('type_name_tips')?>",
            onfocus: "<?php echo L("input").L('type_name')?>",
            oncorrect: "<?php echo L('input_right');?>"
        }).inputValidator({min: 1, onerror: "<?php echo L("input").L('type_name')?>"});
    })
    //-->
</script>
<form action="?m=content&c=price_manage&a=add" method="post" id="myform">
    <div style="padding:6px 3px">
        <div class="col-2 col-left mr6" style="width:100%">
            <h6><img src="<?php echo IMG_PATH; ?>icon/sitemap-application-blue.png" width="16" height="16"/>添加信息</h6>
            <table width="100%" class="table_form">
                <tr>
                    <th>目的省：</th>
                    <td class="y-bg">
                        <select name="info[to_province_name]" class="Provinceselect"  style="width:300px;">
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>目的城市(市、县、区)：</th>
                    <td class="y-bg">
                        <input name="info[to_city_name]"  style="width:300px;">
                    </td>
                </tr>
                <tr>
                    <th>自提单价：</th>
                    <td class="y-bg">
                        <input name="info[item_self_price]" style="width:300px;">
                    </td>
                </tr>
                <tr>
                    <th>派送单价：</th>
                    <td class="y-bg">
                        <input name="info[item_send_price]" style="width:300px;">(注释：派送单价为当前价格+自提单价)
                    </td>
                </tr>
                <tr>
                    <th>最低派送单价：</th>
                    <td class="y-bg">
                        <input name="info[lowest_price]"  style="width:300px;">
                    </td>

                </tr>
            </table>

            <div class="bk15"></div>
            <input type="submit"  style="margin-left:400px;" id="dosubmit" name="dosubmit" value="添加"/>

        </div>
    </div>
</form>
</body>
<script>

    //加载城市
    $.ajax({
        type: "GET",
        url: '?m=content&c=index&a=getprovince',
        dataType: "json",
        success:function(data){
            var length=data.length;
            for(var i=0;i<length;i++){
                var html = "<option id='province_id" + data[i].to_province_id + "'value='" + data[i].to_province_name + "' >" + data[i].to_province_name + "</option>";
                $(".Provinceselect").append(html);
            }
        },
        error: function(err) {
            alert('Ajax error!');
        }
    });

</script>
</html>