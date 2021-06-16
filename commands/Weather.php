<?php

namespace VkBot;

use ConsoleArgs\Command;

use VKAPI\VK;

return new Command ('погода', function () use ($API, $message)
{
    global $handlers;

    $handlers[$message['from_id']]['weather'] = function (array $message, VK $API, &$handlers) 
    {
        $city = match (mb_strtolower ($message['text']))
        {
            'пермь'       => 'Perm',
            'калининград' => 'Kaliningrad'
        };

        $weather = json_decode (file_get_contents ('http://api.weatherapi.com/v1/forecast.json?key=f125f80830e74c75a87172956211106&q='. $city .'&days=3'), true);

        $output = [
            'Погода в '. $weather['location']['name'] .', '. $weather['location']['country'] .':',
            '🌡️ Температура: '. $weather['current']['temp_c'] .' °C',
            '💨 Ветер: '. $weather['current']['wind_kph'] .' км/ч',
            '💡 Состояние: '. $weather['current']['condition']['text'],
            '',
            'Прогноз на следующие 3 дня:',
            ''
        ];
        
        foreach ($weather['forecast']['forecastday'] as $forecast)
        {
            $output[] = date ('l, F j:', $forecast['date_epoch']);
            $output[] = '';
            $output[] = '🌅 06:00 | 💡 '. $forecast['hour'][6]['condition']['text']  . ' 🌡️ '. $forecast['hour'][6]['temp_c']  .' °C 💨 '. $forecast['hour'][6]['wind_kph']  .' км/ч';
            $output[] = '☀️ 12:00 | 💡 '. $forecast['hour'][12]['condition']['text'] . ' 🌡️ '. $forecast['hour'][12]['temp_c'] .' °C 💨 '. $forecast['hour'][12]['wind_kph'] .' км/ч';
            $output[] = '🌇 18:00 | 💡 '. $forecast['hour'][18]['condition']['text'] . ' 🌡️ '. $forecast['hour'][18]['temp_c'] .' °C 💨 '. $forecast['hour'][18]['wind_kph'] .' км/ч';
            $output[] = '🌙 23:00 | 💡 '. $forecast['hour'][23]['condition']['text'] . ' 🌡️ '. $forecast['hour'][23]['temp_c'] .' °C 💨 '. $forecast['hour'][23]['wind_kph'] .' км/ч';
            $output[] = '';
        }; 

        $API->messages->send ([
            'peer_id'   => $message['peer_id'],
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'message'   => implode (PHP_EOL, $output)
        ]);

        unset ($handlers[$message['from_id']]['weather']);

        return false;
    };    

    $API->messages->send ([
        'peer_id'   => $message['peer_id'],
        'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
        'message'   => 'Выберите город: Пермь, Калининград'
    ]);
});
