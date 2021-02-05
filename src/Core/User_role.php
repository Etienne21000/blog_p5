<?php
namespace App\Core;

use App\Model\UserManager;

class User_role
{

    private $user_id;
    private $role;

    /**
     * get user_role from session
     */
    public function get_role()
    {
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->user_role = $_SESSION['role'];
            return $user = [
                'user_id' =>  $this->user_id,
                'user_role' => $this->role,
            ];
        }
        else{
            $this->user_id = NULL;
            $this->user_role = NULL;
            return $user = [
                'user_id' =>  $this->user_id,
                'user_role' => $this->role,
            ];
        }

    }

    /**
     *
     */
    public function dispatch()
    {
        if(isset($_SESSION['user_id'])) {
//            $user = $this->get_role();
            if ($_SESSION['role'] === 0) {
                echo "Vous n'avez pas les droits pour accéder à cette page";
//                return FALSE;
                exit();
            } elseif($_SESSION['role'] === 1) {
                echo "ok";
//                return TRUE;
                exit();
            }
        }
        else{
            echo "Vous devez vous connecter pour accéder à cette page";
//            return FALSE;
            exit();
        }
    }
}