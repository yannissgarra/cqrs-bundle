<?php

/*
 * (c) Yannis Sgarra <hello@yannissgarra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Webmunkeez\CQRSBundle\Query;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Yannis Sgarra <hello@yannissgarra.com>
 */
final class QueryValueResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        $argumentType = $argument->getType();

        if (null === $argumentType) {
            return [];
        }

        if (false === is_subclass_of($argumentType, QueryInterface::class)) {
            return [];
        }

        $routeData = $request->attributes->get('_route_params', []);

        $queryData = $request->query->all();

        $bodyData = false === empty($request->getContent()) ? json_decode($request->getContent(), true) : [];

        $params = array_merge($routeData, $queryData, $bodyData);

        return [$this->serializer->deserialize(json_encode($params), $argumentType, JsonEncoder::FORMAT, ['disable_type_enforcement' => true])];
    }
}
