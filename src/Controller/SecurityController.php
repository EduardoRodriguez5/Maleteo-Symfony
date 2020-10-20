<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return $this->redirectToRoute('maleteo/registro');
        
    }

      /**
     * @Route ("maleteo/registro", name="signUp")
     */
    public function userPage(){

        return $this->render("registro.html.twig");
        }
  
    /**
     * @Route ("registro/completed", name="registro")
     */
  
    public function  newUser(Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $passwordEncoder){
  
        $user = new User();
        $user->setUsername($request->get("username"));
        $user->setPassword($passwordEncoder->encodePassword($user, $request->get("password")));
  
        $doctrine->persist($user);
        $doctrine->flush();
  
        return new Response("Registro completado");
  
  
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route ("registro/admin")
     */
    public function newAdmin(Request $request, EntityManagerInterface $doctrine, UserPasswordEncoderInterface $passwordEncoder){

        $admin = new User();
        $admin->setUsername("admin");
        $admin->setPassword($passwordEncoder->encodePassword($admin, "admin"));
        $admin->setRoles(['ROLE_ADMIN']);

        $doctrine->persist($admin);
        $doctrine->flush();

        return new Response ("Admin creado");


        
    } 

}
