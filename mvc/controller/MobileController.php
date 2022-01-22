<?php
require_once "model\MobileModel.php";

class MobileController {
   public $model;

   public function __construct() 
   {
      $this->model = new MobileModel();
   }

   public function mvcHandler() {
      //nếu trên đường dẫn URL có tham số id
      //thì thực hiện các tính năng tương ứng
      //với mobile id đấy
      if (isset($_GET['id'])) {
         $id = $_GET['id'];
         $action = $_GET['action'];
         switch ($action) {
            case 'detail':
               //lấy dữ liệu từ model
               $mobile = $this->model->showMobileDetail($id);
               //render view
               require_once "view\MobileDetail.php";
               break;
            case 'delete':
               //xóa mobile theo id
               $mobile = $this->model->deleteMobile($id);
               //render view
               require_once "view\MobileList.php";
               break;
            default:
               break;
         }
      }
      //ngược lại trên đường dẫn URL không có tham số
      //thì trả về trang MobileList (homepage)
      else {
         //lấy dữ liệu từ model
         $mobile = $this->model->showMobileList();
         //render view
         require_once "view\MobileList.php";
      }
   }
}
?>