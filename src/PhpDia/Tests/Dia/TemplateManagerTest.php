<?php

namespace PhpDia\Tests\Dia;

use PhpDia\Dia\TemplateManager;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    public function testRender()
    {
        $templateManager = TemplateManager::create();

        $result = $templateManager->render('test', [
            'data' => 'irrelevant'
        ]);

        $this->assertEquals(
            "Hi i'm a variable with data: irrelevant.",
            $result
        );
    }
}