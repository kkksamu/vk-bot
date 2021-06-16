<?php

namespace VkBot;

class Notes
{
    public static function get (int $user_id, int $note_id = null): ?array
    {
        $notes = file_exists ($file = __DIR__ .'/../notes.json') ? 
            json_decode (file_get_contents ($file), true) : [];

        if ($note_id === null)
        {
            if (!isset ($notes[$user_id]))
                return [];

            foreach ($notes[$user_id] as &$note)
                $note = [
                    'note' => urldecode ($note['note']),
                    'caption' => $note['caption'] !== null ? urldecode ($note['caption']) : null
                ];

            return $notes[$user_id];
        }

        else return !isset ($notes[$user_id][$note_id]) ? null : 
        [
            'note' => urldecode ($notes[$user_id][$note_id]['note']),
            'caption' => $notes[$user_id][$note_id]['caption'] !== null ? urldecode ($notes[$user_id][$note_id]['caption']) : null
        ];
    }

    public static function add (int $user_id, string $note, string $caption = null): void
    {
        $notes = file_exists ($file = __DIR__ .'/../notes.json') ? 
            json_decode (file_get_contents ($file), true) : [];

        $notes[$user_id][] = [
            'note' => urlencode ($note),
            'caption' => $caption !== null ? urlencode ($caption) : null
        ];
        
        file_put_contents ($file, json_encode ($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    
    public static function remove (int $user_id, int $note_id): void
    {
        $notes = file_exists ($file = __DIR__ .'/../notes.json') ? 
            json_decode (file_get_contents ($file), true) : [];

        unset ($notes[$user_id][$note_id]);

        file_put_contents ($file, json_encode ($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
