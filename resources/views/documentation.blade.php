<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vancouver Canucks Roster API: Documentation</title>

    <meta name="description" content="" />
    <meta name="author" content="Albert Rowett" />
</head>

<body>
    <h1>Canucks Roster API</h1>
    <h2>API Documentation</h2>
    <h3>Return all players - optionally filtered</h3>
    <ul>
        <li>
            <b>URL:</b><br>
            /api/players
        </li>
        <li>
            <b>Method:</b><br>
            <code>GET</code>
        </li>
        <li>
            <b>URL Params:</b><br>
            <b>Required:</b><br>
            There are no required URL params<br>
            <b>Optional:</b><br>
            <ul>
                <li><code>removed=0|1</code> - 1 to return only players removed from roster (if unspecified, only active players returned, i.e. <code>removed=0</code>)</li>
                <li><code>position=string</code> - Filter results by position name</li>
                <li><code>nationality=string</code> - Filter results by nationality name</li>
            </ul>
            <b>Example:</b><br>
            <code>/api/players?removed=1&position=Center&nationality=USA</code>
        </li>
        <li>
            <b>Success Response:</b><br>
            <ul>
                <li><b>Code:</b> 200</li><br>
                <b>Content:</b>
                <pre>
                    <code>
{
    "data": [
        {
            "id": 1,
            "name": "J. T. Miller",
            "jersey_number": 9,
            "date_of_birth": "1993-03-14",
            "position": {
                "name": "Center"
            },
            "draft_team": {
                "team": {
                    "name": "New York Rangers"
                }
            },
            "previous_teams": [
                {
                    "team": {
                        "name": "New York Rangers"
                    }
                },
                {
                    "team": {
                        "name": "Tampa Bay Lightning"
                    }
                }
            ]
        }
    ],
    "message": "Players successfully retrieved"
}
                    </code>
                </pre>
            </ul>
        </li>
        <li>
            <b>Error Response:</b><br>
            <ul>
                <li><b>Code:</b> 422 UNPROCESSABLE CONTENT</li><br>
                <b>Content:</b>
                <pre>
                    <code>
{
    "message": "The removed field must be true or false. (and 2 more errors)",
    "errors": {
        "removed": [
            "The removed field must be true or false."
        ],
        "position": [
            "The selected position is invalid."
        ],
        "nationality": [
            "The selected nationality is invalid."
        ]
    }
}
                    </code>
                </pre>
            </ul>
        </li>
        <li>
            <b>Sample Call:</b><br>
            <ul>
                <li><b>JavaScript (<code>`fetch`</code>):</b></li>
            </ul>
            <pre>
                <code>                
fetch('/api/players?removed=1&position=Center&nationality=USA', {
    method: 'GET',
    headers: {
        'Accept': 'application/json'
    },
    mode: 'cors'
})
.then(response => response.json())
.then(data => console.log(data));
                </code>
            </pre>
        </li>
    </ul>
</body>

</html>