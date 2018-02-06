function fncLogout() {
     $.ajax({
        url: WEB_HTTP_HOST+'/home/home/logout',
        type: 'GET',
        success: function(result) {
            window.location.href = WEB_HTTP_HOST;
        },
        error : function(result){
                $('#md-error p' ).text('!!!Server Error');
                $('#md-error').modal('show');
        }
    });
}

function fncLoadHome() {
    var val_RollID = "<?=getRollUserID();?>";
    if(val_RollID=='1'){
        fncLoadContent('admin/home/index');
    } else {
        fncLoadContent('dashboard/home/view');
    }
    
}
function fncLoadContent(url) {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').removeClass('in');
    if(url==''){
        $('#md-error p' ).text('ไม่มีลิงค์นี้');
        $('#md-error').modal('show');  

    } else {
        if(url.indexOf("?")>= 0){
            urlSend = WEB_HTTP_HOST+'/'+url+'&keep=1';
        } else {
            urlSend = WEB_HTTP_HOST+'/'+url+'?keep=1';
        }
        $("#main-content").load(urlSend, function(responseTxt, statusTxt, xhr){
            if(responseTxt == 'logout'){
                fncLogout();
                return false;
            } 
            // else {
            //    $("#content-breadcrumbs").load(WEB_HTTP_HOST+'/breadcrumbs/home/index?id='+url);
            // }
            if ( statusTxt == "error" ) {
                var msg = "Sorry but there was an error: ";
                $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                return false;
            }
         });
    }
}

function fncLoadContentHaveData(url,data) {
    urlSend = WEB_HTTP_HOST+'/'+url;
    $('body').removeClass('modal-open');
    $('.modal-backdrop').removeClass('in');
    $("#main-content").load(urlSend,data, function(responseTxt, statusTxt, xhr){

        if(responseTxt == 'logout'){
            fncLogout();
            return false;
        }
        if ( statusTxt == "error" ) {
            var msg = "Sorry but there was an error: ";
            $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
            return false;
        }
     });
}

function fncOpenNewWindow(url) {
    urlSend = WEB_HTTP_HOST+'/'+url;

    window.open(urlSend);
}

function printPDF(htmlPage)
{
    var w = window.open(htmlPage);
    if (navigator.appName == 'Microsoft Internet Explorer') window.print();
    else w.print();
}
function ajaxRequest (urlSubmit, data, type) {
    urlSend = WEB_HTTP_HOST+'/'+urlSubmit;
    return $.ajax({
        url: urlSend,
        type: type,
        data: data,
        success: function(result) {
            if(result.result=='false'){
                $('#md-error p' ).text(result.message);
                $('#md-error').modal('show');  
            }
            return result;
        },
        error : function(result){
                $('#md-error p' ).text('!!!Server Error');
                $('#md-error').modal('show');
        }
    });
}

function ajaxUpfile (urlSubmit, data, type) {
    urlSend = WEB_HTTP_HOST+'/'+urlSubmit;
    return   $.ajax({
                    url: urlSend, // point to server-side PHP script 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,                         
                    type: type,
                    success: function(result) {
                        if(result.result=='false'){
                            $('#md-error p' ).text(result.message);
                            $('#md-error').modal('show');  
                        }
                        return result;
                    },
                    error : function(result){
                            $('#md-error p' ).text('!!!Server Error');
                            $('#md-error').modal('show');
                    }
             });
}

function fncClickDeltete(id,number){
    $('#md-confirm-delete').modal('show');
    $('#span-number').text(number);
    $('#frm-confirm-delete input[name=id]').val(id);
}
function fncConfirmDelete(data,url,urlRefresh) {
    $('#md-confirm-delete').modal('hide');
    urlSend = WEB_HTTP_HOST+'/'+url;
    $.ajax({
        url: urlSend,
        type: 'POST',
        data: data,
        success: function(result) {
            obj = JSON.parse(result);
            $('#md-error p' ).text(obj.message);
            $('#md-error').modal('show');
            if(obj.result=='true') {
                $('#md-error').on('hidden.bs.modal', function (e) {
                    fncLoadContent(urlRefresh);
                    $('#md-error').off('hidden.bs.modal');
                }); 
            }
        },
        error : function(result){
             $('#md-error p' ).text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
             $('#md-error').modal('show');
        }
    });
}

function fncConfirmSave(bt,data,url,urlRefresh) {

    urlSend = WEB_HTTP_HOST+'/'+url;
    $.ajax({
        url: urlSend,
        type: 'POST',
        data: data,
        success: function(result) {
              obj = JSON.parse(result);  
                $('#md-error p' ).text(obj.message);
                $('#md-error').modal('show');         
                if(obj.result=='true') {
                    $('#md-error').on('hidden.bs.modal', function (e) {
                        fncLoadContent(urlRefresh);
                        $('#md-error').off('hidden.bs.modal');
                    });
                }
                $('#btn-save').removeClass('disabled');
                bt.data('requestRunning', false);
        },
        error : function(result){
             $('#md-error p' ).text('ไม่สามารถทำรายการได้กรุณาลองใหม่อีกครั้ง');
             $('#md-error').modal('show');
             bt.data('requestRunning', false);
        }
    });
}

