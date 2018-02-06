<?php
require_once _DIR_HOST_.'/models/Services/Peoples.php';
require_once _DIR_HOST_.'/models/Services/FarmerGroups.php';
require_once _DIR_HOST_.'/views/ViewHelper.php';
require_once _DIR_HOST_.'/models/FunctionService.php';

class AutocompleteController {

    
    public function handleRequest($op) {

        try {
            if ( !$op || $op == 'people' ) {
                $this->people();
            } else if ($op == 'farmerGroup' ) {
                $this->$op();

            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function showError($title, $message) {
        include 'views/error.php';
    }

    /*
    * @param  array $this->params
    * @return display
    */
    private function people(){
        $query = (isset($_GET['query']))?$_GET['query']:'';
        $peoples = new PeoplesService();
        $data =  $peoples->autocomplete($query);
        if(!empty($data)){
            $funService =  new FunctionService();
            foreach($data as $key=>$item){
                $format_cardid = $funService->autoFormatCardID($item->id_card);
                $data[$key]->cardid_show = $format_cardid;
                $data[$key]->name = str_replace($item->id_card, $format_cardid, $item->name);
            }
        }
        echo json_encode($data);
    }

    private function farmerGroup(){
        $query = (isset($_GET['query']))?$_GET['query']:'';
        $peoples = new FarmerGroupService();
        $data =  $peoples->autocomplete($query);
        echo json_encode($data);
    }

}
?>
