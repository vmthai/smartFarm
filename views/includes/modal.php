<!-- Modal -->
<div id="md-error" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ALERT !</h4>
          </div>
          <div class="modal-body">
              <p></p>

          </div>
          <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<div id="md-confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยัน</h4>
          </div>
          <div class="modal-body">
              <p>กรุณาตรวจสอบข้อมูล หากยืนยันการบันทึกข้อมูล กด "ตกลง"?</p>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" id="btn-confirm-save">ตกลง</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>

<div id="md-confirm-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">ยืนยันการลบข้อมูล!</h4>
          </div>
          <div class="modal-body">
              <p>ท่านต้องการทำการลบข้อมูลรายการที่ <span id="span-number"></span> นี้ใช่หรือไม่?</p>
              <form class="form-horizontal" id="frm-confirm-delete">
                <input type="hidden" name="id">
              </form>
          </div>
          <div class="modal-footer">
              <button class="btn btn-success" type="button" id="btn-confirm-delete">ลบรายการ</button>
              <button data-dismiss="modal" class="btn btn-default" type="button">ปิด</button>
          </div>
      </div>
  </div>
</div>