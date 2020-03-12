<?php
namespace acmepy\base\rbac\models;

use Yii;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
	public $userdesc;
	public $asambleaEnCurso;

/*	
	private static $users = [
        'admin' => [
            'id' => 'admin',
            'username' => 'admin',
            'password' => '$2y$13$1mkvNAkZ.X0.K15.U7lrMOQMXk9o12HM/H7zNEcYObT9Zuqzo.wRa', //'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        'demo' => [
            'id' => 'demo',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
*/	
	
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id){
		return self::to_user(Users::findOne($id));
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null){
		return self::to_users(Users::find()->where(['accesstoken' => $token]));
        /*
		foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
		*/
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username){
		return self::to_user(Users::findOne(['username' => $username]));
        /*
		foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
		*/
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === $password;
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
	
	private static function to_users($us){
		$r = [];
		foreach ($us as $u){
			$t[$u->id] = self::to_user($u);
		}
		return $r;
	}
	
	private static function to_user($u){
		if (!isset($u->id)){
			return new User();
		}
		return new User([
			'id' => $u->id,
			'username' => $u->username,
			'password' => $u->password_hash,
			'authKey' => $u->auth_key,
			'accessToken' => $u->access_token,
			'userdesc' => $u->userdesc
		]);
	}
}
