<?php
/**
 * Created by PhpStorm.
 * User: marcintha
 * Date: 10/12/2018
 * Time: 10:53
 */

namespace App\GraphQL\Resolver\Airplane;


use App\Common\GraphQL\BaseResolverInterface;
use App\Repository\AirplaneRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

/**
 * Class AirplanesResolver
 *
 * @package App\GraphQL\Resolver\Airplane
 */
class AirplanesResolver implements ResolverInterface, AliasedInterface, BaseResolverInterface
{

    /**
     * @var \App\Repository\AirplaneRepository
     */
    protected $repository;

    /**
     * AirplanesResolver constructor.
     *
     * @param \App\Repository\AirplaneRepository $airplaneRepository
     */
    public function __construct(AirplaneRepository $airplaneRepository)
    {
        $this->repository = $airplaneRepository;
    }

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $args
     * @return array|mixed
     */
    public function resolve(Argument $args) {
        return $this->repository->findAllOrderByCode();
    }

    /**
     * @return array
     */
    public static function getAliases()
    {
        return [
            'resolve' => 'AirplanesResolver'
        ];
    }
}