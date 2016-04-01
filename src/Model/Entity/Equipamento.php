<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipamento Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $tombo
 * @property string $status
 * @property string $codLocal
 * @property string $dataCompra
 * @property string $fornecedor
 * @property string $modelo
 * @property string $responsavel
 * @property int $tipo
 */
class Equipamento extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
