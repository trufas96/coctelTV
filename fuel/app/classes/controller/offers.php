<?php
class Controller_Offers extends Controller_Base
{
   public $id_admin = 1;
 public function post_create()
    {
        try 
        {
            if ( !isset($_POST['nameOffer']) || !isset($_POST['percentage']) || !isset($_POST['nameLocal'])  || !isset($_POST['normalPrize'])) 
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
            if(!empty($_POST['nameOffer']) && !empty($_POST['percentage'])  && !empty($_POST['nameLocal']) && !empty($_POST['normalPrize']) && !empty($_POST['x']) && !empty($_POST['y']) )
            {
              if(strlen($_POST['normalPrize']) < 5)
              {
                return $this->respuesta(400, 'La contraseña debe tener al menos 5 caracteres', '');
              }
              $input = $_POST;
              $newOffer = $this->newOffer($input);
              $json = $this->saveOffer($newOffer);
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
    private function newOffer($input)
    {
        $Offer = new Model_Offers();
            $Offer->nameOffer = $input['nameOffer'];
            $Offer->percentage = $input['percentage'];
            $Offer->nameLocal = $input['nameLocal'];
            $Offer->normalPrize = $input['normalPrize'];
            $Offer->x = $input['x'];
            $Offer->y = $input['y'];
            return $Offer;
    }

  //esta hecho falta probar
    private function saveOffer($Offer)
    {
      $OfferExists = Model_Offers::find('all', 
                    array('where' => array(
                              array('nameOffer', '=', $Offer->nameOffer),
                                )
                      )
                  );
      if(empty($OfferExists)){
        $OfferToSave = $Offer;
        $OfferToSave->save();
        $arrayData = array();
        $arrayData['nameOffer'] = $Offer->nameOffer;
        return $this->respuesta(201, 'Usuario creado', $arrayData);
      }else{
        return $this->respuesta(204, 'Usuario ya registrado', '');
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
            $offer = Model_Offers::find($_POST['id']);
            if(isset($offer))
            {
                if($decodedToken->id == $offer->id_Offer)
                {
                  $offer->delete(); 
     
                  $json = $this->response(array(
                       'code' => 200,
                       'message' => 'offer borrado',
                       'data' => ''
                   ));
                   return $json;
                }
                else
                {
                 $json = $this->response(array(
                     'code' => 401,
                     'message' => 'No puede borrar un offer que no es tuyo',
                     'data' => ''
                  ));
                  return $json;
                }
            }
            else
            {
                $json = $this->response(array(
                     'code' => 401,
                     'message' => 'offer no valido',
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
            
            $offers = Model_Offers::find('all');
              if(!empty($offers))
              {
                  foreach ($offers as $key => $offer) 
                  {
                      $arrayoffer[] = $offer;
                  }
                      $json = $this->response(array(
                        'code' => 200,
                        'message' => 'mostrando lista de offers del usuario', 
                        'data' => $arrayoffer
                        )); 
                        return $json; 
              }
                else
              {
                  $json = $this->response(array(
                    'code' => 202,
                    'message' => 'Aun no tienes ningun offer',
                    'data' => ''
                    ));
                    return $json;
              }
            
        }
    }    
}
?>