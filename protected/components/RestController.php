<?php
abstract class RestController extends CController
{
    protected  $format = 'json';

    protected $sessionRequired = true;
    protected $session;
    protected function beforeAction($action)
    {
        if(Yii::app()->user->isGuest){
            $this->_sendResponse(401);
        }
        return true;
    }
    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            '401.1'=>'Username and password don\'t match',
            '401.6' =>'Username is not registered',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    protected function _sendResponse($status = 200, $body = '', $content_type = 'application/json')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        echo CJSON::encode($body);

        Yii::app()->end();
    }
    protected function _getInputData()
    {
        $json = file_get_contents('php://input');
        return CJSON::decode($json,true);
    }
    public abstract function actionList();
	public abstract function actionView();
	public abstract function actionUpdate();
	public abstract function actionDelete();
	public abstract function actionCreate();
}