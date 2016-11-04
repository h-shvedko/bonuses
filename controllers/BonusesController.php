<?php

class BonusesController extends BonusesControllerBase {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionInstant() {
        $this->Instant();
    }
	
	public function actionWarehouse() {
        $this->Warehouse();
    }
    
    public function actionLinear() {
        $this->Linear();
    }
    
    public function actionStair() {
        $this->Stair();
    }
    
    public function actionDirector() {
        $this->Director();
    }
    
    public function actionInfinity() {
        $this->Infinity();
    }
    
    public function actionLeader() {
        $this->Leader();
    }
    
    public function actionAuto() {
        $this->Auto();
    }
    
    public function actionHouse() {
        $this->House();
    }
    
    public function actionGifts() {
        $this->Gifts();
    }
    
    public function actionBinar() {
        $this->Binar();
    }
    
    public function actionPv() {
        $this->Pv();
    }
    
    public function actionAgv() {
        $this->Agv();
    }
    
    public function actionVpg() {
        $this->Vpg();
    }
	
	public function actionClose() {
        $this->close();
    }
	
	public function actionRollbak() {
        $this->rollbak();
    }

	public function actionbalanceRecount() {
        $this->balanceRecount();
    }

	public function actioncloseRegisterOperations() {
        $this->closeRegisterOperations();
    }
	
	public function actioncloseOperations() {
        $this->closeOperations();
    }
	
	public function actioncloseAllOperations() {
        $this->closeAllOperations();
    }
	
	public function actionrecountBO() {
        $this->recountBO();
    }

}
