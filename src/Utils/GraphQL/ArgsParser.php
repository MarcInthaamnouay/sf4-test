<?php
/**
 * Created by PhpStorm.
 * User: marcintha
 * Date: 10/12/2018
 * Time: 11:24
 */

namespace App\Utils\GraphQL;


use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;

/**
 * Class ArgsParser
 *
 * @package App\Utils\GraphQL
 */
class ArgsParser
{
    public const CREATE_TYPE = "create";
    public const DELETE_TYPE = "delete";
    public const UPDATE_TYPE = "update";

    /**
     * @param \Overblog\GraphQLBundle\Definition\Argument $args
     * @param array $wanted
     * @return array|NULL
     */
    static function parseArguments(Argument $args, array $wanted) {
        $filtered = array();

        foreach($wanted as $id) {
            if ($args->offsetExists($id)) {
                array_push($filtered, $args->offsetGet($id));
            }
        }

        $has = count($filtered);
        if (!$has) {
            return NULL;
        }

        return $filtered;
    }

    /**
     * @param string $fieldName
     * @return array
     */
    static function parseMutationArgs(string $fieldName) {
        $args = preg_split('/(?=[A-Z])/',$fieldName);

        if (!isset($args)) {
            throw new UserError(sprintf("Unable to parse the arguments of the mutation %s", $fieldName));
        }

        $mutationType = strtolower($args[0]);
        if ($mutationType === ArgsParser::CREATE_TYPE) {
            return [
                'operation' => ArgsParser::CREATE_TYPE,
                'target' => $args[1]
            ];
        }

        if ($mutationType === ArgsParser::UPDATE_TYPE) {
            return [
                'operation' => ArgsParser::UPDATE_TYPE,
                'target' => $args[1]
            ];
        }

        return [
            'operation' => ArgsParser::DELETE_TYPE,
            'target' => $args[1]
        ];
    }
}