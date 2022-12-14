<?php session_start();
	require_once 'model/model_dto/UserDto.php';
	require_once 'model/model_dao/UserDao.php';
	class Login {
		private $userDao;
		public function __construct(){
			// $this->userDao = new UserDao;
		}
		public function index(){			
			require_once 'view/roles/business/header.php';
			require_once 'view/business/login.view.php';
			require_once 'view/roles/business/footer.php';
		}
		public function validarLogin(){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$userLog = $_POST['usuario'];
				$passLog = $_POST['contrasenia'];
				echo $userLog . " y " . $passLog;
				$userDto = new UserDto($userLog, $passLog);				
				 $userDto = $this->userDao->loginStart($userDto);				
				 print_r($userDto);
				 if ($userDto) {
				 	if ($userDto->getStatusUser() == 1) {
				 		if ($userDto->getIdRol() == 1) {
				 			$_SESSION['module'] = 'admin';
				 		} elseif ($userDto->getIdRol() == 3) {
				 			$_SESSION['module'] = 'customer';
				 		} elseif ($userDto->getIdRol() == 4) {
				 			$_SESSION['module'] = 'seller';
				 		}
				 		$userDto = serialize($userDto);
				 		$_SESSION['userDto'] = $userDto;
				 		header('Location: ?c=Dashboard');
				 	} else {
				 		header('Location: ?');
				 	}
				 } else {					
				 	header('Location: ?');
				 }
			}
		}
	}
?>