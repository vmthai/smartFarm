<?php
require_once _DIR_HOST_.'/models/ActionButtonService.php';

class ViewHelper {
    private $data=array();

    /*
    * @param  string $key, string $value
    * @return array $this->data
    */
    public function assign($key,$value){
        $this->data[$key]=$value;
    }

    /*
    * @param  string $htmlPage
    * @return display output
    */
    public function display($htmlPage){
        /*START ดึง Action Button*/
        $acButton = new ActionButtonService();
    	$_assign['action_bt'] = $acButton->getActionButton();
        /*END ดึง Action Button*/
    	$this->data = array_merge($this->data, $_assign);
        extract($this->data);
        include_once _DIR_HOST_.'/views/'.$htmlPage;
    }
}
?>
