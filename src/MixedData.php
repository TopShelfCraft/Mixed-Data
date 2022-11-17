<?php
namespace TopShelfCraft\MixedData;

use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;
use yii\base\Event;

class MixedData extends Plugin
{

	public bool $hasCpSection = false;

    public bool $hasCpSettings = false;

	public string $schemaVersion = '3.0.0';

    public function init()
    {

        parent::init();

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = MixedDataField::class;
            }
        );

    }

}
