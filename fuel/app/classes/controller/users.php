<?php
use Firebase\JWT\JWT;
class Controller_Users extends Controller_Base
{
    private  $idAdmin = 1;
    private  $idUser = 2;


	//esta hecho falta probar
	//AQUI TENGO UN SIMPLE REGISTRO PONIENDO LOS DATOS NECESARIOS QUE SON USERNAME, SURNAME, BORN, PASSWORD, MOBILE, EMAIL(mirar si necesitan coordenadas o tengo que harcodearlas.)
    public function post_register()
    {
        try 
        {
            if ( !isset($_POST['userName']) || !isset($_POST['surName']) || !isset($_POST['born'])  || !isset($_POST['password']) || !isset($_POST['mobile'])  || !isset($_POST['email'])) 
            {
            	return $this->respuesta(400, 'Algun paramentro esta vacio', '');
            }

            //ver si puedo quitar esto haciendo que pueda meter los datos sin necesidad de ponerlo y solamente harcodearlo(x e y)
            if(isset($_POST['x']) || isset($_POST['y']))
            {
            		if(empty($_POST['x']) || empty($_POST['y']))
            		{
	            		return $this->respuesta(400, 'Coordenadas vacias', '');
	            	}
            	}
            	else
            	{
            		return $this->respuesta(400, 'Coordenadas no definidas', '');
            }
            if(!empty($_POST['userName']) && !empty($_POST['surName'])  && !empty($_POST['born']) && !empty($_POST['password']) && !empty($_POST['mobile']) && !empty($_POST['email']) )
            {
            	if(strlen($_POST['password']) < 5)
            	{
            		return $this->respuesta(400, 'La contraseña debe tener al menos 5 caracteres', '');
            	}
				$input = $_POST;
	            $newUser = $this->newUser($input);
	           	$json = $this->saveUser($newUser);
	        }
	        else
	        {
	        	return $this->respuesta(400, 'Algun campo vacio', '');
	        }
        }
        catch (Exception $e){
        	return $this->respuesta(500, $e->getMessage(), '');
        }      
    }

    //esta hecho falta probar
    private function newUser($input)
    {
    		$user = new Model_Users();
            $user->userName = $input['userName'];
            $user->surName = $input['surName'];
            $user->born = $input['born'];
            $user->email = $input['email'];
            $user->password = $this->encode($input['password']);
            $user->mobile = $input['mobile'];
            $user->id_role = $this->idUser;
            $user->profilePicture = "";
            $user->x = $input['x'];
			$user->y = $input['y'];
            return $user;
    }

	//esta hecho falta probar
    private function saveUser($user)
    {
    	$userExists = Model_Users::find('all', 
    								array('where' => array(
    													array('email', '=', $user->email),
    														)
    									)
    							);
    	if(empty($userExists)){
    		$userToSave = $user;
    		$userToSave->save();
    		$arrayData = array();
    		$arrayData['userName'] = $user->userName;
    		return $this->respuesta(201, 'Usuario creado', $arrayData);
    	}else{
    		return $this->respuesta(204, 'Usuario ya registrado', '');
    	}
    }

	//esta hecho probarlo
    public function post_login()
    {
    	try
    	{
	        if (!isset($_POST['email']) || !isset($_POST['userName']) || !isset($_POST['password']) ) 
	        {
	        	return $this->respuesta(400, 'Alguno de los datos esta vacio', '');
	        }
	        	else if( !empty($_POST['email']) && !empty($_POST['userName']) && !empty($_POST['password']))
	        {
	            $input = $_POST;
	            $user = Model_Users::find('all', 
		            						array('where' => array(
		            							array('email', '=', $input['email']),
		            							array('userName', '=', $input['userName']),  
		            							array('password', '=', $this->encode($input['password']))
		            							)
		            						)
		            					);
	            if(!empty($user))
	            {
	            	$user = reset($user);
	            	$id = $user->id;
	            	$userName = $user->userName;
	            	$surName = $user->surName;
	            	$born = $user->born;
	            	$email = $user->email;
	            	$password = $user->password;	            	
	            	$id_role = $user->id_role;
	            	$profilePicture = $user->profilePicture;
	                $token = $this->encodeToken($userName, $surName, $password, $id, $email, $id_role, $profilePicture);
	                $arrayData = array();
	               	$arrayData['token'] = $token;
	               	return $this->respuesta(200, 'Log In correcto', $arrayData);
	        	}
	        	else
	        	{
	        		return $this->respuesta(400, 'algun dato erroneo', '');
	       		}
	     
	        }
	        else
	        {
	        	return $this->respuesta(400, 'No se permiten cadenas de texto vacias', '');
	        }
	        	
	    }
	    catch(Exception $e)
	    {
	    	return $this->respuesta(500, $e->getMessage(), '');
	    }
	}
	
