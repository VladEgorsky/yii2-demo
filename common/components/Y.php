<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Y - Helper
 * @package backend\components
 */
class Y
{
    /**
     * @param $value
     * @param bool $exit
     * @throws \yii\base\ExitException
     */
    public static function dump($value, $exit = true)
    {
        echo '<pre>';
        print_r($value);
        echo '</pre>';

        if ($exit) {
            Yii::$app->end();
        }
    }

    /**
     * @param $model
     * @return array
     */
    public static function getModelErrorsAsOneDimensionalArray($model)
    {
        $ret = [];

        foreach ($model->errors as $errors) {
            $ret = array_merge($ret, $errors);
        }

        return $ret;
    }

    public static function getModelErrorsAsStrings($model, $glue = '<br />')
    {
        $arr = static::getModelErrorsAsOneDimensionalArray($model);
        return implode($glue, $arr);
    }

    public static function getBoolValueAsCheckboxIcon($value)
    {
        return $value
            ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>'
            : '<i class="fa fa-square-o" aria-hidden="true"></i>';
    }

    /**
 * @param $value integer
     * @param $format null|string
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getIntegerAsDate($value, $defaultValue = '', $format = null)
    {
        return (!is_integer($value) || $value <= 0)
            ? $defaultValue
            : \Yii::$app->formatter->asDate($value, $format);
    }

    /**
     * @param $ids [1,2,3,4,5]
     * @param $constants [John,25]
     * @return array        [[1,John,25], [2,John,25], ...]
     */
    public static function getRowsForBatchInsert($ids, $constants)
    {
        $ret = [];
        foreach ($ids as $id) {
            $ret[] = array_merge([$id], $constants);
        }

        return $ret;
    }


    public static function getTinyMceWidget($activeForm, $model, $attribute, $options = [], $clientOptions = [])
    {
        $iniOptions = [
            'rows' => 20,
            'placeholder' => true,
            'style' => 'visibility: hidden;',
        ];

        $iniClientOptions = [
            'menubar' => true,
            'statusbar' => true,
            'plugins'                       => [
                "advlist autolink lists link image charmap preview hr anchor pagebreak placeholder",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
            ],
            'noneditable_noneditable_class' => 'fa',
            'extended_valid_elements'       => 'span[class|style]',
            'toolbar1'                      => "undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            'toolbar2'                      => "print preview media | forecolor backcolor | codesample",
            'file_picker_types'             => 'file image media',
            'relative_urls'                 => false,
            'remove_script_host'            => true,
            'convert_urls'                  => true,
//            'media_url_resolver'            => new JsExpression('function (data, resolve) {
//                if (data.url.indexOf("youtube") !== -1 || data.url.indexOf("vimeo") !== -1) {
//                    resolve({html: ""});
//                } else {
//                    var embedHtml = \'<iframe src="\' + data.url + \'"></iframe>\';
//                    resolve({html: embedHtml});
//                }
//            }'),
            'setup'                         => new JsExpression('function (ed) {
                ed.on("Init", function(ed) {
                    jQuery(\'.mceEditor\').show();
                });
            }'),
        ];

        /** @var $activeForm \yii\widgets\ActiveForm */
        return $activeForm->field($model, $attribute)->widget(\dominus77\tinymce\TinyMce::class, [
            'options' => ArrayHelper::merge($iniOptions, $options),
            'clientOptions' => ArrayHelper::merge($iniClientOptions, $clientOptions),
            'fileManager' => [
                'class' => \dominus77\tinymce\components\MihaildevElFinder::class,
            ],
            //
        ]);
    }
    /**
     * @param int $offset
     * @param null $timestamp
     * @return false|int
     */
    public static function dayStart($offset = 0, $timestamp = null)
    {
        $time = 'today';
        $timestamp = $timestamp ?: time();
        if ($offset < 0) {
            $time .= ' ' . $offset . 'days';
        } else {
            $time .= ' +' . $offset . 'days';
        }
        return strtotime($time, $timestamp);
    }

    /**
     * @param int $offset
     * @param null $timestamp
     * @return false|int
     */
    public static function dayEnd($offset = 0, $timestamp = null)
    {
        return strtotime('+1day', self::dayStart($offset, $timestamp)) - 1;
    }

    /**
     * @param $ip
     * @return int|string
     */
    public static function inet_aton($ip)
    {
        $ip = trim($ip);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) return 0;
        return sprintf("%u", ip2long($ip));
    }

    /**
     * @param $num
     * @return string
     */
    public static function inet_ntoa($num)
    {
        $num = trim($num);
        if ($num == "0") return "0.0.0.0";
        return long2ip(-(4294967295 - ($num - 1)));
    }


    public static function getSectionClassName(int $num, $suffix = '')
    {
        $prefix = 'section';
        $classesCount = 12;
        $glue = ($num >= 0 && $num < $classesCount) ? $num : $num % $classesCount;

        return $prefix . $glue . $suffix;
    }
}