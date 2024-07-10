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
        <span class="js-property-key">method</span>: <span class="js-property-value">'GET'</span>,
        <span class="js-property-key">headers</span>: {
            <span class="js-property-value">'Accept'</span>: <span class="js-property-value">'application/json'</span>
        },
        <span class="js-property-key">mode</span>: <span class="js-property-value">'cors'</span>
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