function fncConfirmSaveFile(bt,data,url,urlRefresh) {
    urlSend = WEB_HTTP_HOST+'/'+url;
    $.ajax({
        url: urlSend, // point to server-side PHP script 
        cache: false,
        contentType: false,
        processData: false,
        data: data,                         
        type: 'POST',
        success: function(result) {
            obj = JSON.parse(result); 
            $('#md-error p' ).text(obj.message);
            $('#md-error').modal('show');      
            if(obj.result=='true') {
                $('#md-error').on('hidden.bs.modal', function (e) {
                    fncLoadContent(urlRefresh);
                    $('#md-error').off('hidden.bs.modal');
                });
            }
            $('#btn-save').removeClass('disabled');
            bt.data('requestRunning', false);
        },
        error : function(result){
                $('#md-error p' ).text('!!!Server Error');
                $('#md-error').modal('show');
        }
     });
}

function getAmphurJson(attramphur,attrdistrict,val){
      $.getJSON(WEB_HTTP_HOST+"/address/data/amphur?id="+val, function(jsonData){
          select = '<option value="">--กรุณาเลือก--</option>';
          $.each(jsonData, function(id,name)
          {
              select +='<option value="'+id+'">'+name+'</option>';
          });
          select += '</select>';
          /*--Set Aumphoe--*/
          attramphur.html(select);
          /*--Set District--*/
          getDistrictJson(attrdistrict,attramphur.val());  
    });
    
  }
  
  function getDistrictJson(attrdistrict,val){
      $.getJSON(WEB_HTTP_HOST+"/address/data/district?id="+val, function(jsonData){
          select = '<option value="">--กรุณาเลือก--</option>';
            $.each(jsonData, function(id,name)
            {
                 select +='<option value="'+id+'">'+name+'</option>';
             });
          select += '</select>';
          /*--Set District--*/
          attrdistrict.html(select);

      });
    
  }
  function getZipCodeJson(attrzipcode,val){
      $.getJSON(WEB_HTTP_HOST+"/address/data/zipcode?id="+val, function(jsonData){
          select = '<option value="">--กรุณาเลือก--</option>';
            $.each(jsonData, function(id,name)
            {
                 select +='<option value="'+id+'">'+name+'</option>';
             });
          select += '</select>';
          attrzipcode.html(select);
      });
    
  }

function checkTrimData(obj){
    var data = $.trim($(obj).val());
    $(obj).val(data);
}

function autoFormatCardID(obj){    
    var pattern=new String("_ ____ _____ __ _"); // กำหนดรูปแบบในนี้
    var pattern_ex=new String(" "); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
    var returnText=new String("");
    var obj_l=obj.value.length;
    var obj_l2=obj_l-1;
    for(i=0;i<pattern.length;i++){           
        if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
            returnText+=obj.value+pattern_ex;
            obj.value=returnText;
        }
    }
    if(obj_l>=pattern.length){
        obj.value=obj.value.substr(0,pattern.length);           
    }
}

function checkFormatCardID(obj){
    var idcard = $.trim($(obj).val());
    idcard = idcard.replace( / /g, '' );
    if(!$.isNumeric(idcard) || idcard.length!=13){
        $(obj).val('');
    }
}
$(document).on('keyup', '.format-idcard', function() {
    autoFormatCardID(this);
});
$(document).on('blur', '.format-idcard', function() {
    checkFormatCardID(this);
});

function autoFormatAccountNumber(obj){    
    var pattern=new String("___ _ _____ _"); // กำหนดรูปแบบในนี้
    var pattern_ex=new String(" "); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
    var returnText=new String("");
    var obj_l=obj.value.length;
    var obj_l2=obj_l-1;
    for(i=0;i<pattern.length;i++){           
        if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
            returnText+=obj.value+pattern_ex;
            obj.value=returnText;
        }
    }
    if(obj_l>=pattern.length){
        obj.value=obj.value.substr(0,pattern.length);           
    }
}

function checkFormatAccountNumber(obj){
    var idcard = $.trim($(obj).val());
    idcard = idcard.replace( / /g, '' );
    if(!$.isNumeric(idcard) || idcard.length!=10){
        $(obj).val('');
    }
}
$(document).on('keyup', '.format-account-number', function() {
    autoFormatAccountNumber(this);
});
$(document).on('blur', '.format-account-number', function() {
    checkFormatAccountNumber(this);
});

function fncViewManual(val){
    urlSend = WEB_HTTP_HOST+'/load/manual/index?id='+val;
    $("#div-md-manual").load(urlSend, function(responseTxt, statusTxt, xhr){
        if ( statusTxt == "error" ) {
            var msg = "Sorry but there was an error: ";
            $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
            return false;
        } else {
            $('#md-manual').modal('show');
        }
        
     });
}

function fncLoadPageTodiv(div_id,url) {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').removeClass('in');
    if(url==''){
        $('#md-error p' ).text('ไม่มีลิงค์นี้');
        $('#md-error').modal('show');  

    } else {
        urlSend = WEB_HTTP_HOST+'/'+url;
        $(div_id).load(urlSend, function(responseTxt, statusTxt, xhr){
            if(responseTxt == 'logout'){
                fncLogout();
                return false;
            } 
            // else {
            //    $("#content-breadcrumbs").load(WEB_HTTP_HOST+'/breadcrumbs/home/index?id='+url);
            // }
            if ( statusTxt == "error" ) {
                var msg = "Sorry but there was an error: ";
                $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                return false;
            }
         });
    }
}