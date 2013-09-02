<?php
class DaysController extends RestController
{
    public function actionList(){
        if($days = Day::model()->findAll('LOWER(user_id)=? AND date >= ? AND date <= ?',array(Yii::app()->user->id, $_GET['from'],$_GET['to']))){
            $this->_sendResponse(200, $days);
        } else {
            $this->_sendResponse(404);
        }
    }
    public function actionCreate(){
        $POST = $this->_getInputData();
        $day = new Day();
        $day->attributes = $POST;
        $day->user_id = Yii::app()->user->id;
        if($day->save()){
            $this->_sendResponse(200, $day);
        } else {
            $this->_sendResponse(500);
        }
    }
    public function actionDelete(){
        if($day = Day::model()->findByPk(@$_GET['id'])){
            if($day->user_id == Yii::app()->user->id){
                if($day->delete()){
                    $this->_sendResponse(204);
                } else {
                    $this->_sendResponse(500);
                }
            } else {
                $this->_sendResponse(403);
            }
        } else {
            $this->_sendResponse(404);
        }
    }
    public function actionUpdate(){
        $PUT = $this->_getInputData();
        if($day = Day::model()->findByPk(@$_GET['id'])){
            if($day->user_id == Yii::app()->user->id){
                $day->attributes = $PUT;
                if($day->save()){
                    $this->_sendResponse(200,$day);
                } else {
                    $this->_sendResponse(500);
                }
            } else {
                $this->_sendResponse(403);
            }
        } else {
            $this->_sendResponse(404);
        }
    }
    public function actionView(){
        if($day = Day::model()->findByPk(@$_GET['id'])){
            if($day->user_id == Yii::app()->user->id){
                $this->_sendResponse(200,$day);
            } else {
                $this->_sendResponse(403);
            }
        } else {
            $this->_sendResponse(404);
        }
    }
}