	//probar si funciona correctamente
	public function post_forgotPassword()
	{
		try
		{
			$input = $_POST;
			if ( !isset($_POST['userName']) || !isset($_POST['surName']) || !isset($_POST['email']) ) 
			{
				return $this->respuesta(400, 'alguno de los datos esta vacio', '');
	        }
	        else if( !empty($_POST['userName']) && !empty($_POST['surName']) && !empty($_POST['email']))
	        {
		    	$user = Model_Users::find('all', 
		           					array('where' => array(
		           							array('userName', '=', $input['userName']), 
		           							array('email', '=', $input['email'])
		           							)
		           						)
		           					);
			    if($user != null)
			    {
			   		   	$user = reset($user);
		            	$userName = $user->userName;
		            	$surName = $user->surName;
		            	$mobile = $user->mobile;
		            	$password = $user->password;
		            	$id = $user->id;
		            	$email = $user->email;
		            	$id_role = $user->id_role;
		            	$profilePicture = $user->profilePicture;
		                $token = $this->encodeToken($userName, $surname, $password, $mobile, $id, $email, $id_role, $profilePicture);
		                $arrayData = array();
		               	$arrayData['token'] = $token;
		               	return $this->respuesta(200, 'forgot correcto', $arrayData);
			    }
			    else
			    {
			    	return $this->respuesta(400, 'Usuario no encontrado.', '');
			    }
			}
		}
		catch(Exception $e)
		{
			return $this->respuesta(500, $e->getMessage(), '');
		}
	}

	//esta hecho falta probar
	public function post_changePassword()
	{
		$authenticated = $this->authenticate();
    	$arrayAuthenticated = json_decode($authenticated, true);
    	
    	 if($arrayAuthenticated['authenticated']){
			$newPassword = $_POST['newPassword'];
			if( isset($newPassword)) 
			{
				$decodedToken = $this->decodeToken();
				$user = Model_Users::find('all', 
				            					array('where' => array(
				            							array('userName', '=', $decodedToken->userName), 
				            							array('password', '=', $decodedToken->email)
				            							)
				            						)
				            					);
				if(isset($newPassword))
				{
					if(!empty($newPassword))
					{
						if(strlen($newPassword) >= 5)
						{
							$userTochange = Model_Users::find($decodedToken->id);
							$userTochange ->password = $this->encode($newPassword);
							$userTochange -> save();

								$userName = $userTochange->userName;
				            	$password = $userTochange->password;
				            	$id = $userTochange->id;
				            	$email = $userTochange->email;
				            	$id_role = $userTochange->id_role;
				            	$profilePicture = $userTochange->profilePicture;

							$token = $this->encodeToken($userName, $password, $id, $email, $id_role, $profilePicture);
							$arrayData = array();
			               	$arrayData['token'] = $token;
			               	return $this->respuesta(200, 'Contraseña modificada correctamente', $arrayData);
					    }
					    else
					    {
					    	return $this->respuesta(204, 'Contraseña demasiado corta', "");
					    }
				    }
				    else
				    {
				    	return $this->respuesta(400, 'Contraseña vacios', "");
				    }
				}
				else
				{
					return $this->respuesta(400, 'Campos vacios', "");
				}
			}
			else
			{
				return $this->respuesta(400, 'parametro no definido', "");
			}
		}
		else
		{
			return $this->respuesta(400, 'NO AUTORIZADO', "");
		}

	}

	//esta hecho falta probar
	public function get_show()
	{
		$authenticated = $this->authenticate();
    	$arrayAuthenticated = json_decode($authenticated, true);
    	
    	 if($arrayAuthenticated['authenticated'])
    	 {
	    		try {
               
                $users = Model_Users::find('all');
	            $indexedUsers = Arr::reindex($users);
	            foreach ($indexedUsers as $key => $user) {
	                	$userName[] = $user->userName;
		            	$surName[] = $user->surName;
		            	$mobile[] = $user->mobile;
		            	$password[] = $user->password;
		            	$id[] = $user->id;
		            	$email[] = $user->email;
		            	$id_role[] = $user->id_role;
		            	$profilePicture[] = $user->profilePicture;
	            }
                //AL METER BIEN LOS DATOS SE TE CREA BIEN LA CANCION
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuarios',
                    'data' => $indexedUsers
                ));
                return $json;
            } 
            catch (Exception $e) 
            {
                //ERROR EN EL SERVIDOR O ERROR DE RED
                return $this->respuesta(500, 'Error del servidor', '');
            }
        }
        else
        {
            //METE EL TOKEN EN LA AUTHENTICACION
        	return $this->respuesta(401, 'Usuario no autenticado', '');
        }
        
    }
}