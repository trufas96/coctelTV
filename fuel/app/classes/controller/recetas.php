<?php
class Controller_recetas extends Controller_Base
{
   
public function post_create()
{
    $authenticated = $this->authenticate();
    $arrayAuthenticated = json_decode($authenticated, true);
     if($arrayAuthenticated['authenticated'])
     {
      $decodedToken = $this->decode($arrayAuthenticated['data']);
      if ($decodedToken->id == $this->id_admin)
      {
          try 
          {
             //photo
             if (!isset($_FILES['photo']) || empty($_FILES['photo'])) 
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

              //ingredientes
              if(!isset($_POST['ingrediente1']) || empty($_POST['ingrediente1'])
                  !isset($_POST['ingrediente2']) || empty($_POST['ingrediente2'])
                  !isset($_POST['ingrediente3']) || empty($_POST['ingrediente3'])
                  !isset($_POST['ingrediente4']) || empty($_POST['ingrediente4'])
                  !isset($_POST['ingrediente5']) || empty($_POST['ingrediente5'])
                  !isset($_POST['ingrediente6']) || empty($_POST['ingrediente6'])
                  !isset($_POST['ingrediente7']) || empty($_POST['ingrediente7'])
                  !isset($_POST['ingrediente8']) || empty($_POST['ingrediente8'])
                  !isset($_POST['ingrediente9']) || empty($_POST['ingrediente9'])
                  !isset($_POST['ingrediente10']) || empty($_POST['ingrediente10'])
                )
              {
                        $json = $this->response(array(
                               'code' => 400,
                               'message' => 'algun ingrediente esta vacio',
                               'data' => '' 
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
                    $photoToSave = 'http://'.$_SERVER['SERVER_NAME'].'/zoo/minusculasNombres/public/assets/img/'.$file['saved_as'];
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
                  
                         $newStory = $this->newStory($_POST, $photoToSave, $decodedToken);
                         $json = $this->saveStory($newStory);
                         return $json;
          }

          catch (Exception $e)
          {
                         return $this->respuesta(500, $e->getMessage(), '');
          }
   
        }
        else 
        {
                return $this->respuesta(400, 'No eres el admin', '');
        }
    }     
}


private function newReceta($input)
{
  $receta = Model_Recetas();
  $receta->name = $input['name'];
  $receta->description = $input['description'];
  $receta->photo = "";
  $receta->x = $input['x'];
  $receta->y = $input['y'];
  $receta->id_type = $input['id_type'];
  $receta->id_user = $this->id_admin;
  return $receta;
}


private function saveReceta($receta)
{
    $recetaExists = Model_Recetas::find('all', 
            array('where' => array(
                 array('name', '=', $receta->name),
                  )
             )
           );
    if(empty($recetaExists))
    {
        $recetaToSave = $receta;
        $recetaToSave->save();
        $arrayData = array();
        $arrayData['name'] = $receta->name;
        return $this->respuesta(201, 'Receta creado', $arrayData);
    }
    else
    {
    return $this->respuesta(204, 'Receta ya creado', '');
    }
}


//update
public function get_download()
{

      $authenticated = $this->authenticate();
      $arrayAuthenticated = json_decode($authenticated, true);
      if($arrayAuthenticated['authenticated'])
      {
        $decodedToken = $this->decode($arrayAuthenticated['data']);
            if ($decodedToken->id != 1)
            {

              $recetas = Model_Recetas::find('all');
                if(!empty($recetas))
                {
                  foreach ($recetas as $key => $receta) 
                  {
                    $arrayreceta[] = $receta;
                  }
                  $json = $this->response(array(
                    'code' => 200,
                    'message' => 'mostrando lista de recetas del usuario', 
                    'data' => $arrayreceta
                    )); 
                    return $json; 
                }
                else
                {
                  $json = $this->response(array(
                    'code' => 202,
                    'message' => 'Aun no tienes ningun receta',
                    'data' => ''
                  ));
                return $json;
                }
            }
            else
            {
              return $this->respuesta(400, 'Eres el admin', '');
            }
      }
}  


}
?>