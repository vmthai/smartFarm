/*=========================================================================================
    File Name: maps.js
    Description: google maps
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Gmaps Maps
// ------------------------------

var mixLocation;
var getLat = '13.751591086063396';
var getLng = '100.49265657709634'; 

    var n = parent.$("#location").val();
    n = n.split(',');
    if(n.length < 1){
        getLat = '13.751591086063396';
        getLng = '100.49265657709634';
    }else{
        if(isNaN(n[0]) && isNaN(n[1])){
            getLat = '13.751591086063396';
            getLng = '100.49265657709634';
        }else{
            if(n[0] != ''  && n[0] != undefined){
                getLat = n[0];
            }
            if(n[1] != '' && n[1] != undefined){
                getLng = n[1];
            }
        }
    }

//console.log(a+' '+getLat+','+getLng);
    
function initialize() { // ฟังก์ชันแสดงแผนที่

    GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    geocoder = new GGM.Geocoder(); // เก็บตัวแปร google.maps.Geocoder Object
    // กำหนดจุดเริ่มต้นของแผนที่
    var my_Latlng  = new GGM.LatLng(getLat,getLng);
    var my_mapTypeId=GGM.MapTypeId.HYBRID; // กำหนดรูปแบบแผนที่ที่แสดง
    var bounds = new GGM.LatLngBounds();
    var infowindow = new GGM.InfoWindow();
    var my_Point;



    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=basic-map
    var my_DivObj=$("#basic-map")[0];
    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 14, // กำหนดขนาดการ zoom
        center: my_Latlng , // กำหนดจุดกึ่งกลาง จากตัวแปร my_Latlng
        mapTypeId:my_mapTypeId, // กำหนดรูปแบบแผนที่ จากตัวแปร my_mapTypeId
        streetViewControl: false,
        fullscreenControl: true
    };
    map = new GGM.Map(my_DivObj,myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map
     
    my_Marker = new GGM.Marker({ // สร้างตัว marker ไว้ในตัวแปร my_Marker
        position: my_Latlng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
        draggable:true, // กำหนดให้สามารถลากตัว marker นี้ได้
        //title:"คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
    });
     

    getLocation(getLat,getLng);
    //console.log(getLat,getLng);    

    // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร   
    GGM.event.addListener(my_Marker, 'dragend', function() {
        my_Point = my_Marker.getPosition();  // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย     
        mixLocation = my_Point.lat()+','+my_Point.lng();
        //parent.$("#location").val(mixLocation); 
        $("#namePlace").val(''); // ลบข้อมูลการค้นหาออก       
        map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker   
        getLocation(my_Point.lat(),my_Point.lng()); 
    });     
 
    // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
    GGM.event.addListener(map, 'zoom_changed', function() {
        //parent.$("#zoom_value").val(map.getZoom());   // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value    
    });
    // ปรับ Center กรณีหน้าจอ fullscreen
    GGM.event.addListener(map,'bounds_changed', function() {
        my_Point = my_Marker.getPosition();
        map.setCenter(my_Point); // ให้แผนที่แสดงไปที่ตัว marker

    });
}



$(function(){
    // ส่วนของฟังก์ชันค้นหาชื่อสถานที่ในแผนที่
    var searchPlace=function(){ // ฟังก์ชัน สำหรับคันหาสถานที่ ชื่อ searchPlace
        var AddressSearch=$("#namePlace").val();// เอาค่าจาก textbox ที่กรอกมาไว้ในตัวแปร
        if(geocoder){ // ตรวจสอบว่าถ้ามี Geocoder Object 
            geocoder.geocode({
                 address: AddressSearch // ให้ส่งชื่อสถานที่ไปค้นหา
            },function(results, status){ // ส่งกลับการค้นหาเป็นผลลัพธ์ และสถานะ
                if(status == GGM.GeocoderStatus.OK) { // ตรวจสอบสถานะ ถ้าหากเจอ
                    my_Point=results[0].geometry.location; // เอาผลลัพธ์ของพิกัด มาเก็บไว้ที่ตัวแปร
                    my_Marker.setMap(map); // กำหนดตัว marker ให้ใช้กับแผนที่ชื่อ map                   
                    my_Marker.setPosition(my_Point); // กำหนดตำแหน่งของตัว marker เท่ากับ พิกัดผลลัพธ์
                     
 
                    mixLocation = my_Point.lat()+','+my_Point.lng();
                    //parent.$("#location").val(mixLocation);
                    map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker    
                    //map.setCenter(my_Point); // กำหนดจุดกลางของแผนที่ไปที่ พิกัดผลลัพธ์     
                    getLocation(my_Point.lat(),my_Point.lng());              
                }else{
                    // ค้นหาไม่พบแสดงข้อความแจ้ง
                    alert("Geocode was not successful for the following reason: " + status);
                    //$("#namePlace").val("");// กำหนดค่า textbox id=namePlace ให้ว่างสำหรับค้นหาใหม่
                 }
            });
        }       
    }
/*     $("#SearchPlace").click(function(){ // เมื่อคลิกที่ปุ่ม id=SearchPlace ให้ทำงานฟังก์ฃันค้นหาสถานที่
        searchPlace();  // ฟังก์ฃันค้นหาสถานที่
    });
    $("#namePlace").keyup(function(event){ // เมื่อพิมพ์คำค้นหาในกล่องค้นหา
        if(event.keyCode==13){  //  ตรวจสอบปุ่มถ้ากด ถ้าเป็นปุ่ม Enter ให้เรียกฟังก์ชันค้นหาสถานที่
            searchPlace();      // ฟังก์ฃันค้นหาสถานที่
        }       
    }); */
    $("#closeLocation").click(function(){
        parent.toggleMap('hide');
    });
    
});
$(function(){
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize  
    $("<script/>", {
      "type": "text/javascript",
      src: "//maps.google.com/maps/api/js?key=AIzaSyBDkKetQwosod2SZ7ZGCpxuJdxY3kxo5Po&v=3.2&sensor=false&language=th&callback=initialize"
    }).appendTo("body");    
});


/* function getLocation(lat,long){
    //lat = $("#lat_value").val();
    //long = $("#lon_value").val();
    var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+long+"&sensor=false";

            $.get(url).success(function(data) {
            var loc1 = data.results[0];
            var distric, locality, province;
                $.each(loc1, function(k1,v1) {
                    if (k1 == "address_components") {
                    for (var i = 0; i < v1.length; i++) {
                        for (k2 in v1[i]) {
                            if (k2 == "types") {
                                var types = v1[i][k2];
                                if (types[0] =="administrative_area_level_1") {
                                    province = v1[i].long_name;
                                    //alert ("จังหวัด : " + province);
                                } 
                                if (types[0] =="administrative_area_level_2") {
                                    distric = v1[i].long_name;
                                    //alert ("อำเภอ/เขต : " + distric);
                                } 
                                if (types[0] =="locality") {
                                    locality = v1[i].long_name;
                                    //alert ("ตำบล : " + locality);
                            } 
                            }

                        }          

                    }

                    }

                });
                tambol  = locality.split(' ');
                $("#namePlace").val(tambol[1]+" "+province);
            });
} */

