<!DOCTYPE html>
<html>
<head>
    <title>GithubCommits</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="assets/css/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<div id="app">
    <v-app light>
        <v-content>

            <section>
                <v-container grid-list-md>
                    <v-layout row wrap>

                        <!-- Title Bar -->
                        <v-flex xs12 text-xs-center>
                            <v-card dark color="primary">
                                <v-card-text class="px-0">
                                    <h2 class="headline">Github Commits</h2>
                                    <span class="subheading">Enter a repo, a user, and let the magic happen !</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <!-- Custom Repo Search Bar -->
                        <v-flex xs12 mt-4>
                            <v-card>
                                <v-form v-model="valid">
                                    <v-layout row wrap>
                                        <v-flex xs5 class="px-4 py-2">
                                            <v-text-field v-model="user" label="User" required></v-text-field>
                                        </v-flex>
                                        <v-flex xs5 class="px-4 py-2">
                                            <v-text-field v-model="repo" label="Repository" required></v-text-field>
                                        </v-flex>
                                        <v-flex xs2 class="px-4 py-2">
                                            <v-btn v-on:click="newSearch">Search</v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-form>
                            </v-card>
                        </v-flex>


                        <!-- Commits List -->
                        <v-flex xs12 mt-4>
                            <v-card xs12>
                                <v-card-title>
                                    <h3>Commits List</h3>
                                </v-card-title>
                                <v-data-table hide-headers :headers="headers" :items="commits" item-key="sha" :rows-per-page-items="[10,50]" class="text-md-left">

                                    <!-- Commit Row -->
                                    <template slot="items" slot-scope="props">
                                        <tr @click="props.expanded = !props.expanded" :style="{cursor: 'pointer'}">
                                            <td>
                                                <v-layout row wrap align-center>
                                                    <v-flex xs1>
                                                        <a v-if="props.item.commit.committer.has_profile == true" v-bind:href="props.item.committer.html_url">
                                                            <v-avatar slot="activator" size="36px">
                                                                <img v-bind:src="props.item.committer.avatar_url" alt="Avatar">
                                                            </v-avatar>
                                                        </a>
                                                        <a v-else-if="props.item.commit.author.has_profile == true" v-bind:href="props.item.author.html_url">
                                                            <v-avatar slot="activator" size="36px">
                                                                <img v-bind:src="props.item.author.avatar_url" alt="Avatar">
                                                            </v-avatar>
                                                        </a>
                                                        <v-avatar v-else slot="activator" size="36px">
                                                            <img src="assets/img/default_profile.png" alt="Avatar">
                                                        </v-avatar>
                                                    </v-flex>
                                                    <v-flex xs11>
                                                        <p class="my-2 text-truncate">
                                                            <span class="font-weight-bold mb-0">{{ props.item.commit.message_short }}</span><br/>
                                                            <span class="caption mt-0"><b>{{ props.item.committer.login }}</b> committed and <span v-if="props.item.committer.login != props.item.author.login"><b>{{ props.item.author.login }}</b></span> authored on {{ props.item.commit.committer.date }}</span>
                                                        </p>
                                                    </v-flex>
                                                </v-layout>
                                            </td>
                                            <td>
                                                <v-chip v-if="props.item.commit.verification.verified" label outline color="green">Verified</v-chip>
                                                <v-chip v-else label outline color="grey">Not Verified</v-chip>
                                            </td>
                                            <td class="font-weight-bold text-xs-right">
                                                <v-chip label color="blue lighten-2" text-color="white">
                                                    sha : {{ props.item.sha }}
                                                </v-chip>
                                            </td>
                                        </tr>
                                    </template>

                                    <!-- Commit Row Expand -->
                                    <template slot="expand" slot-scope="props">
                                        <v-card flat xs12>
                                            <v-layout row wrap align-left class="px-4 py-2 mb-2">
                                                <v-flex xs12 font-italic>
                                                    {{ props.item.commit.message }}
                                                </v-flex>
                                                <v-flex xs4>
                                                    <v-layout row wrap align-center>
                                                        <v-flex xs2>
                                                            <a v-if="props.item.commit.committer.has_profile == true" v-bind:href="props.item.committer.html_url">
                                                                <v-avatar slot="activator" size="36px">
                                                                    <img v-bind:src="props.item.committer.avatar_url" alt="Avatar">
                                                                </v-avatar>
                                                            </a>
                                                            <v-avatar v-else slot="activator" size="36px">
                                                                <img src="assets/img/default_profile.png" alt="Avatar">
                                                            </v-avatar>
                                                        </v-flex>
                                                        <v-flex xs10>
                                                            <p class="my-2">
                                                                <span class="font-weight-bold mb-0">{{ props.item.commit.committer.name }}</span> <span v-if="props.item.commit.committer.has_profile == true">(<a v-bind:href="props.item.committer.html_url">{{ props.item.committer.login }}</a>)</span><br/>
                                                                <span class="caption mt-0">Committed <span v-if="props.item.committer.login == props.item.author.login">and authored</span> on {{ props.item.commit.committer.date }}</span>
                                                            </p>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                                <v-flex v-if="props.item.committer.login != props.item.author.login" xs4>
                                                    <v-layout row wrap align-center>
                                                        <v-flex xs2>
                                                            <a v-if="props.item.commit.author.has_profile == true" v-bind:href="props.item.author.html_url">
                                                                <v-avatar slot="activator" size="36px">
                                                                    <img v-bind:src="props.item.author.avatar_url" alt="Avatar">
                                                                </v-avatar>
                                                            </a>
                                                            <v-avatar v-else slot="activator" size="36px">
                                                                <img src="assets/img/default_profile.png" alt="Avatar">
                                                            </v-avatar>
                                                        </v-flex>
                                                        <v-flex xs10>
                                                            <p class="my-2">
                                                                <span class="font-weight-bold mb-0">{{ props.item.commit.author.name }}</span> <span v-if="props.item.commit.author.has_profile == true">(<a v-bind:href="props.item.author.html_url">{{ props.item.author.login }}</a>)</span><br/>
                                                                <span class="caption mt-0">Authored on {{ props.item.commit.author.date }}</span>
                                                            </p>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                                <v-flex xs12>
                                                    <v-chip class="ma-0 font-weight-bold" label color="indigo darken-1" text-color="white">
                                                        node : {{ props.item.node_id }}
                                                    </v-chip>
                                                </v-flex>
                                                <v-flex xs12>
                                                    <v-chip class="ma-0 font-weight-bold" label color="indigo darken-1" text-color="white">
                                                        tree : {{ props.item.commit.tree.sha }}
                                                    </v-chip>
                                                </v-flex>
                                                <v-flex xs12>
                                                    <v-layout row wrap align-center>
                                                        <v-flex xs12>
                                                            Parents :
                                                        </v-flex>
                                                        <v-flex xs12 v-for="parent in props.item.parents">
                                                            <v-btn class="ma-0" outline color="indigo darken-1" v-bind:href="parent.html_url" target="_blank">
                                                                {{ parent.sha }}
                                                            </v-btn>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <v-btn class="ml-0" outline color="blue lighten-1" v-bind:href="props.item.commit.tree.url" target="_blank">
                                                                Tree JSON File
                                                            </v-btn>
                                                            <v-btn class="ml-0" outline color="blue lighten-1" v-bind:href="props.item.url" target="_blank">
                                                                Commit JSON File
                                                            </v-btn>
                                                            <v-btn class="ml-0" outline color="blue lighten-1" v-bind:href="props.item.html_url" target="_blank">
                                                                Commit on Github
                                                            </v-btn>
                                                            <v-btn class="ml-0" outline color="blue lighten-1" v-bind:href="props.item.comments_url" target="_blank">
                                                                {{ props.item.commit.comment_count }} comments
                                                            </v-btn>
                                                        </v-flex>
                                                    </v-layout>
                                        </v-card>
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-flex>


                    </v-layout>
                </v-container>
            </section>

        </v-content>
    </v-app>
