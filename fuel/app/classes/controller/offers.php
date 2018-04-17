<?php
use Firebase\JWT\JWT;
class Controller_Offers extends Controller_Base
{
  //esta hecho falta probar
  //AQUI TENGO UN SIMPLE REGISTRO PONIENDO LOS DATOS NECESARIOS QUE SON nameOffer, percentage, nameLocal, normalPrize, MOBILE, EMAIL(mirar si necesitan coordenadas o tengo que harcodearlas.)
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
            
        }
        catch (Exception $e){
          return $this->respuesta(500, $e->getMessage(), '');
        }      
    }

    //esta hecho falta probar
    private function newOffer($input)
    {
        $offer = new Model_Offers();
            $offer->nameOffer = $input['nameOffer'];
            $offer->percentage = $input['percentage'];
            $offer->nameLocal = $input['nameLocal'];
            $offer->email = $input['email'];
            $offer->normalPrize = $input['normalPrize'];
            $offer->x = $input['x'];
            $offer->y = $input['y'];
            return $offer;
    }

  //esta hecho falta probar
    private function saveOffer($offer)
    {
      $offerExists = Model_Offers::find('all');
      if(empty($offerExists)){
        $offerToSave = $offer;
        $offerToSave->save();
        $arrayData = array();
        $arrayData['nameOffer'] = $offer->nameOffer;
        return $this->respuesta(201, 'Usuario creado', $arrayData);
      }else{
        return $this->respuesta(204, 'Usuario ya registrado', '');
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
               
              $offers = Model_Offers::find('all');
              $indexedOffers = Arr::reindex($offers);
              
              //AL METER BIEN LOS DATOS SE TE CREA BIEN LA CANCION
                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'Usuarios',
                    'data' => $indexedOffers
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