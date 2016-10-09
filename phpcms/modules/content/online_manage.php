<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class online_manage extends admin {
    private $db,$category_db;
    public $siteid;
    function __construct() {
        parent::__construct();
        $this->db = pc_base::load_model('online_model');
        $this->siteid = $this->get_siteid();
        $this->model = getcache('model','commons');
        $this->category_db = pc_base::load_model('category_model');
    }

    public function init () {
        $datas = array();
        $result_datas = $this->db->listinfo($where = '1', $order = ' id DESC', $_GET['page']);
        $pages = $this->db->pages;
        foreach($result_datas as $r) {
            $r['modelname'] = $this->model[$r['modelid']]['name'];
            $datas[] = $r;
        }
        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=content&c=type_manage&a=add\', title:\''.L('add_type').'\', width:\'780\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_type'));
        include $this->admin_tpl('online_list');
    }

    //删除数据
    public function delete() {

        $r = $this->db->delete(array('id'=>$_GET['id']));
        if($r==true){
            showmessage('删除成功', $url_forward = '?m=content&c=online_manage&a=init', '', '');
        }else{
            showmessage('删除失败', $url_forward = '?m=content&c=online_manage&a=init', '', '');
        }
        exit('1');
    }

}
?>