<?php

namespace PhpDia\Dia;

class Document implements RenderItem
{
    public function render(): string
    {
        $templateManager = TemplateManager::create();
        return $templateManager->render('document');
    }
}