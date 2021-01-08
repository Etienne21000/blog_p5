<?php
namespace App\Core;

use App\Model\UserManager;

class User_role
{

    private $user_id;
    private $user_role;

    /**
     * User_role constructor.
     */
    public function __construct()
    {
        $this->user_id = $_SESSION['id'];
        $this->user_role = $_SESSION['role'];
    }

    /**
     */
    public function get_role()
    {
//        $this->user_id = $_SERVER['user_role'];
//        $this->user_role = $_SERVER['user_role'];
        return $user = [
            'user_id' =>  $this->user_id,
            'user_role' => $this->user_role,
        ];
    }

    /**
     *
     */
    public function dispatche()
    {
        $user = $this->get_role();
        if($user['user_role'] != 1){
            return $right = "Vous n'avez pas les droits pour accéder à cette page";
        }
        else{
            echo "ok";
        }
        /*if($user['user_role'] === 1){

        }
        elseif($user['user_role'] === 0)
        {

        }
        else {

        }*/

    }

    public function need_admin_access(){

    }

}