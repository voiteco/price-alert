<?php

declare(strict_types=1);

namespace App\Service\Template;

class TemplateService
{
    /**
     * @var array
     */
    private $templates;

    /**
     * @param array $templates
     */
    public function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param string $template
     * @param array  $data
     *
     * @return string
     */
    public function process(string $template, array $data): string
    {
        $content = file_get_contents($this->templates[$template]);

        foreach ($data as $key => $value) {
            $key = sprintf('{%s}', $key);
            $content = str_replace($key, $value, $content);
        }

        return $content;
    }
}
