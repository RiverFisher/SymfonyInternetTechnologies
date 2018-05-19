<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController
 * @package App\Controller
 *
 * @Route("user")
 */
class UserController extends Controller
{
  /**
   * @Route("/", name="user_index")
   * @Method("GET")
   */
  public function index()
  {
    $em = $this->getDoctrine()->getManager();

    $users = $em->getRepository(User::class)->findAll();

    //$handler = $this->get('login_success_handler');

    return $this->render('user/index.html.twig', [
      'users' => $users
    ]);
  }

  /**
   * @param Request $request
   * @param UserPasswordEncoderInterface $encoder
   * @return \Symfony\Component\HttpFoundation\Response
   * @Route("/registration", name="user")
   * @Method({"GET", "POST"})
   */
  public function registration(Request $request,
                               UserPasswordEncoderInterface $encoder)
  {
    $user = new User();

    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();

//      $encoded = $encoder
//        ->encodePassword($user, $user->getPlainPassword());

      $encoder = $this->get('security.password_encoder');
      $encoded = $encoder
        ->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($encoded);

      $user->addRole('ROLE_USER');

      $em->persist($user);
      $em->flush();

      return $this->redirectToRoute('user_index');
    }

    return $this->render('user/registration.html.twig', [
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/login", name="user_login")
   * @Method({"GET", "POST"})
   *
   * @param AuthenticationUtils $authUtils
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function login(AuthenticationUtils $authUtils)
  {
    $loginForm = $this->createFormBuilder()
      ->setAction($this->generateUrl('user_login'))
      ->setMethod('POST')
      ->add('username', TextType::class, [
        'label' => 'Username',
        'label_attr' => [
          'class' => 'control-label'
        ],
        'required' => true,
        'attr' => [
          'class' => 'form-control form-control-sm'
        ]
      ])
      ->add('password', PasswordType::class, [
        'label' => 'Password',
        'label_attr' => [
          'class' => 'control-label'
        ],
        'required' => true,
        'attr' => [
          'class' => 'form-control form-control-sm'
        ]
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Log In',
        'attr' => [
          'class' => 'btn btn-sm btn-primary col-6 mx-auto',
          'style' => 'display: block;'
        ]
      ])
      ->getForm();

    // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('user/login.html.twig', [
      'login_form'    => $loginForm->createView(),
      'last_username' => $lastUsername,
      'error'         => $error
    ]);
  }

  /**
   * @Route("/login_check", name="login_check")
   *
  public function checkAction() {
  //        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
  }*/

  /**
   * @Route("/logout", name="logout")
   */
  public function logoutAction() {
    throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
  }
}
