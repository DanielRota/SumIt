<?php

class ExposeTextApi
{
    function fetchVideoSubtitles($url)
    {
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParameters);

            if (isset($queryParameters['v'])) {
                $video_id = $queryParameters['v'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://youtube-subtitles-captions-downloader.p.rapidapi.com/ytmp3/ytmp3/subtitles/?url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D" . $video_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: youtube-subtitles-captions-downloader.p.rapidapi.com",
                "X-RapidAPI-Key: ..."
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result =  json_decode($response)->data;
            $result = str_replace(array('"', "'", "\n"), '', $result);
            return $result;
        }
    }

    function fetchUrlSummary($url, $percentage)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://text-summarize-pro.p.rapidapi.com/summarizeFromUrl",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "url=" . $url . "&percentage=" . $percentage,
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: text-summarize-pro.p.rapidapi.com",
                "X-RapidAPI-Key: ...",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response)->summary;
            $result = str_replace(array('"', "'", "\n"), '', $result);
            return $result;
        }
    }
    function fetchTextSummary($text)
    {
        $text = str_replace(array('"', "'", "\n"), '', $text);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://summarize-texts.p.rapidapi.com/pipeline",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'input' => $text
            ]),
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: summarize-texts.p.rapidapi.com",
                "X-RapidAPI-Key: ...",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response)->output[0]->text;
            $result = str_replace(array('"', "'", "\n"), '', $result);
            return $result;
        }
    }
}
