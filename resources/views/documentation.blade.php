<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vancouver Canucks Roster API: Documentation</title>

    <meta name="description" content="" />
    <meta name="author" content="Albert Rowett" />

    <link rel="stylesheet" href="css/documentation.css" />
</head>

<body>
    <div class="container">
        <h1>Vancouver Canucks Roster API</h1>
        <h2>API Documentation</h2>
        <section> <!-- Return all players -->
            <h3>Return all players - optionally filtered</h3>
            <ul>
                <li>
                    <p class="bold">URL:</p>
                    <p>/api/players</p>
                </li>
                <li>
                    <p class="bold">Method:</p>
                    <p><code class="code">GET</code></p>
                </li>
                <li>
                    <p class="bold">URL Params:</p>
                    <p class="bold">Required:</p>
                    <p>There are no required URL params</p>
                    <p class="bold">Optional:</p>
                    <ul>
                        <li><code class="code">removed=0|1</code> - 1 to return only players removed from roster (if unspecified, only active players returned, i.e. <code class="code">removed=0</code>)</li>
                        <li class="subsequent-bullet"><code class="code">position=string</code> - Filter results by position name</li>
                        <li class="subsequent-bullet"><code class="code">nationality=string</code> - Filter results by nationality name</li>
                    </ul>
                    <p class="bold">Example:</p>
                    <p><code class="code">/api/players?removed=1&position=Center&nationality=USA</code></p>
                </li>
                <li>
                    <p class="bold">Success Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 200 OK</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{
    <span class="json-key">"data"</span>: [
        {
            <span class="json-key">"id"</span>: <span class="json-int">1</span>,
            <span class="json-key">"name"</span>: <span class="json-str">"J. T. Miller"</span>,
            <span class="json-key">"jersey_number"</span>: <span class="json-int">9</span>,
            <span class="json-key">"date_of_birth"</span>: <span class="json-str">"1993-03-14"</span>,
            <span class="json-key">"position"</span>: {
                <span class="json-key">"name"</span>: <span class="json-str">"Center"</span>
            },
            <span class="json-key">"nationality"</span> {
                <span class="json-key">"name"</span>: <span class="json-str">"USA"</span>
            },
            <span class="json-key">"draft_team"</span>: {
                <span class="json-key">"team"</span>: {
                    <span class="json-key">"name"</span>: <span class="json-str">"New York Rangers"</span>
                }
            },
            <span class="json-key">"previous_teams"</span>: [
                {
                    <span class="json-key">"team"</span>: {
                        <span class="json-key">"name"</span>: <span class="json-str">"New York Rangers"</span>
                    }
                },
                {
                    <span class="json-key">"team"</span>: {
                        <span class="json-key">"name"</span>: <span class="json-str">"Tampa Bay Lightning"</span>
                    }
                }
            ]
        }
    ],
    <span class="json-key">"message"</span>: <span class="json-str">"Players successfully retrieved"</span>
}</code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Error Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 422 UNPROCESSABLE CONTENT</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{
    <span class="json-key">"message"</span>: <span class="json-str">"The removed field must be true or false. (and 2 more errors)"</span>,
    <span class="json-key">"errors"</span>: {
        <span class="json-key">"removed"</span>: [<span class="json-str">"The removed field must be true or false."</span>],
        <span class="json-key">"position"</span>: [<span class="json-str">"The selected position is invalid."</span>],
        <span class="json-key">"nationality"</span>: [<span class="json-str">"The selected nationality is invalid."</span>]
    }
}</code></pre>
                    </ul>
                    <p>OR</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 500 INTERNAL SERVER ERROR</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Unexpected error occurred" }</span></code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Sample Call:</p>
                    <ul>
                        <li><p><span class="bold">JavaScript</span> (<code class="code">fetch</code>):</p></li>
                        <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/players?removed=1&position=Center&nationality=USA'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'GET'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object-str">'Accept'</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                    </ul>
                </li>
            </ul>
        </section>
        <section> <!-- Return a specific player -->
            <h3>Return a specific player</h3>
            <p>Returns JSON data about a specific player. Also returns data for players removed from the roster, but not deleted.</p>
            <ul>
                <li>
                    <p class="bold">URL:</p>
                    <p>/api/players/{jersey_number}</p>
                </li>
                <li>
                    <p class="bold">Method:</p>
                    <p><code class="code">GET</code></p>
                </li>
                <li>
                    <p class="bold">URL Params:</p>
                    <p class="bold">Required:</p>
                    <p>There are no required URL params</p>
                    <p class="bold">Optional:</p>
                    <p>There are no optional URL params</p>
                    <p class="bold">Example:</p>
                    <p><code class="code">/api/players/9</code></p>
                </li>
                <li>
                    <p class="bold">Success Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 200 OK</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{
    <span class="json-key">"data"</span>: {
        <span class="json-key">"id"</span>: <span class="json-int">9</span>,
        <span class="json-key">"name"</span>: <span class="json-str">"J. T. Miller"</span>,
        <span class="json-key">"jersey_number"</span>: <span class="json-int">9</span>,
        <span class="json-key">"date_of_birth"</span>: <span class="json-str">"1993-03-14"</span>,
        <span class="json-key">"deleted_at"</span>: <span class="json-null">null</span>,
        <span class="json-key">"position"</span>: {
            <span class="json-key">"name"</span>: <span class="json-str">"Center"</span>
        },
        <span class="json-key">"nationality"</span>: {
            <span class="json-key">"name"</span>: <span class="json-str">"USA"</span>
        },
        <span class="json-key">"draft_team"</span>: {
            <span class="json-key">"team"</span>: {
                <span class="json-key">"name"</span>: <span class="json-str">"New York Rangers"</span>
            }
        },
        <span class="json-key">"previous_teams"</span>: [
            {
                <span class="json-key">"team"</span>: {
                    <span class="json-key">"name"</span>: <span class="json-str">"New York Rangers"</span>
                }
            },
            {
                <span class="json-key">"team"</span>: {
                    <span class="json-key">"name"</span>: <span class="json-str">"Tampa Bay Lightning"</span>
                }
            }
        ]
    },
    <span class="json-key">"message"</span>: <span class="json-str">"Player successfully retrieved"</span>
}</code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Error Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 404 NOT FOUND</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player with jersey number 9 not found" }</span></code></pre>
                    </ul>
                    <p>OR</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 500 INTERNAL SERVER ERROR</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Unexpected error occurred" }</span></code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Sample Call:</p>
                    <ul>
                        <li><p><span class="bold">JavaScript</span> (<code class="code">fetch</code>):</p></li>
                        <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/players/9'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'GET'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object-str">'Accept'</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                    </ul>
                </li>
            </ul>
        </section>
        <section> <!-- Add a player -->
            <h3>Add a player</h3>
            <p>Adds a new player's data.</p>
            <ul>
                <li>
                    <p class="bold">URL:</p>
                    <p>/api/players</p>
                </li>
                <li>
                    <p class="bold">Method:</p>
                    <p><code class="code">POST</code></p>
                </li>
                <li>
                    <p class="bold">Headers:</p>
                    <ul>
                        <li><p><span class="bold">Content-Type:</span> application/json</p></li>
                        <li><p><span class="bold">Accept:</span> application/json</p></li>
                    </ul>
                </li>
                <li>
                    <p class="bold">URL Params:</p>
                    <p>None</p>
                </li>
                <li>
                    <p class="bold">Body Data Params:</p>
                    <p class="italic">All parameters must be sent as JSON with the correct headers.</p>
                    <table>
                        <tr>
                            <th>Parameter Name</th>
                            <th>Data Type</th>
                            <th>Description</th>
                            <th>Required?</th>
                            <th>Constraints</th>
                            <th>Example</th>
                        </tr>
                        <tr>
                            <td><code class="code">name</code></td>
                            <td><code class="code">string</code></td>
                            <td>The player's name</td>
                            <td>Required</td>
                            <td>Max length: 255</td>
                            <td><code class="code">'J. T. Miller'</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">jerseyNumber</code></td>
                            <td><code class="code">integer</code></td>
                            <td>The player's jersey number</td>
                            <td>Required</td>
                            <td>Between 1 and 99; must not already be assigned</td>
                            <td><code class="code">9</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">dateOfBirth</code></td>
                            <td><code class="code">string</code></td>
                            <td>The player's date of birth</td>
                            <td>Required</td>
                            <td>Date format: yyyy-mm-dd</td>
                            <td><code class="code">'1993-03-14'</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">position</code></td>
                            <td><code class="code">string</code></td>
                            <td>The player's primary position</td>
                            <td>Required</td>
                            <td>Must be one of <code class="code">'Goaltender'</code>, <code class="code">'Defense'</code>, <code class="code">'Center'</code>, <code class="code">'Left wing'</code> or <code class="code">'Right wing'</code></td>
                            <td><code class="code">'Center'</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">nationality</code></td>
                            <td><code class="code">string</code></td>
                            <td>The name of the nation the player represents</td>
                            <td>Required</td>
                            <td>Max length: 255</td>
                            <td><code class="code">'USA'</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">draftTeam</code></td>
                            <td><code class="code">string</code></td>
                            <td>The name of the player's draft team (omit or set to <code class="code">null</code> if undrafted)</td>
                            <td>Optional</td>
                            <td>Max length: 255</td>
                            <td><code class="code">'New York Rangers'</code></td>
                        </tr>
                        <tr>
                            <td><code class="code">previousTeams</code></td>
                            <td><code class="code">array</code></td>
                            <td>The names of the teams the player has previously played for</td>
                            <td>Optional</td>
                            <td>Team names must be of type <code class="code">string</code> with max length: 255 and no repeats</td>
                            <td><code class="code">['New York Rangers', 'Tampa Bay Lightning']</code></td>
                        </tr>
                    </table>
                </li>
                <li>
                    <p class="bold">Success Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 201 CREATED</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player added"</span> }</code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Error Response:</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 422 UNPROCESSABLE CONTENT</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player with jersey number 9 not found"</span> }</code></pre>
                    </ul>
                    <p>OR</p>
                    <ul>
                        <li><p><span class="bold">Code:</span> 500 INTERNAL SERVER ERROR</p></li>
                        <p class="bold">Content:</p>
                        <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Unexpected error occurred"</span> }</code></pre>
                    </ul>
                </li>
                <li>
                    <p class="bold">Sample Call:</p>
                    <ul>
                        <li><p><span class="bold">JavaScript</span> (<code class="code">fetch</code>):</p></li>
                        <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class=js-argument>'/api/players'</span>, {
    <span class="js-object">method</span>: <span class="js-object-str">'POST'</span>,
    <span class="js-object">headers</span>: {
        <span class="js-object-str">'Content-Type'</span>: <span class="js-object-str">'application/json'</span>,
        <span class="js-object-str">'Accept'</span>: <span class="js-object-str">'application/json'</span>
    },
    <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>,
    <span class="js-object">body</span>: <span class="js-object">JSON</span>.<span class="js-method">stringify</span>({
        <span class="js-object-str">'name'</span>: <span class="js-object-str">'J. T. Miller'</span>,
        <span class="js-object-str">'jerseyNumber'</span>: <span class="js-object">9</span>,
        <span class="js-object-str">'dateOfBirth'</span>: <span class="js-object-str">'1993-03-14'</span>,
        <span class="js-object-str">'position'</span>: <span class="js-object-str">'Center'</span>,
        <span class="js-object-str">'nationality'</span>: <span class="js-object-str">'USA'</span>,
        <span class="js-object-str">'draftTeam'</span>: <span class="js-object-str">'New York Rangers'</span>,
        <span class="js-object-str">'previousTeams'</span>: [
            <span class="js-object-str">'New York Rangers'</span>,
            <span class="js-object-str">'Tampa Bay Lightning'</span>
        ]
    })
})
    .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
    .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                    </ul>
                </li>
            </ul>
        </section>
    </div>
</body>

</html>