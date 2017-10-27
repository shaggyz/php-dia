<?php

namespace PhpDia\Dia;

interface RenderItem
{
    /**
     * @return string
     */
    public function render() : string;
}