<?php


namespace App\Serializer\Normalizer;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\NormalizationAwareInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class PostNormalizer implements NormalizableInterface, NormalizationAwareInterface, CacheableSupportsMethodInterface
{
    use NormalizerAwareTrait;

    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): array|string|int|float|bool
    {
        /* @var Post $normalizer */
        $data = [
            'title' => $normalizer->getTitle(),
            'description' => $normalizer->getDescription(),
            'createdAt' => $normalizer->getCreatedAt(),
            'updatedAt' => $normalizer->getUpdatedAt(),
        ];

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Post;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
