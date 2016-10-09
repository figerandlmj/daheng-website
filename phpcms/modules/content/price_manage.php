<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class price_manage extends admin {
    private $db,$category_db;
    public $siteid;
    function __construct() {
        parent::__construct();
        $this->db = pc_base::load_model('price_model');
        $this->siteid = $this->get_siteid();
        $this->model = getcache('model','commons');
        $this->category_db = pc_base::load_model('category_model');
    }

    public function init () {
        $datas = array();
        $result_datas = $this->db->listinfo($where = 'status = 0', $order = ' id DESC', $_GET['page']);
        $pages = $this->db->pages;
        foreach($result_datas as $r) {
            $r['modelname'] = $this->model[$r['modelid']]['name'];
            $datas[] = $r;
        }
        $big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=content&c=type_manage&a=add\', title:\''.L('add_type').'\', width:\'780\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_type'));
        $custume_menu = array('选择文件' => 'javascript:$(\'.upload-btn\').trigger(\'click\');', '导入' => 'javascript:$(\'.submit-btn\').trigger(\'click\');', '清空' => 'javascript:$(\'.clear-btn\').trigger(\'click\');');
//        $this->cache();
        include $this->admin_tpl('price_list');
    }

    //添加
    public function add() {

        if(isset($_POST['dosubmit'])) {

            $province_id = $_POST['info']['to_province_name'];
            $to_city_name = $_POST['info']['to_city_name'];

            //判断输入是否为空
            if(empty($_POST['info']['item_self_price'])||empty($_POST['info']['to_city_name'])||empty($_POST['info']['item_send_price'])||empty($_POST['info']['lowest_price'])){


                showmessage('输入不能为空', $url_forward = '?m=content&c=price_manage&a=add', '', '');

            }

            if(is_int($_POST['info']['item_self_price']) || is_float($_POST['info']['item_self_price']) || is_float($_POST['info']['item_send_price'])||is_int($_POST['info']['item_send_price'])) {

                //先判断输入的数据是否已经存在

                $r = $this->db->get_one($where = " to_province_name = '".$province_id."' AND to_city_name = '".$to_city_name."' ", $data = 'id', $order = '', $group = '');

                if(!empty($r)){
                    showmessage('数据已存在', $url_forward = '?m=content&c=price_manage&a=add', '', '');
                }else{
                    $result = $this->db->insert($_POST['info'],true);
                    if($result==true){

                        showmessage('添加成功', $url_forward = '?m=content&c=price_manage&a=init', '', '');
                    }else{

                        showmessage('添加失败', $url_forward = '?m=content&c=price_manage&a=add', '', '');
                    }
                }
            }
            else{
                showmessage('请输入数字（整数或小数）', $url_forward = '?m=content&c=price_manage&a=add', '', '');
            }



        } else {

            include $this->admin_tpl('price_add');
        }
    }

    //删除
    public function delete(){


        $id = intval($_GET['id']);

        //没有删除数据，改变状态
        $r= $this->db->update(array('status'=>1),array('id'=>$id));//设置为1不可用

        if($r==true){
            showmessage('删除成功', $url_forward = '?m=content&c=price_manage&a=init', '', '');
        }else{
            showmessage('删除失败', $url_forward = '?m=content&c=price_manage&a=init', '', '');
        }

    }
    //清空
    public function clear(){

        if( !isset($_POST['clearSubmit']) ) {
            exit;
        }
        //删除数据
        $r= $this->db->delete('1');

        if($r==true){
            showmessage('清空成功', $url_forward = '?m=content&c=price_manage&a=init', '', '');
        }else{
            showmessage('清空失败', $url_forward = '?m=content&c=price_manage&a=init', '', '');
        }


    }

    //修改
    public function edit() {
        if(isset($_POST['dosubmit'])) {

            $id = intval($_POST['id']);
            $this->db->update($_POST['info'],array('id'=>$id));

            //删除取消的
            $catids_string = $_POST['catids_string'];
            if($catids_string) {
                $catids_string = explode(',', $catids_string);
                foreach ($catids_string as $catid) {
                    $r = $this->category_db->get_one(array('catid'=>$catid),'usable_type');
                    $usable_type = array();
                    $usable_type_arr = explode(',', $r['usable_type']);

                    if(!empty($usable_type)) {
                        $usable_type = ','.implode(',', $usable_type).',';
                    } else {
                        $usable_type = '';
                    }
                    $this->category_db->update(array('usable_type'=>$usable_type),array('catid'=>$catid,'siteid'=>$this->siteid));
                }
            }
//            $this->category_cache();
//            $this->cache();//更新类别缓存，按站点
            showmessage(L('update_success'), '', '', 'edit');

        } else {
            $show_header = $show_validator = '';
            $typeid = intval($_GET['id']);
            $r = $this->db->get_one(array('id'=>$typeid));
            extract($r);

            include $this->admin_tpl('price_edit');
        }
    }


    /* 
     *  导入
     */
    public function import()
    {
        if( !isset($_POST['doSubmit']) ) {
            exit;
        }

        // 上传到uploadfile文件夹中 
        $priceExcelFile = $_FILES['priceExcelFile'];
        $uploadFile = PHPCMS_PATH . 'uploadfile'.DIRECTORY_SEPARATOR.'price_' . date('Ymd_His') . '.xls';
        // var_dump($uploadFile);
        $result = move_uploaded_file($priceExcelFile['tmp_name'], $uploadFile);
        if ( !$result ) {
            exit('上传失败');
        }


        // 插入数据库
        require_once PHPCMS_PATH . 'Classes/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($uploadFile);

        /*
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); //取得总行数
        $highestColumn = $sheet->getHighestColumn(); //取得总列
        */
        $objWorksheet = $objPHPExcel->getActiveSheet(); //取得总行数
        $highestRow = $objWorksheet->getHighestRow(); //取得总列数
        $highestColumn = $objWorksheet->getHighestColumn();
        // var_dump('highestColumn = ' . $highestColumn);
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数

        for ($row = 1;$row <= $highestRow;$row++)
        {
            $strs=array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

            }

            $array = array();
            $array['to_province_id'] = $strs[0];
            $array['to_province_name'] = $strs[1];
            $array['to_city_name'] = $strs[2];
            $array['lowest_price'] = $strs[3];
            $array['lowest_self_price'] = $strs[4];
            $array['item_self_price'] = $strs[5];
            $array['item_send_price'] = $strs[6];

            $array['created_at'] = date('Y-m-d H:i:s');
            $array['status'] = 0;

            // print_r($array); echo '<br />';

            $this->db->insert($array);

            // $insertId=  $this->db->insert_id();

        }

        showmessage('导入成功', $url_forward = '?m=content&c=price_manage&a=init', '', '');

        // var_dump($priceExcelFile);
    }

}
?>