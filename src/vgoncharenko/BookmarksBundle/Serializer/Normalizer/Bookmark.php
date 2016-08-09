<?php

namespace vgoncharenko\BookmarksBundle\Serializer\Normalizer;

use vgoncharenko\BookmarksBundle\Entity\Bookmark;
use vgoncharenko\BookmarksBundle\Entity\Comment;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * User normalizer
 */
class UserNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'uid' => $object->getUid(),
            'url' => $object->getUrl(),
            'created_at' => $object->getCreatedAt(),
            'comments' => array_map(
                function (Comment $comment) {
                    return [
                        'uid' => $comment->getUid(),
                        'created_at' => $comment->getCreatedAt(),
                        'text' => $comment->getText(),
                    ];
                },
                $object->getComments()
            )
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Bookmark;
    }
}