<?php

namespace App\Lemon\Publishers\Resources\Actions\BindAppPackage;

interface BindFileFormatInterface
{
    public function getOpeningBind();

    public function getClosingBind();

    public function getContent();
    public function getContentSpacing();
    public function getOpenAndCloseSpacing();
    public function getTarget();
    public function getPath();
}
