<?php
namespace App\Core;

use App\Model\UserManager;

class User_role
{
    private $user_id;
    private $role;
    private $role_value;

    /**
     * dispatch method from user_role in session
     * @return bool|int
     */
    public function dispatch() {

        if(isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 1) {
                return $this->role_value = 1;
            } elseif($_SESSION['role'] === 0) {
                return $this->role_value = 0;
            }
        }
        else{
            return $this->role_value = 2;
        }
    }
}