<?php
/**
 * User model
 *
 * @since: 0.1
 */

class User extends CActiveRecord
{
    public $username;
    public $email;
    public $password;
    public $password_confirmation;

    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    /**
     * @static
     * @param string $className
     * @return User
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
            array('username, password', 'required'),
            array('username, email','unique','on'=>'register'),
            array('email','email','on'=>'register'),
            array('email, password_confirmation', 'required', 'on'=>'register'),
            array('password', 'compare', 'compareAttribute'=>'password_confirmation', 'on'=>'register'),
            array('password_confirmation', 'compare', 'compareAttribute'=>'password', 'on'=>'register'),
            array('username, password', 'length', 'max' => 20),
        );
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {
        return crypt($password,$this->password)===$this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public function hashPassword($password)
    {
        return crypt($password, $this->generateSalt());
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     *
     * The {@link http://php.net/manual/en/function.crypt.php PHP `crypt()` built-in function}
     * requires, for the Blowfish hash algorithm, a salt string in a specific format:
     *  - "$2a$"
     *  - a two digit cost parameter
     *  - "$"
     *  - 22 characters from the alphabet "./0-9A-Za-z".
     *
     * @param int cost parameter for Blowfish hash algorithm
     * @return string the salt
     */
    protected function generateSalt($cost=10)
    {
        if(!is_numeric($cost)||$cost<4||$cost>31){
            throw new CException(Yii::t('Cost parameter must be between 4 and 31.'));
        }
        // Get some pseudo-random data from mt_rand().
        $rand='';
        for($i=0;$i<8;++$i)
            $rand.=pack('S',mt_rand(0,0xffff));
        // Add the microtime for a little more entropy.
        $rand.=microtime();
        // Mix the bits cryptographically.
        $rand=sha1($rand,true);
        // Form the prefix that specifies hash algorithm type and cost parameter.
        $salt='$2a$'.str_pad((int)$cost,2,'0',STR_PAD_RIGHT).'$';
        // Append the random salt string in the required base64 format.
        $salt.=strtr(substr(base64_encode($rand),0,22),array('+'=>'.'));
        return $salt;
    }
    /**
     * Exclude password confirmation from being saved
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        unset($array['password_confirmation']);
        return $array;
    }
    /**
     * Hash password before saving it
     * @return bool
     */
    public function beforeSave()
    {
        if($this->getIsNewRecord()==true)$this->password = $this->hashPassword($this->password);
        return parent::beforeSave();
    }
}
