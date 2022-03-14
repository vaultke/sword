<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

 /**
 *@OA\Schema(
 *  schema="<?= $className ?>",
<?php foreach ($properties as $property => $data): 
    $label = \yii\helpers\Inflector::camel2words($property);
?>
 *  @OA\Property(property="<?=$property?>", type="<?=$data['type']=='int'?'integer':rtrim($data['type'],'|null')?>",title="<?=ucfirst(str_replace('_',' ',$property))?>", example="<?=$data['type']=='int'?'integer':rtrim($data['type'],'|null')?>"),
<?php endforeach; ?>
 * )
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * @var string the name of the column storing encrypted row ID
     */

    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
    public function fields()
    {
        return  [
        <?php foreach ($properties as $property => $data): 
            $field="'".$property."'";
            if($property == 'status'){ $tag = "$";
                $field = "'recordStatus'=>function(".$tag."model){
                        if(".$tag."model->is_deleted){
                            return ".$tag."this->loadStatus(8);
                        }else{
                            return ".$tag."this->loadStatus(".$tag."model->status);
                        }
            }";
            } ?>
    <?= "{$field}," . "\n" ?>
        <?php endforeach; ?>];
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }
    public static function find()
    {
        if(Yii::$app->user->can('<?=strtolower($_ENV['APP_CONTEXT'].'_'.$className.'_view-deleted')?>')){
            return parent::find();
        }else{
            return parent::find()->andWhere(['=','is_deleted', false]);
        }
    }

    
<?php foreach ($relations as $name => $relation): ?>

    /**
     * Gets query for [[<?= $name ?>]].
     *
     * @return <?= $relationsClassHints[$name] . "\n" ?>
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }   
    
<?php endif; ?>
}
