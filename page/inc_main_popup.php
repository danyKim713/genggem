<?
$query = "select * from tbl_popup where use_yn = 'Y' and open_from <= '".date("Y-m-d")."' and open_to >= '".date("Y-m-d")."' order by regdate DESC LIMIT 0,1";

$rowPopup = db_select($query);
if($rowPopup['popup_id'] && $_COOKIE['ck_today_'.$rowPopup[popup_id]]!="Y"){
?>
  <script>
    function do_not_open_today(popup_id) {
      setCookie('ck_today_' + popup_id, "Y", 1);
      hideModal();
    }
    $(function() {
      $("#popupClick").click();
    });

  </script>
  <a href="javascript:void(0)" id="popupClick" title="<?=$dic['main_popup']?>" class="invisible" data-id="md-mainNotice" data-toggle="biko-modal"></a>
  <!--메인팝업-->
  <div class="remodal " id="md-mainNotice">
    <div class="remodal-contents" style="background:#fff">
      <div class="remodal-txt text-left">
        <?=$rowPopup['content']?>
      </div>
    </div>
    <div class="remodal-footer align-items-center">
      <div class="checkbox check-primary col-8 text-left">
        <input type="checkbox" name="alert1" class="invisible" id="alert1" onChange="do_not_open_today('<?=$rowPopup['popup_id']?>');">
        <label for="alert1" class="fs---1 fw-300 color-5"><span class="icon ic-verified mr-2 fs-0 v-align-sub"></span>오늘 다시 보지 않기</label>
      </div>
      <button class="col-4 btn fw-600 text-right pr-3" onclick="hideModal()">닫기</button>
    </div>
  </div>
  <!--//메인팝업-->
  <?}?>