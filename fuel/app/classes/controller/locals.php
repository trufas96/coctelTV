<?php
class Controller_Locals extends Controller_Base
{
   public $id_admin = 1;
 public function post_create()
 {
 
 $authenticated = $this->authenticate();
     $arrayAuthenticated = json_decode($authenticated, true);
     if($arrayAuthenticated['authenticated'])
     {
      $decodedToken = $this->decode($arrayAuthenticated['data']);
      
      try
      {
             //name
              if(!isset($_POST['name']) || empty($_POST['name']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'El nombre esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }

              //direction
              if( !isset($_POST['direction']) || empty($_POST['direction']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La direction esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //CP
              if( !isset($_POST['CP']) || empty($_POST['CP']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'El CP esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //localTelephone
              if( !isset($_POST['localTelephone']) || empty($_POST['localTelephone']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La localTelephone esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //daysL
              if( !isset($_POST['daysL']) || empty($_POST['daysL']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La daysL esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //holidays
              if( !isset($_POST['holidays']) || empty($_POST['holidays']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La holidays esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //morning
              if( !isset($_POST['morning']) || empty($_POST['morning']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La morning esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //evening
              if(!isset($_POST['evening']) || empty($_POST['evening']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La evening esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              
              //city
              if( !isset($_POST['city']) || empty($_POST['city']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La city esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //city2
              if( !isset($_POST['city2']) || empty($_POST['city2']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La city2 esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              //x
              if( !isset($_POST['x']) || empty($_POST['x']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La x esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }
              
              //y
              if( !isset($_POST['y']) || empty($_POST['y']))
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La y esta vacio',
                               'data' => '' 
                           ));
                           return $json;
              }

              //profilePLocal
              if( !isset($_POST['profilePLocal']) || empty($_POST['profilePLocal']))
              {
                        $arrayData = array();
                        $arrayData['files'] = $_FILES;
                        $arrayData['post'] = $_POST; 
                           $json = $this->response(array(
                               'code' => 400,
                               'message' => 'La photo esta vacia',
                               'data' =>  $arrayData
                           ));
                           return $json;
              }
              $config = array(
                  'path' => DOCROOT . 'assets/img',
                  'randomize' => true,
                  'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
              );

              Upload::process($config);
              $photoToSave = "";
              if (Upload::is_valid())
              {
                  Upload::save();
                  foreach(Upload::get_files() as $file)
                  {
                    // var_dump($_FILES['photo']['saved_as']);
                    $photoToSave = 'http://'.$_SERVER['SERVER_NAME'].'coctelTV_api/public/assets/img/'.$file['saved_as'];
                  }
              }

              foreach (Upload::get_errors() as $file)
              {
                  return $this->response(array(
                      'code' => 500,
                      'message' => 'Error en el servidor',
                      'data' => $file 
                  ));
              }
                  
                         $newLocals = $this->newLocals($_POST, $photoToSave, $decodedToken);
                         $json = $this->saveLocals($newLocals);
                         return $json;
          }

          catch (Exception $e)
          {
              return $this->respuesta(500, $e->getMessage(), '');
          }
        
    }     
}


  
 



  private function newLocals($input)
  {
      $local = Model_Locals();
      $local->name = $input['name'];
      $local->direction = $input['direction'];
      $local->profilePLocal = "";
      $local->CP = $input['CP'];
      $local->localTelephone = $input['localTelephone'];
      $local->daysL = $input['daysL'];
      $local->holidays = $input['holidays'];
      $local->morning = $input['morning'];
      $local->evening = $input['evening'];
      $local->city = $input['city'];
      $local->city2 = $input['city2'];
      $local->x = $input['x'];
      $local->y = $input['y'];
      $local->id_user = $this->id_admin;
      return $local;
  }


  private function saveLocals($local)
  {
      $localExists = Model_Locals::find('all', 
            array('where' => array(
                 array('name', '=', $local->name),
                )
      ));
      if(empty($localExists))
      {
          $localToSave = $local;
          $localToSave->save();
          $arrayData = array();
          $arrayData['name'] = $local->name;
          return $this->respuesta(201, 'local creado', $arrayData);
      }
      else
      {
          return $this->respuesta(204, 'local ya creado', '');
      }
  }

    
  //terminado para probar 
    public function post_delete()
    {
     $authenticated = $this->authenticate();
     $arrayAuthenticated = json_decode($authenticated, true);
     
      if($arrayAuthenticated['authenticated']){
        $decodedToken = JWT::decode($arrayAuthenticated["data"], MY_KEY, array('HS256'));
        if(!empty($_POST['id']))
        {
            $local = Model_Locals::find($_POST['id']);
            if(isset($local))
            {
                if($decodedToken->id == $local->id_user)
                {
                  $local->delete(); 
     
                  $json = $this->response(array(
                       'code' => 200,
                       'message' => 'local borrado',
                       'data' => ''
                   ));
                   return $json;
                }
                else
                {
                 $json = $this->response(array(
                     'code' => 401,
                     'message' => 'No puede borrar un local que no es tuyo',
                     'data' => ''
                  ));
                  return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                     'code' => 401,
                     'message' => 'local no valido',
                     'data' => ''
                ));
                return $json;
            }
        }
        else
        {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'El id no puede estar vacio',
                    'data' => ''
                ));
                return $json;
        }
          }
          else
          {
               $json = $this->response(array(
                   'code' => 400,
                   'message' => 'Falta el autorizacion',
                   'data' => ''
                ));
                return $json;
          }
    }


    //terminaod y probar
    //update
    public function get_show()
    {

        $authenticated = $this->authenticate();
        $arrayAuthenticated = json_decode($authenticated, true);
        if($arrayAuthenticated['authenticated'])
        {
        $decodedToken = $this->decode($arrayAuthenticated['data']);
            
            $locals = Model_Locals::find('all');
              if(!empty($locals))
              {
                  foreach ($locals as $key => $local) 
                  {
                      $arrayLocal[] = $local;
                  }
                      $json = $this->response(array(
                        'code' => 200,
                        'message' => 'mostrando lista de locals del usuario', 
                        'data' => $arrayLocal
                        )); 
                        return $json; 
              }
                else
              {
                  $json = $this->response(array(
                    'code' => 202,
                    'message' => 'Aun no tienes ningun local',
                    'data' => ''
                    ));
                    return $json;
              }
            
        }
    }    
}
?>