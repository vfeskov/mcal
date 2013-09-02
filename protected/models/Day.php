<?php
class Day extends CActiveRecord
{
    public $date;
    public $user_id;
    public $flagO;
    public $flagZ;
    public $flagX;
    public $flagOX;
    /**
     * @static
     * @param string $className
     * @return Day
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * Validation rules for the model
     *
     * @return array
     */
    public function rules()
    {
        return array(
            array('date, user_id', 'required'),
            array('user_id','unsafe'),
            array('date', 'date', 'format'=>'yyyy-MM-dd'),
            array('flagO, flagZ, flagX, flagOX', 'boolean')
        );
    }
}