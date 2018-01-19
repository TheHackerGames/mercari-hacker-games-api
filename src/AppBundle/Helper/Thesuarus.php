<?php

namespace AppBundle\Helper;

class Thesuarus
{
    const THESUAURS_API_SPRINTF = 'https://api.datamuse.com/words?ml=%s';

    /**
     * Helper method to find simillar words to a word
     * - Used for enhancing matches between stems
     *
     * @param string $word
     * @param int $numberOfSimillar
     * @return string[]
     */
    public function getSimillarWords(string $word, int $numberOfSimillar = 5)
    {
        $apiUrl = sprintf(self::THESUAURS_API_SPRINTF, $word);

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $result = curl_exec($curl);
        $decodedResult = json_decode($result, true);

        if (count($decodedResult) < 5) {
            return [];
        }

        $matches = [];
        foreach ($decodedResult as $match) {

            if (isset($match['word'])) {
                $matches[] = $match['word'];
            }

            if (count($matches) === $numberOfSimillar) {
                return $matches;
            }
        }

        return $matches;
    }
}