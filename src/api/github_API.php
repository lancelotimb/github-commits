<?php

class GithubAPI {

    const API_URL = "https://api.github.com/";

    function get_github_json($url) {
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP'
                ]
            ]
        ];

        $context = stream_context_create($opts);
        $content = file_get_contents(self::API_URL . $url, false, $context);
        return json_decode($content, true);
    }
}

?>