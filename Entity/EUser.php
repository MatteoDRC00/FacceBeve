<?php
/**
 * @access public
 * @package Entity
 */
    class EUser{
		
		protected string $password;
        protected string $username;

        function __construct($username,$password){
			$this->username=$username;
			$this->password=$password;
        }
		
		//--------------Metodi GET-----------------------
		/**
         * @return string
         */
		protected function getUsername(){
			return $this->username;
		}
		
		/**
         * @return string
         */
		protected function getPassword(){
			return $this->password;
		}
		
		//--------------Metodi SET-----------------------
		/**
         * @param string $username
         */
		public function setUsername(string $username): void
        {
            $this->username = $username;
        }
		
		/**
         * @param string $password
         */
		public function setPassword(string $password): void
        {
            $this->username = $username;
        }

    }
?>
