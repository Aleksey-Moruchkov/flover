<?php

namespace FloverartBundle\Serializer;

use FloverartBundle\Entity\Users;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Class UsersNormalizer
 *
 */
class UsersNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /**
     * @param Users $object
     * @param null   $format
     * @param array  $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'id'                => $object->getId(),
            'login'             => $object->getLogin(),
        ];
    }

    /**
     * @param mixed $data
     * @param null  $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Users;
    }

}