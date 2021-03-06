<?php

/*
 * Random Words Generator
 * Generated from Tural Rzakhanov
 *
 * */

namespace RandomWordsGenerator;

class MakeWords
{
    // Count words found
    private int $COUNT_WORDS = 1;

    // Length words minimum (Will skipped default)
    private $LENGTH_FROM = null;

    // Length words maximum (Will skipped default)
    private $LENGTH_TO = null;

    // Data file path
    private string $DATA_FILE = 'en_EN';

    // Collect specific word piece
    private $WORD_PART = null;

    // If need only unique words
    private $UNIQUE_WORDS = false;


    /*
     * Change words count
     * */
    public function count(int $num = 1): MakeWords
    {
        $this->COUNT_WORDS = $num;
        return $this;
    }


    /*
    * Change location
     *
    * */
    public function location(string $location = 'az_AZ'): MakeWords
    {
        $this->DATA_FILE = $location;
        return $this;
    }

    /*
     * Get words only length than
     *
     * */
    public function fromLength(int $limit = 1): MakeWords
    {
        $this->LENGTH_FROM = $limit;
        return $this;
    }


    /*
     * Get words only length less
     *
     * */
    public function toLength(int $limit = 1): MakeWords
    {
        $this->LENGTH_TO = $limit;
        return $this;
    }

    /*
    * List words contain specific part
    *
    * */
    public function search(string $wordPart = null): MakeWords
    {
        $this->WORD_PART = $wordPart;
        return $this;
    }

    /*
     * Get only unique words
     *
     * */
    public function uniqueWords(bool $set = true): MakeWords
    {
        $this->UNIQUE_WORDS = $set;
        return $this;
    }


    /**
     * Generate random words
     * @throws \Exception
     */
    public function generate(): array
    {
        if (file_exists(($path = __DIR__ . '/db/' . $this->DATA_FILE . '.dat'))) {
            if (($data = explode(' ', file_get_contents($path)))
                && ($collectData = self::collaborate($data))) {

                $count = 0;
                $result = [];

                while (true) {
                    $count++;

                    $found = trim($collectData[array_rand($collectData)]);
                    if ($count == $this->COUNT_WORDS + 1) break;
                    if ($this->UNIQUE_WORDS && in_array($found,$result)) {
                        continue;
                    }
                    $result[] = $found;
                }
                return $result;
            }

        } else {

            throw new \Exception('DB location file not exits !');
        }
        return [];
    }

    /*
     * Collect usable data
     * */
    private function collaborate($data): array
    {
        $result = [];
        foreach ($data as $word) {
            $length = mb_strlen($word);

            if ($this->LENGTH_FROM && $this->LENGTH_FROM > $length) continue;
            if ($this->LENGTH_TO && $this->LENGTH_TO < $length) continue;
            if ($this->WORD_PART && mb_strpos($word, $this->WORD_PART) === false) continue;

            if (!preg_match('/[A-z0-9.\'\-]+/i', $word)) continue;
            $result[] = $word;
        }
        return $result;
    }

}