</div>

<script src="assets/js/vue.js"></script>
<script src="assets/js/vuetify.js"></script>
<script src="assets/js/axios.min.js"></script>
<script>
    Number.prototype.padLeft = function(base,chr){
        var  len = (String(base || 10).length - String(this).length)+1;
        return len > 0? new Array(len).join(chr || '0')+this : this;
    }
</script>
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                title: 'Github Commits',
                headers: [
                    {text: 'Details', align: 'left', sortable: false, value: 'details'},
                    {text: 'Verification', align: 'left', sortable: false, value: 'verification'},
                    {text: 'Sha', align: 'left', sortable: false, value: 'sha'}
                ],
                commits: [],
                user: "torvalds",
                repo: "linux"
            }
        },
        mounted () {
            this.update();
        },
        methods: {
            newSearch: function (event) {
                this.update();
            },
            update() {
                // Fetch JSON File from server
                var base_url = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
                axios
                    .get(base_url + '/api/commits.php?user=' + this.user + '&repo=' + this.repo)
                    .then(response => {
                        // Set date format from UTC to locale
                        this.commits = response.data;
                        this.commits.forEach(function(el) {
                            let d = new Date(el.commit.committer.date);
                            el.commit.committer.date =
                                [(d.getMonth() + 1).padLeft(),
                                    d.getDate().padLeft(),
                                    d.getFullYear()].join('/') + ' ' +
                                [d.getHours().padLeft(),
                                    d.getMinutes().padLeft(),
                                    d.getSeconds().padLeft()].join(':');

                            d = new Date(el.commit.author.date);
                            el.commit.author.date =
                                [(d.getMonth() + 1).padLeft(),
                                    d.getDate().padLeft(),
                                    d.getFullYear()].join('/') + ' ' +
                                [d.getHours().padLeft(),
                                    d.getMinutes().padLeft(),
                                    d.getSeconds().padLeft()].join(':');
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    })
</script>
</body>
</html>