<?php
declare (strict_types=1);

namespace Slim\Models;

use Slim\Kernel\Database;
use TypeError;

class Product extends ModelBase implements ModelInterface
{
    public string $uuid;
    public string $display_name;
    public int $cost_value;
    public int $sell_value;
    public int $remain_amount;

    use ModelUtils;

    public function checkReady(): bool
    {
        return isset($this->uuid);
    }

    public function load(Database $db_instance, $filter): ModelInterface
    {
        if (!is_string($filter)) {
            throw new TypeError();
        }
        $sql = "SELECT `uuid`, `display_name`, `cost_value`, `sell_value`, `remain_amount` FROM `products` WHERE `uuid` = ?";
        $stmt = $db_instance->getClient()->prepare($sql);
        $stmt->execute([$filter]);
        $this->loadResult($this, $stmt);
        return $this;
    }

    public function reload(Database $db_instance): ModelInterface
    {
        return $this->load($db_instance, $this->uuid);
    }

    public function create(Database $db_instance): bool
    {
        $sql = "INSERT INTO `products`(`uuid`, `display_name`, `cost_value`, `sell_value`, `remain_amount`) VALUES (:uuid, :display_name, :cost_value, :sell_value, :remain_amount)";
        $stmt = $db_instance->getClient()->prepare($sql);
        $db_instance->bindParamsFilled($stmt, $this->toArray());
        return $stmt->execute();
    }

    public function replace(Database $db_instance): bool
    {
        $sql = "UPDATE `products` SET `display_name` = :display_name, `cost_value` = :cost_value, `sell_value` = :sell_value, `remain_amount` = :remain_amount WHERE  `uuid` = :uuid";
        $stmt = $db_instance->getClient()->prepare($sql);
        $db_instance->bindParamsFilled($stmt, $this->toArray());
        return $stmt->execute();
    }

    public function destroy(Database $db_instance): bool
    {
        $sql = "DELETE FROM `products` WHERE `uuid` = ?";
        $stmt = $db_instance->getClient()->prepare($sql);
        return $stmt->execute([$this->uuid]);
    }
}
