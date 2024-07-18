<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vancouver Canucks Roster API: Documentation</title>

    <meta name="description" content="" />
    <meta name="author" content="Albert Rowett" />

    <link rel="stylesheet" href="css/documentation.css" />

    <script defer src="js/documentation.js"></script>
</head>

<body>
    <div class="container">
        <h1>Vancouver Canucks Roster API</h1>
        <h2>API Documentation</h2>
        <section> <!-- Return all players -->
            <button class="collapsible"><h3>Return all players - optionally filtered</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Returns JSON data about all players, subject to optional filtering. If no filters are applied, all players on the roster will be returned.</p>
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
                        <p class="bold">Headers:</p>
                        <ul>
                            <li><p><span class="bold">Accept:</span> application/json</p></li>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">URL Params:</p>
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Values</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">removed</code></td>
                                <td class="center">boolean</td>
                                <td class="center">Optional</td>
                                <td>Enables retrieval of players removed from the roster</td>
                                <td>
                                    <code class="code">0</code> (default): Returns only players on the roster<br>
                                    <code class="code">1</code>: Returns only players removed from the roster
                                </td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">position</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>Filters players by position name</td>
                                <td>Must be one of <code class="code">Goaltender</code>, <code class="code">Defense</code>, <code class="code">Center</code>, <code class="code">Left wing</code> or <code class="code">Right wing</td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">nationality</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>Filters players by nationality name</td>
                                <td>Must be a saved nationality - see <span class="italic">Return all nationalities</span> to access this list</td>
                            </tr>
                        </table>
                        <p class="bold">Example:</p>
                        <p><code class="code">/api/players?removed=1&position=Center&nationality=USA</code></p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p>None</p>
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
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Unexpected error occurred"</span> }</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Sample Call:</p>
                        <ul>
                            <li><p><span class="bold">JavaScript</span> (<code class="code">fetch</code>):</p></li>
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/players?removed=1&position=Center&nationality=USA'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'GET'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Return a specific player -->
            <button class="collapsible"><h3>Return a specific player</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Returns JSON data about a specific player, including for players removed from the roster.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/players/{jerseyNumber}</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">GET</code></p>
                    </li>
                    <li>
                        <p class="bold">Headers:</p>
                        <ul>
                            <li><p><span class="bold">Accept:</span> application/json</p></li>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">URL Params:</p>
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Values</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Required</td>
                                <td>The jersey number of the player to return</td>
                                <td>1 to 99 (inclusive)</td>
                            </tr>
                        </table>
                        <p class="bold">Example:</p>
                        <p><code class="code">/api/players/9</code></p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p>None</p>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/players/9'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'GET'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Add a player -->
            <button class="collapsible"><h3>Add a player</h3><p class="symbol">+</p></button>
            <div class="content">
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
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Constraints</th>
                                <th>Example Value</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">name</code></td>
                                <td class="center">string</td>
                                <td class="center">Required</td>
                                <td>The player's name</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'J. T. Miller'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Required</td>
                                <td>The player's jersey number</td>
                                <td>Between 1 and 99 (inclusive); must not already be assigned</td>
                                <td><code class="code">9</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">dateOfBirth</code></td>
                                <td class="center">string</td>
                                <td class="center">Required</td>
                                <td>The player's date of birth</td>
                                <td>Date format: yyyy-mm-dd</td>
                                <td><code class="code">'1993-03-14'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">position</code></td>
                                <td class="center">string</td>
                                <td class="center">Required</td>
                                <td>The player's primary position</td>
                                <td>Must be one of <code class="code">'Goaltender'</code>, <code class="code">'Defense'</code>, <code class="code">'Center'</code>, <code class="code">'Left wing'</code> or <code class="code">'Right wing'</code></td>
                                <td><code class="code">'Center'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">nationality</code></td>
                                <td class="center">string</td>
                                <td class="center">Required</td>
                                <td>The name of the nation the player represents</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'USA'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">draftTeam</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The name of the player's draft team (omit or set as <code class="code">null</code> if the player is undrafted)</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'New York Rangers'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">previousTeams</code></td>
                                <td class="center">array</td>
                                <td class="center">Optional</td>
                                <td>The names of the teams the player has previously played for (omit or set as <code class="code">null</code> if the player has none)</td>
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
                            <pre class="code codeblock"><code>{
    <span class="json-key">"message"</span>: <span class="json-str">"The name field must be a string. (and 6 more errors)"</span>,
    <span class="json-key">"errors"</span>: {
        <span class="json-key">"name"</span>: [<span class="json-str">"The name field must be a string."</span>],
        <span class="json-key">"jerseyNumber"</span>: [<span class="json-str">"The jersey number field must be between 1 and 99."</span>],
        <span class="json-key">"dateOfBirth"</span>: [<span class="json-str">"The date of birth field must match the format Y-m-d."</span>],
        <span class="json-key">"position"</span>: [<span class="json-str">"The selected position is invalid."</span>],
        <span class="json-key">"nationality"</span>: [<span class="json-str">"The nationality field must be a string."</span>],
        <span class="json-key">"draftTeam"</span>: [<span class="json-str">"The draft team field must be a string."</span>],
        <span class="json-key">"previousTeams"</span>: [<span class="json-str">"The previous teams field must be an array."</span>]
    }
}</code></pre>
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
        <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
    },
    <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>,
    <span class="js-object">body</span>: <span class="js-object">JSON</span>.<span class="js-method">stringify</span>({
        <span class="js-object">name</span>: <span class="js-object-str">'J. T. Miller'</span>,
        <span class="js-object">jerseyNumber</span>: <span class="js-object">9</span>,
        <span class="js-object">dateOfBirth</span>: <span class="js-object-str">'1993-03-14'</span>,
        <span class="js-object">position</span>: <span class="js-object-str">'Center'</span>,
        <span class="js-object">nationality</span>: <span class="js-object-str">'USA'</span>,
        <span class="js-object">draftTeam</span>: <span class="js-object-str">'New York Rangers'</span>,
        <span class="js-object">previousTeams</span>: [
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
            </div>
        </section>
        <section> <!-- Update a player -->
            <button class="collapsible"><h3>Update a player</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Updates an existing player's data.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/players/{jerseyNumber}</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">PUT</code></p>
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
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Values</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Required</td>
                                <td>The jersey number of the player to update</td>
                                <td>1 to 99 (inclusive)</td>
                            </tr>
                        </table>
                        <p class="bold">Example:</p>
                        <p><code class="code">/api/players/9</code></p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p class="italic">All parameters must be sent as JSON with the correct headers.</p>
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Data Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Constraints</th>
                                <th>Example Value</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">name</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The player's updated name</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'J. T. Miller'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Optional</td>
                                <td>The player's updated jersey number</td>
                                <td>Between 1 and 99 (inclusive); must not already be assigned</td>
                                <td><code class="code">9</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">dateOfBirth</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The player's updated date of birth</td>
                                <td>Date format: yyyy-mm-dd</td>
                                <td><code class="code">'1993-03-14'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">position</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The player's updated primary position</td>
                                <td>Must be one of <code class="code">'Goaltender'</code>, <code class="code">'Defense'</code>, <code class="code">'Center'</code>, <code class="code">'Left wing'</code> or <code class="code">'Right wing'</code></td>
                                <td><code class="code">'Center'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">nationality</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The updated name of the nation the player represents</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'USA'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">draftTeam</code></td>
                                <td class="center">string</td>
                                <td class="center">Optional</td>
                                <td>The updated name of the player's draft team (set as <code class="code">null</code> to update to undrafted)</td>
                                <td>Max length: 255</td>
                                <td><code class="code">'New York Rangers'</code></td>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">previousTeams</code></td>
                                <td class="center">array</td>
                                <td class="center">Optional</td>
                                <td>The updated names of the teams the player has previously played for (set as <code class="code">null</code> to update to none)</td>
                                <td>Team names must be of type <code class="code">string</code> with max length: 255 and no repeats</td>
                                <td><code class="code">['New York Rangers', 'Tampa Bay Lightning']</code></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <p class="bold">Success Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 200 OK</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player updated"</span> }</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Error Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 404 NOT FOUND</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player with jersey number 9 not found"</span> }</code></pre>
                        </ul>
                        <p>OR</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 422 UNPROCESSABLE CONTENT</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{
    <span class="json-key">"message"</span>: <span class="json-str">"The name field must be a string. (and 6 more errors)"</span>,
    <span class="json-key">"errors"</span>: {
        <span class="json-key">"name"</span>: [<span class="json-str">"The name field must be a string."</span>],
        <span class="json-key">"jerseyNumber"</span>: [<span class="json-str">"The jersey number field must be between 1 and 99."</span>],
        <span class="json-key">"dateOfBirth"</span>: [<span class="json-str">"The date of birth field must match the format Y-m-d."</span>],
        <span class="json-key">"position"</span>: [<span class="json-str">"The selected position is invalid."</span>],
        <span class="json-key">"nationality"</span>: [<span class="json-str">"The nationality field must be a string."</span>],
        <span class="json-key">"draftTeam"</span>: [<span class="json-str">"The draft team field must be a string."</span>],
        <span class="json-key">"previousTeams"</span>: [<span class="json-str">"The previous teams field must be an array."</span>]
    }
}</code></pre>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class=js-argument>'/api/players/9'</span>, {
    <span class="js-object">method</span>: <span class="js-object-str">'PUT'</span>,
    <span class="js-object">headers</span>: {
        <span class="js-object-str">'Content-Type'</span>: <span class="js-object-str">'application/json'</span>,
        <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
    },
    <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>,
    <span class="js-object">body</span>: <span class="js-object">JSON</span>.<span class="js-method">stringify</span>({
        <span class="js-object">jerseyNumber</span>: <span class="js-object">11</span>,
        <span class="js-object">position</span>: <span class="js-object-str">'Left wing'</span>
    })
})
    .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
    .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Remove/restore a player -->
            <button class="collapsible"><h3>Remove/restore a player</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Updates an existing player's roster status. Players removed from the roster are not permanently deleted and can subsequently be restored to the roster.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/players/{jerseyNumber}</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">PATCH</code></p>
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
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Values</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Required</td>
                                <td>The jersey number of the player to remove/restore</td>
                                <td>1 to 99 (inclusive)</td>
                            </tr>
                        </table>
                        <p class="bold">Example:</p>
                        <p><code class="code">/api/players/9</code></p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p class="italic">All parameters must be sent as JSON with the correct headers.</p>
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Data Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Constraints</th>
                                <th>Example Value</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">action</code></td>
                                <td class="center">string</td>
                                <td class="center">Required</td>
                                <td>The action to effect on the player's roster status</td>
                                <td>Must be either <code class="code">'remove'</code> or <code class="code">'restore'</code></td>
                                <td><code class="code">'remove'</code></td>
                            </tr>
                        </table>
                    </li>
                    <li>
                        <p class="bold">Success Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 200 OK</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player removed from roster"</span> }</code></pre>
                            <p>OR</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player restored to roster"</span> }</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Error Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 400 BAD REQUEST</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player already removed from roster"</span> }</code></pre>
                            <p>OR</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player already on roster"</span> }</code></pre>
                        </ul>
                        <p>OR</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 404 NOT FOUND</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player with jersey number 9 not found"</span> }</code></pre>
                        </ul>
                        <p>OR</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 422 UNPROCESSABLE CONTENT</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{
    <span class="json-key">"message"</span>: <span class="json-str">"The selected action is invalid."</span>,
    <span class="json-key">"errors"</span>: {
        <span class="json-key">"action"</span>: [<span class="json-str">"The selected action is invalid."</span>]
    }
}</code></pre>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class=js-argument>'/api/players/9'</span>, {
    <span class="js-object">method</span>: <span class="js-object-str">'PATCH'</span>,
    <span class="js-object">headers</span>: {
        <span class="js-object-str">'Content-Type'</span>: <span class="js-object-str">'application/json'</span>,
        <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
    },
    <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>,
    <span class="js-object">body</span>: <span class="js-object">JSON</span>.<span class="js-method">stringify</span>({
        <span class="js-object">action</span>: <span class="js-object-str">'remove'</span>
    })
})
    .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
    .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Delete a player -->
            <button class="collapsible"><h3>Delete a player</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Permanently deletes a player's data.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/players/{jerseyNumber}</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">DELETE</code></p>
                    </li>
                    <li>
                        <p class="bold">Headers:</p>
                        <ul>
                            <li><p><span class="bold">Accept:</span> application/json</p></li>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">URL Params:</p>
                        <table>
                            <tr>
                                <th>Parameter Name</th>
                                <th>Type</th>
                                <th>Required?</th>
                                <th>Description</th>
                                <th>Values</th>
                            </tr>
                            <tr>
                                <td class="center"><code class="code">jerseyNumber</code></td>
                                <td class="center">integer</td>
                                <td class="center">Required</td>
                                <td>The jersey number of the player to delete</td>
                                <td>1 to 99 (inclusive)</td>
                            </tr>
                        </table>
                        <p class="bold">Example:</p>
                        <p><code class="code">/api/players/9</code></p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p>None</p>
                    </li>
                    <li>
                        <p class="bold">Success Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 200 OK</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{ <span class="json-key">"message"</span>: <span class="json-str">"Player deleted"</span> }</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Error Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 404 NOT FOUND</p></li>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/players/9'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'DELETE'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Return all positions -->
            <button class="collapsible"><h3>Return all positions</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Returns the names of all positions, as JSON data.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/positions</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">GET</code></p>
                    </li>
                    <li>
                        <p class="bold">Headers:</p>
                        <ul>
                            <li><p><span class="bold">Accept:</span> application/json</p></li>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">URL Params:</p>
                        <p>None</p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p>None</p>
                    </li>
                    <li>
                        <p class="bold">Success Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 200 OK</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{
    <span class="json-key">"data"</span>: [
        { <span class="json-key">"name"</span>: <span class="json-str">"Goaltender"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Defense"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Center"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Left wing"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Right wing"</span> }
    ],
    <span class="json-key">"message"</span>: <span class="json-str">"Positions successfully retrieved"</span>
}</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Error Response:</p>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/positions'</span>, {
        <span class="js-object">method</span>: <span class="js-object-str">'GET'</span>,
        <span class="js-object">headers</span>: {
            <span class="js-object">Accept</span>: <span class="js-object-str">'application/json'</span>
        },
        <span class="js-object">mode</span>: <span class="js-object-str">'cors'</span>
    })
        .<span class="js-method">then</span>(response <span class="js-arrow">=></span> response.<span class="js-method">json</span>())
        .<span class="js-method">then</span>(data <span class="js-arrow">=></span> console.<span class="js-method">log</span>(data));</code></pre>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>
        <section> <!-- Return all nationalities -->
            <button class="collapsible"><h3>Return all nationalities</h3><p class="symbol">+</p></button>
            <div class="content">
                <p>Returns the names of all nationalities, as JSON data.</p>
                <ul>
                    <li>
                        <p class="bold">URL:</p>
                        <p>/api/nationalities</p>
                    </li>
                    <li>
                        <p class="bold">Method:</p>
                        <p><code class="code">GET</code></p>
                    </li>
                    <li>
                        <p class="bold">Headers:</p>
                        <ul>
                            <li><p><span class="bold">Accept:</span> application/json</p></li>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">URL Params:</p>
                        <p>None</p>
                    </li>
                    <li>
                        <p class="bold">Body Data Params:</p>
                        <p>None</p>
                    </li>
                    <li>
                        <p class="bold">Success Response:</p>
                        <ul>
                            <li><p><span class="bold">Code:</span> 200 OK</p></li>
                            <p class="bold">Content:</p>
                            <pre class="code codeblock"><code>{
    <span class="json-key">"data"</span>: [
        { <span class="json-key">"name"</span>: <span class="json-str">"USA"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Canada"</span> },
        { <span class="json-key">"name"</span>: <span class="json-str">"Sweden"</span> }
    ],
    <span class="json-key">"message"</span>: <span class="json-str">"Nationalities successfully retrieved"</span>
}</code></pre>
                        </ul>
                    </li>
                    <li>
                        <p class="bold">Error Response:</p>
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
                            <pre class="code codeblock"><code><span class="js-method">fetch</span>(<span class="js-argument">'/api/nationalities'</span>, {
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
            </div>
        </section>
    </div>
</body>

</html>