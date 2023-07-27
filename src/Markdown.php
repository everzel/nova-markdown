<?php

namespace Everzel\Markdown;

use Laravel\Nova\Fields\Field;

class Markdown extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'markdown';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * We set this to false by default.
     *
     * @var \Closure|bool
     */
    public $showOnIndex = false;

    /**
     * Construct the Markdown field.
     *
     * This is used to set some default meta information which the FormField
     * requires.
     */

    function __construct(
        $name,
        $attribute = null,
        callable $resolveCallback = null
    ) {
        parent::__construct($name, $attribute);

        $this->setDefaultMeta();

        return $this;
    }

    /**
     * Enable or disable uploads on this field.
     */

    public function uploads(bool $enabled = true)
    {
        if(config("nova-markdown.uploads")) {
            $this->withMeta([
                "uploads" => $enabled,
            ]);
        }

        return $this;
    }

    private function setDefaultMeta()
    {
        if(config("nova-markdown.uploads")) {
            $this->withMeta([
                "uploadEndpoint" => route("nova-markdown.uploads.store"),
                "maxSize" => config("nova-markdown.max-size"),
            ]);
        }

        if(config("nova-markdown.uploads-default-enabled")) {
            $this->withMeta([
                "uploads" => config("nova-markdown.uploads"),
            ]);
        }
    }
}
