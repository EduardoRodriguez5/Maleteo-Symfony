<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
USE App\Entity\Demo;
use App\Entity\Opiniones;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class DefaultController extends AbstractController
{

    /**
     * @Route("/maleteo", name="maleteo")
     */

    public function Opiniones(EntityManagerInterface $doctrine){

      $repo = $doctrine->getRepository(Opiniones::class);
      $opiniones = $repo->findBy(
        [],
        ["id" => "DESC"],
        3
      );

     return $this->render("home.html.twig",['opiniones' => $opiniones]);
   }

     public function homepage(){

        return $this->render("home.html.twig");
     }
     /**
      * @Route ("/demo", name="Demo")
      */

      public function addDemo(Request $request, EntityManagerInterface $doctrine){

         $demo = new Demo();
         $demo->setNombre($request->get("nombre"));
         $demo->setEmail($request->get("email"));
         $demo->setCiudad($request->get("ciudad"));

         $doctrine->persist($demo);
         $doctrine->flush();

         return new Response("Solicitud Completada");
      }

      /**
       * @Route ("/newOpiniones")
       */
      
       public function addOpiniones(Request $request, EntityManagerInterface $doctrine){
      
      
         $opinion1 = new Opiniones();
         $opinion1 ->setAutor("Elena");
         $opinion1 ->setCiudad("Santa Cruz de Tenerife");
         $opinion1 ->setComentario("Maravilloso Servicio");

         $doctrine->persist($opinion1);
         $doctrine->flush();
         
         $opinion2 = new Opiniones();
         $opinion2 ->setAutor("Estefania");
         $opinion2 ->setCiudad("Málaga");
         $opinion2 ->setComentario("Excelente, lo mejor que he encontrado");

         $doctrine->persist($opinion2);
         $doctrine->flush();

         $opinion3 = new Opiniones();
         $opinion3 ->setAutor("Lucas");
         $opinion3 ->setCiudad("Valencia");
         $opinion3 ->setComentario("Servicio correcto, sin más");

         $doctrine->persist($opinion3);
         $doctrine->flush();

         return new Response("Elementos agregados");
         
      }

      /**
       * @Route ("/maleteo/mostrarSolicitudes", name="mostrarSolicitudes")
       * @IsGranted("ROLE_ADMIN")
       */

       public function mostrarSolicitudes(EntityManagerInterface $doctrine){

         $repo = $doctrine->getRepository(Demo::class);
         $solicitudes = $repo->findAll();
   
        return $this->render("solicitudes.html.twig",['solicitudes' => $solicitudes]);


       }


       /**
        *@Route ("/maleteo/opiniones", name="formularioOpiniones") 
        */

        public function OpinionesPage(){

         return $this->render("form-opiniones.html.twig");
         }

       /**
      * @Route ("/maleteo/opiniones/enviar", name="Opiniones")
      */
      
       public function addOpinionesForm(Request $request, EntityManagerInterface $doctrine){

         $opinion = new Opiniones();
         $opinion->setComentario($request->get("comentario"));
         $opinion->setAutor($request->get("autor"));
         $opinion->setCiudad($request->get("ciudad"));

         $doctrine->persist($opinion);
         $doctrine->flush();

         return new Response("Opinión añadida");


      }


      /**
       * @Route ("/maleteo/mostrarOpiniones", name ="mostrarOpiniones")
       * @IsGranted("ROLE_ADMIN")
       */

      public function mostrarOpiniones(EntityManagerInterface $doctrine){

        $repo = $doctrine->getRepository(Opiniones::class);
        $opiniones = $repo->findAll();
  
       return $this->render("opiniones.html.twig",['opiniones' => $opiniones]);


      }


}
