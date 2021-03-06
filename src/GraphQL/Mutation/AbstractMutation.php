<?php
/**
 * Created by PhpStorm.
 * User: marcintha
 * Date: 14/12/2018
 * Time: 16:31
 */

namespace App\GraphQL\Mutation;

use App\Common\GraphQL\Mutate;
use App\Utils\GraphQL\ArgsParser;
use Overblog\GraphQLBundle\Definition\Argument;

/**
 * Class AbstractMutation
 *
 * @package App\GraphQL\Mutation
 */
abstract class AbstractMutation implements Mutate
{
    /**
     * @var string
     */
    protected const MUTATION_ENTRY = "input";

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $args
     * @param array $given
     * @return \stdClass
     */
    public function extract(Argument $args, array $given): \stdClass
    {
        $data = $args->getRawArguments();
        if (!isset($data)) {
            return NULL;
        }

        if (!array_key_exists(self::MUTATION_ENTRY, $data)) {
            return NULL;
        }

        $input = $data[self::MUTATION_ENTRY];
        $object = new \stdClass();
        foreach ($given as $key => $value) {
            if (array_key_exists($key, $input)) {
                $object->$key = $input[$key];
            } else {
                $object->$key = NULL;
            }
        }

        return $object;
    }


    /**
     * @param string $operation
     * @param \Overblog\GraphQLBundle\Definition\Argument $args
     * @return mixed|null
     */
    public function mutate(string $operation, Argument $args) {
        switch ($operation) {
            case ArgsParser::CREATE_TYPE:
                return $this->insert($args);
            case ArgsParser::UPDATE_TYPE:
                return $this->update($args);
            case ArgsParser::DELETE_TYPE:
                return $this->delete($args);
            default:
                return NULL;
        }
    }
}