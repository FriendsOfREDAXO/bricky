<?php

$fe_output[] = '<div class="container">
    <div class="row">';

switch ($gridOutput) {

    case '12':
        $fe_output[] = '
        <div class="col-xs-12">
            ' . $htmlContent[1] . '
        </div>' . PHP_EOL;
        break;

    case '6-6':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '4-4-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[2] . '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[3] . '
        </div>' . PHP_EOL;
        break;

    case '3-3-3-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $htmlContent[2] . '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $htmlContent[3] . '
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            ' . $htmlContent[4] . '
        </div>' . PHP_EOL;
        break;

    case '6-3-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[2] . '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[3] . '
        </div>' . PHP_EOL;
        break;

    case '3-6-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[2] . '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[3] . '
        </div>' . PHP_EOL;
        break;

    case '3-3-6':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[2] . '
        </div>
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[3] . '
        </div>' . PHP_EOL;
        break;


    case '10-2':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-10">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-2">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '9-3':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-9">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;
        
    case '8-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-8">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '7-5':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-7">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-5">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '6-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-6">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '6-4':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-5">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-7">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '4-8':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-4">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-8">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '3-9':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-3">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-9">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;

    case '2-10':
        $fe_output[] = '
        <div class="col-xs-12 col-sm-2">
            ' . $htmlContent[1] . '
        </div>
        <div class="col-xs-12 col-sm-10">
            ' . $htmlContent[2] . '
        </div>' . PHP_EOL;
        break;
}

$fe_output[] = '</div>
</div>';