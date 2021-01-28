<?php


namespace CuongDev\Larab\Abstraction\Library;


class Helper
{
    /**
     * @param $number
     * @param array $config Default is config for VNĐ (Việt Nam Đồng)
     * @return string
     */
    public function moneyFormat($number, $config = [])
    {
        $moneyConfig = [
            'currency'            => 'đ',
            'position'            => 'right',
            'has_space'           => false,
            'space'               => '',
            'decimal'             => 0,
            'decimal_separator'   => ',',
            'thousands_separator' => '.',
        ];

        $moneyConfig['currency'] = isset($config['currency']) ? $config['currency'] : 'đ';
        $moneyConfig['position'] = isset($config['position']) ? $config['position'] : 'right';
        $moneyConfig['has_space'] = isset($config['has_space']) ? $config['has_space'] : false;
        $moneyConfig['space'] = $moneyConfig['has_space'] ? ' ' : '';
        $moneyConfig['decimal'] = isset($config['decimal']) ? $config['decimal'] : 0;
        $moneyConfig['decimal_separator'] = isset($config['decimal_separator']) ? $config['decimal_separator'] : ',';
        $moneyConfig['thousands_separator'] = isset($config['thousands_separator']) ? $config['thousands_separator'] : '.';

        $formattedNumber = number_format(
            floatval($number),
            $moneyConfig['decimal'],
            $moneyConfig['decimal_separator'],
            $moneyConfig['thousands_separator']
        );

        if ($moneyConfig['position'] == 'right') {
            return $formattedNumber . $moneyConfig['space'] . $moneyConfig['currency'];
        } else {
            return $moneyConfig['currency'] . $moneyConfig['space'] . $formattedNumber;
        }
    }
}
