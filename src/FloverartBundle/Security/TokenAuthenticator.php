<?php
namespace FloverartBundle\Security;

use Doctrine\ORM\EntityManager;
use FloverartBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Provider\GuardAuthenticationProvider;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser(). Returning null will cause this authenticator
     * to be skipped.
     */
    public function getCredentials(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN',null);

        if (is_null($token)){
            $token = $request->query->get('token',null);
        }

        // What you return here will be passed to getUser() as $credentials
        return array(
            'token' => $token,
        );
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|void
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiKey = $credentials['token'];

        if (null === $apiKey) {
            return;
        }

        if (count(explode('.', $apiKey)) != 3) {
            return;
        }

        list($t,$t1,$id) = explode('.', $apiKey,3);

        // if a User object, checkCredentials() is called
        return $userProvider->loadUserByUsername($id);
    }

    /**
     * @param mixed $credentials
     * @param User $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        list( $rnd_string, $hash, $id) = explode('.', $credentials['token']);

        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
        return  (md5($rnd_string . $user->getPassword()) === $hash);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ('OPTIONS' === $request->getRealMethod())
        {
            return new JsonResponse();
        }

        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}