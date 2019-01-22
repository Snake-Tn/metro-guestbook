<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 15:28
 */

namespace Repository;


use Entity\User;
use Entity\UserRole;
use Exception\NotFoundException;
use Transformer\ArrayToUserTransformer;

class UserRepository extends AbstractEntityRepository
{
    private $arrayToUserTransformer;

    public function __construct(
        ArrayToUserTransformer $arrayToUserTransformer,
        \PDO $connection
    )
    {
        $this->arrayToUserTransformer = $arrayToUserTransformer;
        parent::__construct($connection);
    }

    public function fetchById(string $id): User
    {
        $statement = $this->getConnection()->prepare(
            "SELECT `u`.`id`, `u`.`login`, `u`.`password_hash`, `u`.`role_id`, `ur`.`code` AS `role_code` FROM `user` AS `u` 
                    INNER JOIN `user_role` AS `ur` ON `ur`.`id`=`u`.`role_id`
                    WHERE `u`.`id`=:id"
        );
        $statement->bindValue(":id", $id);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw new NotFoundException(sprintf("user having [login=%s] not found", $login));
        }
        return $this->arrayToUserTransformer->transform($raw);
    }

    public function fetchByLogin(string $login): User
    {
        $statement = $this->getConnection()->prepare(
            "SELECT `u`.`id`, `u`.`login`, `u`.`password_hash`, `u`.`role_id`, `ur`.`code` AS `role_code` FROM `user` AS `u` 
                    INNER JOIN `user_role` AS `ur` ON `ur`.`id`=`u`.`role_id`
                    WHERE `u`.`login`=:login"
        );
        $statement->bindValue(":login", $login);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw new NotFoundException(sprintf("user having [login=%s] not found", $login));
        }
        return $this->arrayToUserTransformer->transform($raw);
    }

}