<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    // /**
    //  * @Route("", name="app_default")
    //  */
    // public function index(): Response
    // {
    //     return new Response("INDEX");
    // }
    // /**
    //  * @Route("/test")
    //  */
    // public function test(): Response
    // {
    //     return new Response("test");
    // }

    // /**
    //  * @Route("/test1/{parametro}")//entre llaves lo que va a ir escrito en la url
    //  */
    // public function test1($parametro = 'por defecto'): Response
    // {
    //     return new Response($parametro);
    // }

    // /**
    //  * @Route("/test2")
    //  */
    // public function test2(Request $request): Response //para conseguir los params después del directorio
    // {
    //     $param1 = $request->query->get('param1');
    //     return new Response($param1);
    // }

   //EJERCICIO CON URL http://localhost/symfony/prueba1/public/index.php/calculo/division?n1=4&n2=6
   //EJERCICIO CON URL http://localhost/symfony/prueba1/public/index.php/calculo/suma?n1=4&n2=6
   //EJERCICIO CON URL http://localhost/symfony/prueba1/public/index.php/calculo/resta?n1=4&n2=6
   //EJERCICIO CON URL http://localhost/symfony/prueba1/public/index.php/calculo/producto?n1=4&n2=6
   //y todo en una sola función

    // /**
    //  * @Route("/calculo/{operacion}")//con las llaves podemos obtener el parametro y luego lo incluimos en la función
    //  */
    // public function operacion(Request $request, $operacion): Response
    // {
    //     $n1 =  $request->query->get('n1');
    //     $n2 =  $request->query->get('n2');
    //     if (!is_numeric($n1) || !is_numeric($n2)){
    //         return new Response('ERROR');
    //     }
    //     if($operacion == 'division' && $n2 == 0){
    //         return new Response('No sabes de mates verdad?');
    //     }
    //     switch ($operacion) {
    //         case 'suma':
    //             $resultado = $n1 + $n2;
    //             break;
    //         case 'resta':
    //             $resultado = $n1 - $n2;
    //             break;
    //         case 'producto':
    //             $resultado = $n1 * $n2;
    //             break;
    //         case 'division':
    //             $resultado = $n1 / $n2;
    //             break;
    //     }

    //     return new Response($resultado);
    // }//comentado porque sino se lco come todo

    // //EJEMPLO CON http://localhost/symfony/prueba1/public/index.php/test3/json?asdef=3&v=jldsljf&v2=3&param1=4567
    //  /**
    //  * @Route("/test3/json", methods={"GET"})//aquí se indica el método
    //  */
    // public function test3(Request $request): Response //para obtener las información en json con JsonResponse
    // {
        
    //     return new JsonResponse([//aquí toda la info posible con sus claves  en forma de array
    //         'query' => $request -> query -> all(),
    //         'headers' => $request -> headers->all(),//toda la info de la cabecera, poniendo como clave del array headers
    //         'server' => $request -> server->all(),
    //         'cookies' => $request -> cookies->all()
    //         ] );
    // }//con firefox se ve más bonito
    //  /**
    //  * @Route("/form", methods={"POST"})//si no pusieramos ninguno los pillaria todos.
    //  */
    // public function test3post(Request $request): Response //para obtener las información en json con JsonResponse
    // {
    //     $data = $request -> toArray();
    //     return new JsonResponse([
    //         'query' => 'ok',
    //         'data' => $data
    //         ] );
    // }
     /**
     * @Route("/form", methods={"POST", "PUT"})
     */
    public function form(Request $request): Response //para obtener las información en json con JsonResponse
    {
        $data = $request -> request -> all();
        /** @var UploadedFile $file */ //esto sirve para determinar el tipo de archivo del que se trata
        $file = $request -> files -> get('file1');
        $content = $file -> getContent();
        //con esta primera respuesta lo que hacemos es mostrar los datos en un json
        // return new JsonResponse([
        //     'query' => 'ok',
        //     'data' => $data,
        //     'fileName' => $file -> getClientOriginalName(),
        //     'content' => base64_encode($content)//todo lo que sea binario lo codifica o descodifica en el archivo
        //     //aquí codificamos el código y luego se puede descodificar donde sea necesario.
        //     ]);
        //en esta nueva respuesta, lo que hacemos es configurar la cabecera para que descargue el contendio
        return new Response($content, 200, [
            //configuramos el contenido para que se descargue.
            'Content-Type' => 'application/octet-stream',
            //esta segunda opción es para decirle que este tipo de archivo es img y lo ponga en la pagina
            // 'Content-Type' => 'image/jpeg',
            //con esta segunda segunda opción de cabecera determinamos como se va a llamar el contenido
            //a descargar
            'Content-Disposition' => 'attachment; filename="' . $file -> getClientOriginalName(). '"'
        ]);
    }
}
