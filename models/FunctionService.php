<?php
require_once  _DIR_HOST_.'/assets/plugins/phpmailer/PHPMailerAutoload.php';

class FunctionService {
    /*
    * @param  string $date_start,$date_end
    * @return int
    */
    public function day_diff($date_start,$date_end){
        $date1=date_create($date_start);
        $date2=date_create($date_end);
        $diff=date_diff($date1,$date2);
        return $diff->format("%d");
    }

    /** 
     * recursively create a long directory path
     */
    public function createPath($path) {
        if (is_dir($path)) return true;
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
        $return = $this->createPath($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path, 0755) : false;
    }
    
    function fcThumbnailUpload($file_name = '',$file_tmp_name = '', $target_folder = '', $thumb = FALSE, $thumb_width = '', $thumb_height = ''){

        //folder path setup
        $target_path = _DIR_HOST_."/".$target_folder;
        $thumb_path = _DIR_HOST_."/".$target_folder."/thumb/";
        $checkPathTarget = $this->createPath($target_path);
        $checkPathThumb = $this->createPath($thumb_path);
        if(empty($checkPathTarget) || empty($checkPathThumb)){
            return false;
        }
        
        //file name setup
        $filename_err = explode(".",$file_name);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count-1];
        $fileName = round(microtime(true)). '.'.$file_ext;
        
        //upload image path
        $upload_image = $target_path.basename($fileName);
        
