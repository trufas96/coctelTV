<?php
use \Firebase\JWT\JWT;

define('MY_KEY', 'tokens_key');
define('id_admin', 1);

class Controller_Base extends Controller_Rest
{
    private static $key = 'coctel';
    private static $encrypt = ['HS256'];
    private static $aud = null;
    /*public $id_admin = 1;
    public $id_user = 2;*/
    
    protected function respuesta($code, $message, $data = [])
    {
        $json = $this->response(array(
                    'code' => $code,
                    'message' => $message,
                    'data' => $data
                ));
            return $json;
    }

    protected function encode($data)
    {
        return  JWT::encode($data, self::$key);
        
    }
    
    protected function decode($data)
    {
        return  JWT::decode($data, self::$key, array('HS256'));
        
    }

	protected function encodeToken($userName, $surName, $born, $password, $id, $email, $id_role, $profilePicture)
    {
        $token = array(
        		"id" => $id,
                "userName" => $userName,
                "surName" => $surName,
                "born" => $born,
                "password" => $password,
                "email" => $email,
                "role" => $id_role, 
                "profilePicture" => $profilePicture            

        );
        $encodedToken = JWT::encode($token, self::$key);
        return $encodedToken;
    }

    protected function decodeToken()
    {
        $header = apache_request_headers();
        $token = $header['Authorization'];
        if(!empty($token))
        {
            $decodedToken = JWT::decode($token, self::$key, array('HS256'));
            return $decodedToken;
        }      
    }

    protected function authenticate()
    {
        try 
        {   
            $header = apache_request_headers();
            $token = $header['Authorization'];
            if(!empty($token))
            {
                $decodedToken = JWT::decode($token, $this->key, array('HS256'));
                $query = Model_Users::find('all', 
                    [
                        'where' => ['id' => $decodedToken->id,
                                    'userName' => $decodedToken->userName,
                                    'surname' => $decodedToken->surname,
                                    'born' => $decodedToken->born,
                                    'password' => $decodedToken->password, 
                                    'role' => $decodedToken->id_role,
                                    'email' => $decodedToken->email
                                 
                                ]]);

                if($query != null)
                {
                    $json = array(
                    'code' => 200,
                    'message' => 'Usuario autenticado',
                    'authenticated' => true,
                    'data' => $token
                    );
                    return json_encode($json);
                }
                else
                {
                    $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                    'authenticated' => false,
                    'data' => null
                    ));
                    return $json;
                
                }
            }
            else
            {
                $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado',
                    'authenticated' => false,
                    'data' => null
                    ));
                    return $json;
            }
        } 
        catch (Exception $UnexpectedValueException)
        {

            $json = $this->response(array(
                    'code' => 401,
                    'message' => 'Usuario no autenticado que no me entres aqui!',
                    'authenticated' => false,
                    'data' => null
                    ));
                    return $json;
        }
    }
}
?>