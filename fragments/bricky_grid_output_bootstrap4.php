<?php

$fe_output[] = '<div class="container">
    <div class="row">';

switch ($this->gridOutput) {

    case '12':
        $fe_output[] = '
        <div class="col-xs-12">
            ' . $this->htmlContent_1. '
        </div>' . PHP_EOL;
        break;

    case '6-6':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '4-4-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_2. '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_3. '
        </div>' . PHP_EOL;
        break;

    case '3-3-3-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $this->htmlContent_2. '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $this->htmlContent_3. '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $this->htmlContent_4. '
        </div>' . PHP_EOL;
        break;

    case '6-3-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_2. '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_3. '
        </div>' . PHP_EOL;
        break;

    case '3-6-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_2. '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_3. '
        </div>' . PHP_EOL;
        break;

    case '3-3-6':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_2. '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_3. '
        </div>' . PHP_EOL;
        break;


    case '10-2':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-10">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-2">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '9-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-9">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '8-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-8">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '7-5':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-7">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-5">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '6-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '6-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-5">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-7">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '4-8':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-4">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-8">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '3-9':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-9">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;

    case '2-10':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-2">
            ' . $this->htmlContent_1. '
        </div>
        <div class="col-xs-12 col-sm-10">
            ' . $this->htmlContent_2. '
        </div>' . PHP_EOL;
        break;
}

$fe_output[] = '</div>
</div>';

echo implode($fe_output);