        //upload image
        if(move_uploaded_file($file_tmp_name,$upload_image))
        {
            //thumbnail creation
            if($thumb == TRUE)
            {
                $thumbnail = $thumb_path.$fileName;
                list($width,$height) = getimagesize($upload_image);
                $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
                switch($file_ext){
                    case 'jpg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($upload_image);
                        break;

                    case 'png':
                        $source = imagecreatefrompng($upload_image);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($upload_image);
                        break;
                    default:
                        $source = imagecreatefromjpeg($upload_image);
                }

                imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
                switch($file_ext){
                    case 'jpg' || 'jpeg':
                        imagejpeg($thumb_create,$thumbnail,100);
                        break;
                    case 'png':
                        imagepng($thumb_create,$thumbnail,100);
                        break;

                    case 'gif':
                        imagegif($thumb_create,$thumbnail,100);
                        break;
                    default:
                        imagejpeg($thumb_create,$thumbnail,100);
                }

            }

            return basename($fileName);
        }
        else
        {
            return false;
        }
    }
    
    public function fncUploadImg($file,$folder_path) {
        
        $target_dir = _DIR_HOST_."/".$folder_path;
        $checkPath = $this->createPath($target_dir);
        if(empty($checkPath)){
            $return = ['result'=>'false'];
            return $return;
        }
        $temp = explode(".", $file["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir.$newfilename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $message ="Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($file["size"] > 500000) {
            $message ="Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $message ="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk > 0) {

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $return = ['result'=>'true','name'=>$folder_path.$newfilename];
            } else{
                $return = ['result'=>'false','message'=>$message];
            }
        } else {
            $return = ['result'=>'false','message'=>$message];
        }


        return $return;
    }
    public function fncUploadImgAddrow($name,$tmp_name,$size,$folder_path) {

        $newfilename = $this->fcThumbnailUpload($name, $tmp_name, $folder_path, TRUE,'230', '150');
        if($newfilename<>false){
            return ['result'=>'true','name'=>$folder_path.$newfilename,'thumb'=>$folder_path.'thumb/'.$newfilename];  
      } else {
            return ['result'=>'false'];
      }
        
    }
    public function fncUploadFile($name,$tmp_name,$folder_path) {

        $target_dir = _DIR_HOST_."/".$folder_path;
        $checkPath = $this->createPath($target_dir);
        if(empty($checkPath)){
            $return = ['result'=>'false'];
            return $return;
        }
        $temp = explode(".", $name);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_file = $target_dir.$newfilename;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $return = ['result'=>'true','name'=>$folder_path.$newfilename];
        } else{
            $return = ['result'=>'false'];
        }

        return $return;
    }
     public function fncUploadFileAddKey($txt,$name,$tmp_name,$folder_path) {
        $target_dir = _DIR_HOST_."/".$folder_path;
        $checkPath = $this->createPath($target_dir);
        if(empty($checkPath)){
            $return = ['result'=>'false'];
            return $return;
        }
        $temp = explode(".", $name);
        $newfilename = round(microtime(true)).'_'.$txt. '.' . end($temp);
        $target_file = $target_dir.$newfilename;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $return = ['result'=>'true','name'=>$folder_path.$newfilename];
        } else{
            $return = ['result'=>'false'];
        }

        return $return;
    }

    public function fncSendMail($data) {

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->CharSet="UTF-8";
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or พอร์ต 465 (ต้องใช้ SSL) or พอร์ต 587 (ต้องใช้ TLS)
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "bsiamtech.edu@gmail.com";//bsiamtech.edu@gmail.com //patch2527@gmail.com
        $mail->Password = "edu@bsiam";//au262527
        $mail->SetFrom("bsiamtech.edu@gmail.com","EDU Content");
        $mail->addAddress($data["email"],$data["name"]);
        $mail->Subject = $data["subject"];
        //$mail->Body = "hello";
        $mail->msgHTML($data["message"]);

        if(!$mail->send()) {
            $return = false;
        } else {
           $return = true;
        }

        return $return;
    }

    public function randomPassword($len) {
      srand((double)microtime()*10000000);
      $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      $ret_str = "";
      $num = strlen($chars);
      for($i = 0; $i < $len; $i++)
      {
        $ret_str.= $chars[rand()%$num];
        $ret_str.="";
      }
      return $ret_str;
    }

    public function autoFormatCardID($data){
        $id_card = $data;
        if(is_numeric($id_card) && strlen($id_card) == 13){
            $format_idcard = "_ ____ _____ __ _";
            $pattern_ex = " ";
            $len_format = strlen($format_idcard);
            $id_new = '';
            $inum = 0;
            for($i=0;$i<$len_format;$i++){
                if(substr($format_idcard,$i,1) == $pattern_ex){
                    $id_new .= $pattern_ex;
                } else {
                    $id_new .= substr($id_card,$inum,1);
                    $inum++;
                }
            }
            $id_card = $id_new;
        }
        return $id_card;
    }

    public function autoFormatAccountCode($data){
        if(isset($data) && strlen($data) > 0){
            $format = "___ __";
            $pattern_ex = " ";
            $len_format = strlen($format);
            $data_new = '';
            $inum = 0;
            for($i=0;$i<$len_format;$i++){
                if(substr($format,$i,1) == $pattern_ex){
                    $data_new .= $pattern_ex;
                } else {
                    $substr_data = substr($data,$inum,1);
                    if($substr_data == ''){
                        break;
                    } else {
                        $data_new .= $substr_data;
                        $inum++;
                    }
                }
            }
            $data_remain = substr($data,$inum);
            if($data_remain != ''){
                $data_new .= $pattern_ex.$data_remain;
            }
            $data = $data_new;
        }
        return $data;
    }

    public function autoFormatFinanceCode($data){
        if(isset($data) && strlen($data) > 0){
            $format = "___ __ __";
            $pattern_ex = " ";
            $len_format = strlen($format);
            $data_new = '';
            $inum = 0;
            for($i=0;$i<$len_format;$i++){
                if(substr($format,$i,1) == $pattern_ex){
                    $data_new .= $pattern_ex;
                } else {
                    $substr_data = substr($data,$inum,1);
                    if($substr_data == ''){
                        break;
                    } else {
                        $data_new .= $substr_data;
                        $inum++;
                    }
                }
            }
            $data_remain = substr($data,$inum);
            if($data_remain != ''){
                $data_new .= $pattern_ex.$data_remain;
            }
            $data = $data_new;
        }
        return $data;
    }

    public function autoFormatTranNo($data){
        if(isset($data) && strlen($data) > 0){
            $format = "____ ___ ___ ___";
            $pattern_ex = " ";
            $len_format = strlen($format);
            $data_new = '';
            $inum = 0;
            for($i=0;$i<$len_format;$i++){
                if(substr($format,$i,1) == $pattern_ex){
                    $data_new .= $pattern_ex;
                } else {
                    $substr_data = substr($data,$inum,1);
                    if($substr_data == ''){
                        break;
                    } else {
                        $data_new .= $substr_data;
                        $inum++;
                    }
                }
            }
            $data_remain = substr($data,$inum);
            if($data_remain != ''){
                $data_new .= $pattern_ex.$data_remain;
            }
            $data = $data_new;
        }
        return $data;
    }

    /** 
     * แปลง ไร่ งาน ตารางวา
     */
    public function fncRaiNgan($rai,$ngan,$square) {
        $v_rai = intval($rai)*400;//1 ไร่ = 400 ตารางวา
        $v_ngan = intval($ngan)*100;//1 งาน = 100 ตารางวา
        $v_square = intval($square);
        $p_square = $v_rai+$v_ngan+$v_square;
        /*หาจำนวนไร่*/
        $r_rai = floor($p_square/400);
        $pp_remain = $p_square-($r_rai*400);
        $r_ngan = floor($pp_remain/100);
        $r_square = $pp_remain-($r_ngan*100);
        return ['rai'=>$r_rai,'ngan'=>$r_ngan,'square'=>$r_square];
    }

}
?>
