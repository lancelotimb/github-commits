<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'github_API.php';
$api = new GithubAPI();


// Check if user and repo are provided
if(!isset($_GET['user'])) {
    http_response_code(400); // 400 : Bad Request
    echo json_encode(array("message" => "Unable to retrieve commits. You must provide the login of the user."));
}
else if(!isset($_GET['repo'])) {
    http_response_code(400); // 400 : Bad Request
    echo json_encode(array("message" => "Unable to retrieve commits. You must provide the name of the repo."));
}
else {
    $commits = $api->get_github_json("repos/" . $_GET['user'] . "/" . $_GET['repo'] . "/commits");
    $commits_new = [];

    foreach ($commits as $commit) {

        // Truncated message to display in commits list
        $commit["commit"]["message_short"] = mb_strimwidth($commit["commit"]["message"], 0, 80, "...");


        // Check if each commit has a committer and author profile associated
        if (!$commit["committer"]["login"]) {
            $commit["committer"]["login"] = $commit["commit"]["committer"]["name"];
            $commit["commit"]["committer"]["has_profile"] = false;
        }
        else {
            $commit["commit"]["committer"]["has_profile"] = true;
        }

        if (!$commit["author"]["login"]) {
            $commit["author"]["login"] = $commit["commit"]["author"]["name"];
            $commit["commit"]["author"]["has_profile"] = false;
        }
        else {
            $commit["commit"]["author"]["has_profile"] = true;
        }

        array_push($commits_new, $commit);
    }

    http_response_code(200); // 200 : OK
    echo json_encode($commits_new);
}

?>