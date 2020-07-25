<?php


namespace kowi\lemon\resources;

use kowi\lemon\enums\DocumentType;
use kowi\lemon\objects\UploadDocument;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;

/**
 * Class AccountIndividual
 * @package kowi\lemon\resources
 */
class Document extends Resource
{
    /**
     * @var string Payment account ID.
     */
    public $accountId;
    /**
     * @var string Name of the document
     */
    public $name;
    /**
     * @var integer Type of document.
     * 0 = ID card (both sides in one file).
     * 1 = Proof of address.
     * 2 = Scan of a proof of IBAN.
     * 3 = Passport (European Union).
     * 4 = Passport (outside the European Union).
     * 5 = Residence permit (both sides in one file).
     * 7 = Official company registration document (Kbis extract or equivalent).
     * 11 = Driver licence (both sides in one file).
     * 12 = Status.
     * 13 = Selfie.
     * 14 = Others.
     * 21 = SDD mandate.
     */
    public $type;
    /**
     * @var string Byte array with the document. Encode in base 64 if necessary.
     */
    public $buffer;
    /**
     * @var integer This allows you to upload mandate document you signed yourself (with your own signing partner)
     * in order to validate a mandate ID you previously created with RegisterSddMandate.
     */
    public $sddMandateId;
    /**
     * @var UploadDocument
     */
    public $uploadDocument;

    /**
     * Rules established according to the documentation
     *
     * @see https://apidoc.lemonway.com/
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'type', 'buffer'], 'required', 'on' => [static::SCENARIO_CREATE]],
            [['name', 'buffer'], 'string'],
            [['sddMandateId'], 'integer'],
            [['type'], 'in', 'range' => DocumentType::getConstantsByName()],
            [['uploadDocument'], 'kowi\lemon\validators\ObjectValidator', 'targetClass' => 'kowi\lemon\objects\UploadDocument', 'on' => [static::SCENARIO_LOAD]],
        ]);
    }

    public function fields()
    {
        return parent::fields() + ['id'];
    }

    public function attributes()
    {
        return parent::attributes() + ['id'];
    }

    public function getId()
    {
        return isset($this->uploadDocument) ? $this->uploadDocument['id'] : null;
    }

    public function getTypeLabel()
    {
        return DocumentType::getLabel($this->type);
    }

    /**
     * @param bool $runValidation
     * @param null $attributes
     * @return bool
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function insert($runValidation = true, $attributes = null)
    {
        $this->scenario = static::SCENARIO_CREATE;

        $url = static::replace(static::resource()[$this->scenario], ['accountid' => $this->accountId]);

        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            Yii::info($this->getErrors(), __METHOD__);
            return false;
        }


        $attributes = $this->safeAttributes();
        $toArray = [];
        foreach ($attributes as $attribute) {
            if (isset($this->$attribute)) {
                $toArray[] = $attribute;
            }
        }
        $response = static::getLemonway()->createRequest()
            ->setMethod('POST')
            ->setUrl($url)
            ->setData($this->toArray($toArray))
            ->send();

        return $this->loadAttributes($response);
    }

    public static function resource()
    {
        return [
            static::SCENARIO_LOAD => '/v2/accounts/{accountid}/documents',
            static::SCENARIO_CREATE => '/v2/accounts/{accountid}/documents/upload',
        ];
    }
}