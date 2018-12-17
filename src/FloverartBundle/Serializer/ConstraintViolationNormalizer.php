<?php

namespace FloverartBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Validator\ConstraintViolation;


/**
 * Class TypesNormalizer
 *
 * @package Zotto\MarketBundle\Serializer\Normalizer
 */
class ConstraintViolationNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /**
     * @param ConstraintViolation  $object
     * @param null  $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'message'   => $object->getMessage(),
            'field'     => $object->getPropertyPath()
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
        return $data instanceof ConstraintViolation;
    }

}