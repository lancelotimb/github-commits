# Github Commits

Github Commits is a simple one-page Github commits visualizer made with Vuetify and pure PHP. 

## Decription

### Backend (PHP)

The backend is in charge of retrieving data from the Github API with the parameters provided by the user. 

The file `commits.php` is an endpoint that returns a JSON file containing the list of commits from the Github API, with a little extra information to facilitate the display later. The endpoint has to be called with user/repo parameters via a GET request, to select a specific repository. Bad request (400) errors are triggered if the parameters are not provided.

The calls to the Github API are made with a custom PHP object `GithubAPI`, which simply retrieves the data from Github and returns a PHP object.

### Frontend (Vue.js / Vuetify)

The frontend is in charge of displaying the data retrieved by the backend.

Vuetify is used for its simplicity and for its ability to create a very simple one-page app fastly. The libraries are stored in the `src/assets` folder, to ensure the independence of the app. A single file `index.php` takes care of all the display.

The commits are listed in a data-table, with a few important information such as commiter/author, date of commit, sha key and verification status. Each row can be expanded with a clic, to display more information about a commit. There are several links there that can redirect the user to Github website for further information.

Some committers/authors don't have a public profile on github, so for them, the profile picture displayed is the default one, stored in `src/assets/img`. The link to their profile is therefore disabled.

On top of the table, the user can select a specific repository by providing custom repo/user. A call to the endpoint `commits.php` is made when the user clicks on the "Search" button. By default, *linux* repository of user *torvalds* is displayed.


## How to Install/Run

### With Docker

A Dockerfile is provided on the root folder. It sets up an Apache server running PHP 7.0, and copies the content of the src folder to the `/var/www/html/` folder of the server.

To run it, enter the next lines in a terminal, in the root folder.

```bash
# build the docker image
docker build -t github-commits .

# run the docker container on this machine. Expose its internal
# port 80 to this machine's port 8080
docker run -d -p 8080:80 github-commits
```

The app should then by accessible from the url http://localhost:8080

### With a local Apache server (MAMP, WAMP, ...)

Just select the `src` folder as the root folder of your server, or copy the files under `src` to the root folder of your server.


## What to do next ?

There are a couple improvements that could be done with the app. Here are some ideas :
* _Better UI :_ The Vuetify base template is great for fast prototyping, but lacks of personalization features. We could use a different theme (pre-made or not) to offer a better and more adapted UI.
* _Filtering and Search :_ Filtering and Search functions on the backend (with the Github Search API) could be great to search for a particular commit. A simple filtering function could also be implemented in the frontend for faster results on cached data.
* _Favorite Repos :_ With a database, we could register users and store their favorite repos, that they could dispay instantly on login.


## Development

### What time did it take ?


* _Backend:_ around 1h
* _Basic Frontend:_ 2h30 (I had never worked with Vue, so it took me a bit of time to understand how to use it properly)
* _Better UI:_ I spent a small hour trying to improve the interface design 
* _Docker + Gitlab:_ I finally spent an hour adding the app into a Docker container, pushing the source code to Gitlab and writing the Readme/Bonus files.

5h30 in total.