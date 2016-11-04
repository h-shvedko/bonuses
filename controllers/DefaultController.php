<?php

class DefaultController extends DefaultControllerBase {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->Index();
    }

    public function actionConfirmemail($guid) {
        $this->Confirmemail($guid);
    }

    public function actionGuest() {
        $this->Guest();
    }
    
    public function ActivateBinar($guid) {
        $this->ActivateBinar($guid);
    }
    
    public function actionBonusesprint() {
        $this->Bonusesprint();
    }
     
    public function actionPackages() {
        $this->Packages();
    }
	
	 public function actionReferal() {
        $this->Referal();
    }

}
