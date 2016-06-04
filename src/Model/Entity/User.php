<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $username
 * @property string $password
 * @property string $matricula
 * @property string $email
 * @property string $role
 * @property string $cadastradoPor
 * @property \Cake\I18n\Time $dataDeCadastro
 * @property \Cake\I18n\Time $ultimaVezAtivo
 * @property \App\Model\Entity\UserLocal[] $user_locals
 * @property \App\Model\Entity\Local[] $locals
 * @property \App\Model\Entity\Alerta[] $alertas
 * @property \App\Model\Entity\BolsistasAlerta $bolsistas_alerta
 */
class User extends Entity
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

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password){
        if(strlen($password) > 0 ){
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    public function verifyUserLocal(User $bolsista, User $professor){

        foreach($bolsista->user_locals as $bolsistaLocal){
            foreach($professor->user_locals as $professorLocal){
                if($bolsistaLocal->local_codigo === $professorLocal->local_codigo){
                    return true;
                }
            }
        }

        return false;

    }

    public function checkPassword($value){
        
        if((new DefaultPasswordHasher)->check($value, $this->password)){
            return true;
        }

        return false;
    }
 
}
