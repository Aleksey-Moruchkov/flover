<?php

namespace FloverartBundle\Serializer;

use FloverartBundle\Entity\Orders;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Class OrdersNormalizer
 *
 */
class OrdersNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /**
     * @param Orders $object
     *
     * @return array
     */
    private function _AppsNormalize($object)
    {
        return [
            'id'           => $object->getId(),
            'phone'        => $object->getPhone(),
            'status'       => $object->getStatus(),
            'comment'      => $object->getComment(),
            'created_at'   => $object->getCreatedAt(),
            'amount'       => $object->getAmount(),
            'amount_from'  => $object->getAmountFrom(),
            'amount_to'    => $object->getAmountTo(),
            'postcard'     => $object->getPostcard(),
            'product_type' => $object->getProductType(),
            'shipping'     => $this->serializer->normalize($object->getShip(), null, ['apps'=>1]),
        ];
    }

    /**
     * @param Orders $object
     *
     * @return array
     */
    private function _FullNormalize($object)
    {
        return [
            'id'           => $object->getId(),
            'phone'        => $object->getPhone(),
            'status'       => $object->getStatus(),
            'comment'      => $object->getComment(),
            'created_at'   => $object->getCreatedAt(),
            'amount'       => $object->getAmount(),
            'amount_from'  => $object->getAmountFrom(),
            'amount_to'    => $object->getAmountTo(),
            'postcard'     => $object->getPostcard(),
            'product_type' => $object->getProductType(),
            'shipping'     => $this->serializer->normalize($object->getShip(), null, ['full'=>1]),
        ];
    }

    /**
     * @param Orders $object
     * @param null   $format
     * @param array  $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        if (isset($context['apps'])) {
            return $this->_AppsNormalize($object);
        }

        if (isset($context['full'])) {
            return $this->_FullNormalize($object);
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
        return $data instanceof Orders;
    }

}