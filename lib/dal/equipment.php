<?php
require_once('db.php');

/**
 * Data-access for both `equipment` and `user_equipment` tables.
 */
class DAL_Equipment {
    public static function listByUserId($user_id, PDO $db) {
        $sql = <<<EOD
SELECT
    UE.user_equipment_id,
    E.equipment_id,
    E.equipment_name,
    UE.description,
    UE.manufacturer,
    UE.model,
    UE.product_year,
    UE.color
FROM
    user_equipment UE
    JOIN equipment E ON(UE.equipment_id = E.equipment_id)
WHERE
    user_id = :user_id
ORDER BY
    UE.created_dt
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('user_id'));
        return $stmt->fetchAll();
    }

    public static function fetchEquipmentTypes(PDO $db) {
        return $db->query('SELECT * FROM equipment')->fetchAll();
    }

    public static function updateEquipment($equipment, $user_id, PDO $db) {
        $sql = <<<EOD
UPDATE user_equipment
SET
    equipment_id = :equipment_id,
    description = :description,
    manufacturer = :manufacturer,
    model = :model,
    product_year = :product_year,
    color = :color,
    modified_dt = NOW()
WHERE
    user_id = :user_id
    AND user_equipment_id = :user_equipment_id
EOD;
        $stmt = $db->prepare($sql);

        $num_affected = 0;
        foreach ($equipment as $item) {
             $params = array_funnel_keys($item, ['user_equipment_id', 'equipment_id', 'description', 'manufacturer', 'model', 'product_year', 'color']);
             $params['user_id'] = $user_id;
             $stmt->execute($params);
             $num_affected += $stmt->rowCount();
        }
        return $num_affected;
    }

    public static function addUserEquipment($equipment, $user_id, PDO $db) {
        $sql = <<<EOD
INSERT INTO user_equipment (user_id, equipment_id, description, manufacturer, model, product_year, color)
VALUES
(:user_id, :equipment_id, :description, :manufacturer, :model, :product_year, :color)
EOD;
        $stmt = $db->prepare($sql);
        $params = array_funnel_keys($equipment, ['equipment_id', 'description', 'manufacturer', 'model', 'product_year', 'color']);
        $params['user_id'] = $user_id;
        $stmt->execute($params);
        return $db->lastInsertId();
    }

    public static function deleteUserEquipment($user_equipment_id, $user_id, PDO $db) {
        $sql = <<<EOD
DELETE FROM user_equipment
WHERE user_equipment_id = :user_equipment_id AND user_id = :user_id
EOD;
        $stmt = $db->prepare($sql);
        $stmt->execute(compact('user_equipment_id', 'user_id'));
        return $stmt->rowCount() > 0;
    }
}
