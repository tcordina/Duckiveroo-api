<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class SecurityController extends AbstractController
{
    private $repository;
    private $encoder;

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    /**
     * @Rest\Route("/login", name="security_login", methods={Request::METHOD_POST,Request::METHOD_OPTIONS})
     */
    public function login(Request $request)
    {
        if ($request->isMethod('OPTIONS')) {
            return new Response('ok');
        }
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');
        $user = $this->repository->findOneBy(['email' => $email]);
        if ($user instanceof UserInterface) {
            if ($this->encoder->isPasswordValid($user, $password)) {
                /*$user = [
                    'email' => $user->getEmail(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'apikey' => $user->getApiKey(),
                ];*/
                $apiKey = (string)$user->getApiKey();
                return new JsonResponse($apiKey);
            }
        }
        return new JsonResponse('wrong credentials');
    }

    /**
     * @Rest\Route("/register", name="security_register", methods={Request::METHOD_POST,Request::METHOD_OPTIONS,Request::METHOD_GET})
     */
    public function register(Request $request)
    {
        if ($request->isMethod('OPTIONS')) {
            return new Response('ok');
        }
        if ($request->isMethod('POST')) {
            $user = new User();
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $encodedPassword = $this->encoder->encodePassword($user, $password);
            $user->setEmail($email)
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setApiKey('testkey')
                ->setPassword($encodedPassword);
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($user);
                $em->flush();
                return new JsonResponse(true);
            } catch (DBALException $e) {
                return new JsonResponse($e);
            }
        }
    }
}
