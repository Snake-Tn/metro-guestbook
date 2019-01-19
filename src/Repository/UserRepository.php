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

class UserRepository extends AbstractEntityRepository
{

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

        return new User(
            $raw['id'],
            $raw['login'],
            $raw['password_hash'],
            new UserRole(
                $raw['role_id'],
                $raw['role_code']
            )
        );
    }

}