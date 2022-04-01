<?php
namespace topshelfcraft\MixedData;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Json;
use yii\db\Schema;

class MixedDataField extends Field
{

    /**
     * Returns the column type that this field should get within the content table.
     *
     * (This method will only be called if [[hasContentColumn()]] returns true.)
	 *
	 * @see \yii\db\QueryBuilder::getColumnType()
     *
     * @return string The column type.
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

	/**
     * Normalizes the field’s value for use.
     *
     * This method is called when the field’s value is first accessed from the element. For example, the first time
     * `entry.myFieldHandle` is called from a template, or right before [[getInputHtml()]] is called. Whatever
     * this method returns is what `entry.myFieldHandle` will likewise return, and what [[getInputHtml()]]’s and
     * [[serializeValue()]]’s $value arguments will be set to.
     *
     * @param array|string $value The raw field value (string or array from POST, or string from db)
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return string The prepared field value
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
    	return Json::decodeIfJson($value);
    }

    /**
     * Prepares the field’s value to be stored somewhere, like the content table or JSON-encoded in an entry revision table.
     *
     * Data types that are JSON-encodable are safe (arrays, integers, strings, booleans, etc).
     * Whatever this returns should be something [[normalizeValue()]] can handle.
     *
     * @param mixed $value The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
	 *
     * @return string The serialized field value
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return Json::encode($value);
    }

    /**
     * Returns the field’s input HTML.
     *
     * @param mixed $value The field’s value. This will either be the [[normalizeValue() normalized value]],
	 *     raw POST data (i.e. if there was a validation error), or null
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return string The input HTML.
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return "<textarea rows='12' name='{$this->handle}'>" . Json::encode($value) . "</textarea>";
    }

	/*
	 * Statics
	 */

	/**
	 * @inheritdoc
	 */
	public static function displayName(): string
	{
		return "Mixed Data (JSON)";
	}

}
