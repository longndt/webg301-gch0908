<?php 
require_once "Mobile.php";

class MobileModel {
   public $mobileList;

   public function __construct()
   {  
      $this->mobileList = array(
         new Mobile("iPhone 13 Pro Max","Apple",1000, "Black",
         "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbcjCsHB0IXShv2UrzlBJRA5w1kOfgjRtxwg&usqp=CAU"),
         new Mobile("Galaxy S21 Ultra", "Samsung", 1200, "White",
         "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMxI38nLe_qQaFNCvmxG0UJ54upFJHoZ5R-g&usqp=CAU"),
         new Mobile("Galaxy Note 20", "Samsung", 1300, "Blue",
         "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTemIfEgVxPGVGd6JQGfRrLtD1Q15EjK3sxTQ&usqp=CAU")
      );
   }

   public function showMobileList() {
      return $this->mobileList;
   }

   public function showMobileDetail($id) {
      return $this->mobileList[$id];
   }

   public function deleteMobile($id) {
      //xóa phần tử trong array và re-index lại array
      array_splice($this->mobileList,$id,1); 
      //trả lại array cập nhật (sau khi xóa)
      return $this->mobileList;
   }
}
?>