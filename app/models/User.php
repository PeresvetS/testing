<?php
namespace App\Models;

use App\Models\Rep\SessionsRep;
use App\Models\Rep\UserRep;

/**
 * Class User
 * @package App\Models
 */
class User
{
    const USER = 0;
    const MODERATOR = 1;
    const ADMINISTRATOR = 2;
    const ROOT = 3;
    const DEVELOPER = 4;

    protected $id;
    protected $login;
    protected $email;
    protected $password;
	protected $role;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return User|null
     */
    public function getCurrent()
    {
        $userId = $this->getUserId();
        if($userId){
            return (new UserRep())->getById($userId);
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    protected function getUserId()
    {
        $sid = (new Auth())->getSessionId();
        if(!is_null($sid)){
            return (new SessionsRep())->getUidBySid($sid);
        }
        return null;
    }

    /**
     * @param string $login
     * @param string $pass
     * @param string $email
     * @return bool
     */
    public static function register(string $login, string $pass, string $email) : bool
    {
        $userRep = new UserRep();
        $user = $userRep->getByLogin($login);
        if ($user)
            return false;

        $user = $userRep->getByEmail($email);
        if ($user)
            return false;

        return $userRep->create($login, $pass, $email);
    }
}