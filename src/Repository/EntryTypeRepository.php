<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 12:49
 */

namespace Repository;


use Entity\EntryType;

class EntryTypeRepository extends AbstractEntityRepository
{

    public function fetchAll()
    {
        $statement = $this->getConnection()->prepare(
            "SELECT * FROM `entity_type`"
        );

        $raws = $statement->fetchAll();
    }

    public function fetchByType($code): EntryType
    {
        $statement = $this->getConnection()->prepare(
            "SELECT id, code FROM `entry_type` WHERE code=:code"
        );
        $statement->bindValue(":code", $code);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw new \Exception(sprintf("entry type having [code=%s] not found", $code));
        }

        return new EntryType($raw['id'], $raw['type']);
    }


}