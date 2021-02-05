<?php
namespace App\Core;

use App\Model\UserManager;

class User_role
{
    private $user_id;
    private $role;
    private $role_value;

    /**
     * get user_role from session
     */
    public function get_role()
    {
//        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->user_role = $_SESSION['role'];
            return $user = [
                'user_id' =>  $this->user_id,
                'role' => $this->role,
            ];
//        }
//        else{
//            $this->user_id = NULL;
//            $this->user_role = NULL;
//            return $user = [
//                'user_id' =>  $this->user_id,
//                'user_role' => $this->role,
//            ];
//        }

    }

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