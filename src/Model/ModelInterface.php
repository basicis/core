<?php
namespace Basicis\Model;

use \Doctrine\ORM\EntityManager;

/**
 * ModelInteface class
 */
interface ModelInterface
{
    public function save() : Model;
    public function delete(): Bool;
    public function getCreated() : \DateTime;
    public function setCreated(string $created = null): Model;
    public function getUpdated() : \DateTime;
    public function setUpdated(string $updated = null): Model;
    public static function getManager() : ?EntityManager;
    public static function findBy(array $findBy = []) : ?Array;
    public static function findOneBy(array $findOneBy = []) : ?Model;
    public static function find(int $id) : ?Model;
    public static function all() : ?array;
}
