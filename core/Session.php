<?php
    namespace app\core;
    class Session {
        protected const FLASH_KEY = "flash_messages";

        public function __construct(){
            session_start();
            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach($flashMessages as $key => &$flashMessage){
                //Mark to be removed
                $flashMessage['remove'] = true;
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }

        public function setFlash($key, $message){
            $_SESSION[self::FLASH_KEY][$key] = [
              'remove' => false,
              'value' => $message  
            ];
        }

        public function getFlash($key){
            return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
        }

        public function __destruct(){
            //Iterate over Marked to be removed
            $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
            foreach($flashMessages as $key => &$flashMessage){
                $isRemove = $flashMessage['remove'];
                if ($isRemove){
                    unset($flashMessage[$key]);
                }
            }
            $_SESSION[self::FLASH_KEY] = $flashMessages;
        }
    }
?>