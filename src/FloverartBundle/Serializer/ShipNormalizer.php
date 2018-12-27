<?php

namespace FloverartBundle\Serializer;

use FloverartBundle\Entity\Ship;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Class ShipNormalizer
 *
 */
class ShipNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{


    /**
     * @param Ship  $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        if (isset($context['apps'])) {
            return [
                'id'      => $object->getId(),
                'address' => $object->getAddress(),
            ];
        }

        if (isset($context['full'])) {
            return [
                'id'      => $object->getId(),
                'address' => $object->getAddress(),
            ];
        }

        return [
            'id' => $object->getId(),
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
        return $data instanceof Ship;
    }

}