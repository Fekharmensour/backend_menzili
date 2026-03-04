<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.8.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.8.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-get_data">
                                <a href="#endpoints-GETapi-get_data">GET api/get_data</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-listings-update">
                                <a href="#endpoints-POSTapi-listings-update">POST api/listings/update</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-login">
                                <a href="#endpoints-POSTapi-auth-login">POST api/auth/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-valid-otp">
                                <a href="#endpoints-POSTapi-auth-valid-otp">POST api/auth/valid-otp</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-fill-name">
                                <a href="#endpoints-POSTapi-auth-fill-name">POST api/auth/fill-name</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-listings">
                                <a href="#endpoints-GETapi-listings">GET api/listings</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-listings">
                                <a href="#endpoints-POSTapi-listings">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-listings--id-">
                                <a href="#endpoints-PUTapi-listings--id-">PUT api/listings/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-listings--id-">
                                <a href="#endpoints-DELETEapi-listings--id-">DELETE api/listings/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-listings-details">
                                <a href="#endpoints-GETapi-listings-details">GET api/listings/details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-listings-wilayas">
                                <a href="#endpoints-GETapi-listings-wilayas">GET api/listings/wilayas</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-listings-cities">
                                <a href="#endpoints-GETapi-listings-cities">GET api/listings/cities</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: March 4, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-get_data">GET api/get_data</h2>

<p>
</p>



<span id="example-requests-GETapi-get_data">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/get_data" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/get_data"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-get_data">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Rent&quot;,
        &quot;icon_path&quot;: &quot;/storage/listing_types/rent.png&quot;
    },
    {
        &quot;id&quot;: 2,
        &quot;name&quot;: &quot;Sell&quot;,
        &quot;icon_path&quot;: &quot;/storage/listing_types/sell.png&quot;
    },
    {
        &quot;id&quot;: 3,
        &quot;name&quot;: &quot;Exchange&quot;,
        &quot;icon_path&quot;: &quot;/storage/listing_types/exchange.png&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-get_data" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-get_data"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-get_data"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-get_data" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-get_data">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-get_data" data-method="GET"
      data-path="api/get_data"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-get_data', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-get_data"
                    onclick="tryItOut('GETapi-get_data');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-get_data"
                    onclick="cancelTryOut('GETapi-get_data');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-get_data"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/get_data</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-get_data"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-get_data"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-listings-update">POST api/listings/update</h2>

<p>
</p>



<span id="example-requests-POSTapi-listings-update">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/listings/update" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/update"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-listings-update">
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The id field is required. (and 1 more error)&quot;,
    &quot;errors&quot;: {
        &quot;id&quot;: [
            &quot;The id field is required.&quot;
        ],
        &quot;url&quot;: [
            &quot;The url field is required.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-listings-update" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-listings-update"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-listings-update"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-listings-update" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-listings-update">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-listings-update" data-method="POST"
      data-path="api/listings/update"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-listings-update', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-listings-update"
                    onclick="tryItOut('POSTapi-listings-update');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-listings-update"
                    onclick="cancelTryOut('POSTapi-listings-update');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-listings-update"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/listings/update</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-listings-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-listings-update"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-auth-login">POST api/auth/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"phone\": \"vmqeopfuudtds\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone": "vmqeopfuudtds"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-login">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;OTP has been sent to your phone number.&quot;,
    &quot;status&quot;: 200,
    &quot;data&quot;: {
        &quot;otp_code&quot;: &quot;797939&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-login" data-method="POST"
      data-path="api/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-login"
                    onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-login"
                    onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-auth-login"
               value="vmqeopfuudtds"
               data-component="body">
    <br>
<p>Must be at least 9 characters. Must not be greater than 15 characters. Example: <code>vmqeopfuudtds</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-auth-valid-otp">POST api/auth/valid-otp</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-valid-otp">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/valid-otp" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"phone\": \"consequatur\",
    \"otp_code\": \"810798\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/valid-otp"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "phone": "consequatur",
    "otp_code": "810798"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-valid-otp">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;User not found.&quot;,
    &quot;status&quot;: 404
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-valid-otp" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-valid-otp"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-valid-otp"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-valid-otp" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-valid-otp">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-valid-otp" data-method="POST"
      data-path="api/auth/valid-otp"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-valid-otp', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-valid-otp"
                    onclick="tryItOut('POSTapi-auth-valid-otp');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-valid-otp"
                    onclick="cancelTryOut('POSTapi-auth-valid-otp');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-valid-otp"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/valid-otp</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-valid-otp"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-valid-otp"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-auth-valid-otp"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>otp_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="otp_code"                data-endpoint="POSTapi-auth-valid-otp"
               value="810798"
               data-component="body">
    <br>
<p>Must be 6 digits. Example: <code>810798</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-auth-fill-name">POST api/auth/fill-name</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-fill-name">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/auth/fill-name" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"vmqeopfuudtdsufvyvddq\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/auth/fill-name"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vmqeopfuudtdsufvyvddq"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-fill-name">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-auth-fill-name" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-fill-name"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-fill-name"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-fill-name" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-fill-name">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-fill-name" data-method="POST"
      data-path="api/auth/fill-name"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-fill-name', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-fill-name"
                    onclick="tryItOut('POSTapi-auth-fill-name');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-fill-name"
                    onclick="cancelTryOut('POSTapi-auth-fill-name');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-fill-name"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/fill-name</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-fill-name"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-fill-name"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-auth-fill-name"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must be at least 2 characters. Must not be greater than 100 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-listings">GET api/listings</h2>

<p>
</p>



<span id="example-requests-GETapi-listings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/listings" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-listings">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;listing&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;شقة عصرية في وسط المدينة&quot;,
                &quot;description&quot;: &quot;شقة جميلة ومجهزة بالكامل تقع في قلب المدينة، قريبة من جميع المرافق مثل المحلات التجارية ووسائل النقل. مناسبة للعائلات أو الأزواج.&quot;,
                &quot;price&quot;: 45000,
                &quot;floor&quot;: 3,
                &quot;surface&quot;: 95,
                &quot;min_duration&quot;: 6,
                &quot;number_rooms&quot;: 3,
                &quot;number_persons&quot;: 5,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;/storage//storage/listings/img-1.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;
                },
                &quot;location&quot;: {
                    &quot;id&quot;: 1,
                    &quot;latitude&quot;: &quot;36.36500000&quot;,
                    &quot;longitude&quot;: &quot;6.61470000&quot;,
                    &quot;zip_code&quot;: &quot;25000&quot;,
                    &quot;city&quot;: &quot;Constantine&quot;,
                    &quot;wilaya&quot;: &quot;Constantine&quot;,
                    &quot;Wilaya_code&quot;: &quot;25&quot;,
                    &quot;country&quot;: &quot;Algeria&quot;
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;title&quot;: &quot;فيلا فاخرة مع مسبح خاص&quot;,
                &quot;description&quot;: &quot;فيلا راقية تحتوي على مسبح خاص وحديقة واسعة، تقع في حي هادئ وآمن. مثالية للعائلات الكبيرة.&quot;,
                &quot;price&quot;: 180000,
                &quot;floor&quot;: 1,
                &quot;surface&quot;: 320,
                &quot;min_duration&quot;: 12,
                &quot;number_rooms&quot;: 6,
                &quot;number_persons&quot;: 10,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;/storage//storage/listings/img-2.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;
                },
                &quot;location&quot;: {
                    &quot;id&quot;: 1,
                    &quot;latitude&quot;: &quot;36.36500000&quot;,
                    &quot;longitude&quot;: &quot;6.61470000&quot;,
                    &quot;zip_code&quot;: &quot;25000&quot;,
                    &quot;city&quot;: &quot;Constantine&quot;,
                    &quot;wilaya&quot;: &quot;Constantine&quot;,
                    &quot;Wilaya_code&quot;: &quot;25&quot;,
                    &quot;country&quot;: &quot;Algeria&quot;
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;title&quot;: &quot;استوديو مفروش بالقرب من الجامعة&quot;,
                &quot;description&quot;: &quot;استوديو صغير ومريح مفروش بالكامل، قريب جداً من الجامعة ووسائل النقل. مناسب للطلبة.&quot;,
                &quot;price&quot;: 25000,
                &quot;floor&quot;: 2,
                &quot;surface&quot;: 45,
                &quot;min_duration&quot;: 3,
                &quot;number_rooms&quot;: 1,
                &quot;number_persons&quot;: 2,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;/storage//storage/listings/img-3.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;
                },
                &quot;location&quot;: {
                    &quot;id&quot;: 1,
                    &quot;latitude&quot;: &quot;36.36500000&quot;,
                    &quot;longitude&quot;: &quot;6.61470000&quot;,
                    &quot;zip_code&quot;: &quot;25000&quot;,
                    &quot;city&quot;: &quot;Constantine&quot;,
                    &quot;wilaya&quot;: &quot;Constantine&quot;,
                    &quot;Wilaya_code&quot;: &quot;25&quot;,
                    &quot;country&quot;: &quot;Algeria&quot;
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;title&quot;: &quot;منزل عائلي واسع في حي هادئ&quot;,
                &quot;description&quot;: &quot;منزل عائلي بمساحة كبيرة يحتوي على حديقة وموقف سيارات، يقع في حي سكني هادئ وآمن.&quot;,
                &quot;price&quot;: 90000,
                &quot;floor&quot;: 2,
                &quot;surface&quot;: 210,
                &quot;min_duration&quot;: 12,
                &quot;number_rooms&quot;: 5,
                &quot;number_persons&quot;: 8,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;/storage//storage/listings/img-4.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;
                },
                &quot;location&quot;: {
                    &quot;id&quot;: 1,
                    &quot;latitude&quot;: &quot;36.36500000&quot;,
                    &quot;longitude&quot;: &quot;6.61470000&quot;,
                    &quot;zip_code&quot;: &quot;25000&quot;,
                    &quot;city&quot;: &quot;Constantine&quot;,
                    &quot;wilaya&quot;: &quot;Constantine&quot;,
                    &quot;Wilaya_code&quot;: &quot;25&quot;,
                    &quot;country&quot;: &quot;Algeria&quot;
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            }
        ],
        &quot;pagination&quot;: {
            &quot;total&quot;: 5,
            &quot;count&quot;: 4,
            &quot;per_page&quot;: 4,
            &quot;current_page&quot;: 1,
            &quot;total_pages&quot;: 2,
            &quot;has_pages&quot;: true,
            &quot;has_more_pages&quot;: true,
            &quot;first_page_url&quot;: &quot;http://localhost/api/listings?page=1&quot;,
            &quot;last_page_url&quot;: &quot;http://localhost/api/listings?page=2&quot;,
            &quot;next_page_url&quot;: &quot;http://localhost/api/listings?page=2&quot;,
            &quot;prev_page_url&quot;: null,
            &quot;from&quot;: 1,
            &quot;to&quot;: 4,
            &quot;path&quot;: &quot;http://localhost/api/listings&quot;,
            &quot;current_page_url&quot;: &quot;http://localhost/api/listings?page=1&quot;
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-listings" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-listings"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-listings"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-listings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-listings">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-listings" data-method="GET"
      data-path="api/listings"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-listings', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-listings"
                    onclick="tryItOut('GETapi-listings');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-listings"
                    onclick="cancelTryOut('GETapi-listings');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-listings"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/listings</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-listings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-listings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-listings">Store a newly created resource in storage.</h2>

<p>
</p>



<span id="example-requests-POSTapi-listings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/listings" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "description=Dolores dolorum amet iste laborum eius est dolor."\
    --form "price=12"\
    --form "floor=66"\
    --form "surface=13"\
    --form "boost_level=8"\
    --form "min_duration=72"\
    --form "number_rooms=19"\
    --form "number_persons=74"\
    --form "is_ready="\
    --form "is_negotiable=1"\
    --form "member_id=consequatur"\
    --form "rent_duration_id=consequatur"\
    --form "type_id=consequatur"\
    --form "location[latitude]=-89"\
    --form "location[longitude]=-180"\
    --form "location[altitude]=11613.31890586"\
    --form "location[zip_code]=opfuudtdsufvyvddq"\
    --form "location[city_id]=consequatur"\
    --form "main_image=@/tmp/phpfO6KT6" \
    --form "images[]=@/tmp/phpLIbJoh" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('description', 'Dolores dolorum amet iste laborum eius est dolor.');
body.append('price', '12');
body.append('floor', '66');
body.append('surface', '13');
body.append('boost_level', '8');
body.append('min_duration', '72');
body.append('number_rooms', '19');
body.append('number_persons', '74');
body.append('is_ready', '');
body.append('is_negotiable', '1');
body.append('member_id', 'consequatur');
body.append('rent_duration_id', 'consequatur');
body.append('type_id', 'consequatur');
body.append('location[latitude]', '-89');
body.append('location[longitude]', '-180');
body.append('location[altitude]', '11613.31890586');
body.append('location[zip_code]', 'opfuudtdsufvyvddq');
body.append('location[city_id]', 'consequatur');
body.append('main_image', document.querySelector('input[name="main_image"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-listings">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-listings" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-listings"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-listings"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-listings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-listings">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-listings" data-method="POST"
      data-path="api/listings"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-listings', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-listings"
                    onclick="tryItOut('POSTapi-listings');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-listings"
                    onclick="cancelTryOut('POSTapi-listings');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-listings"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/listings</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-listings"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-listings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-listings"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-listings"
               value="Dolores dolorum amet iste laborum eius est dolor."
               data-component="body">
    <br>
<p>Example: <code>Dolores dolorum amet iste laborum eius est dolor.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="POSTapi-listings"
               value="12"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>floor</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="floor"                data-endpoint="POSTapi-listings"
               value="66"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>66</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>surface</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="surface"                data-endpoint="POSTapi-listings"
               value="13"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>13</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>boost_level</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="boost_level"                data-endpoint="POSTapi-listings"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 10. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>min_duration</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="min_duration"                data-endpoint="POSTapi-listings"
               value="72"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>72</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_rooms</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_rooms"                data-endpoint="POSTapi-listings"
               value="19"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>19</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_persons</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_persons"                data-endpoint="POSTapi-listings"
               value="74"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>74</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_ready</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-listings" style="display: none">
            <input type="radio" name="is_ready"
                   value="true"
                   data-endpoint="POSTapi-listings"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-listings" style="display: none">
            <input type="radio" name="is_ready"
                   value="false"
                   data-endpoint="POSTapi-listings"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_negotiable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-listings" style="display: none">
            <input type="radio" name="is_negotiable"
                   value="true"
                   data-endpoint="POSTapi-listings"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-listings" style="display: none">
            <input type="radio" name="is_negotiable"
                   value="false"
                   data-endpoint="POSTapi-listings"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>main_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="main_image"                data-endpoint="POSTapi-listings"
               value=""
               data-component="body">
    <br>
<p>Must be an image. Must not be greater than 2048 kilobytes. Example: <code>/tmp/phpfO6KT6</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>member_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="member_id"                data-endpoint="POSTapi-listings"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the members table. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>rent_duration_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="rent_duration_id"                data-endpoint="POSTapi-listings"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the rent_durations table. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>type_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type_id"                data-endpoint="POSTapi-listings"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the types table. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
 &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>latitude</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="location.latitude"                data-endpoint="POSTapi-listings"
               value="-89"
               data-component="body">
    <br>
<p>Must be between -90 and 90. Example: <code>-89</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>longitude</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="location.longitude"                data-endpoint="POSTapi-listings"
               value="-180"
               data-component="body">
    <br>
<p>Must be between -180 and 180. Example: <code>-180</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>altitude</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="location.altitude"                data-endpoint="POSTapi-listings"
               value="11613.31890586"
               data-component="body">
    <br>
<p>Example: <code>11613.31890586</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>zip_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location.zip_code"                data-endpoint="POSTapi-listings"
               value="opfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 20 characters. Example: <code>opfuudtdsufvyvddq</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location.city_id"                data-endpoint="POSTapi-listings"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the cities table. Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>categories</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="categories[0]"                data-endpoint="POSTapi-listings"
               data-component="body">
        <input type="text" style="display: none"
               name="categories[1]"                data-endpoint="POSTapi-listings"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the categories table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>features</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="features[0]"                data-endpoint="POSTapi-listings"
               data-component="body">
        <input type="text" style="display: none"
               name="features[1]"                data-endpoint="POSTapi-listings"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the features table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>near_places</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="near_places[0]"                data-endpoint="POSTapi-listings"
               data-component="body">
        <input type="text" style="display: none"
               name="near_places[1]"                data-endpoint="POSTapi-listings"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the near_places table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images</code></b>&nbsp;&nbsp;
<small>file[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images[0]"                data-endpoint="POSTapi-listings"
               data-component="body">
        <input type="file" style="display: none"
               name="images[1]"                data-endpoint="POSTapi-listings"
               data-component="body">
    <br>
<p>Must be an image. Must not be greater than 2048 kilobytes.</p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-listings--id-">PUT api/listings/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-listings--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/listings/1" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "description=Dolores dolorum amet iste laborum eius est dolor."\
    --form "price=12"\
    --form "floor=66"\
    --form "surface=13"\
    --form "boost_level=8"\
    --form "min_duration=72"\
    --form "number_rooms=19"\
    --form "number_persons=74"\
    --form "is_ready="\
    --form "is_negotiable=1"\
    --form "location[latitude]=11613.31890586"\
    --form "location[longitude]=11613.31890586"\
    --form "main_image=@/tmp/phpa4dcy3" \
    --form "images[]=@/tmp/phpF8TykJ" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/1"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('description', 'Dolores dolorum amet iste laborum eius est dolor.');
body.append('price', '12');
body.append('floor', '66');
body.append('surface', '13');
body.append('boost_level', '8');
body.append('min_duration', '72');
body.append('number_rooms', '19');
body.append('number_persons', '74');
body.append('is_ready', '');
body.append('is_negotiable', '1');
body.append('location[latitude]', '11613.31890586');
body.append('location[longitude]', '11613.31890586');
body.append('main_image', document.querySelector('input[name="main_image"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-listings--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-listings--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-listings--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-listings--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-listings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-listings--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-listings--id-" data-method="PUT"
      data-path="api/listings/{id}"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-listings--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-listings--id-"
                    onclick="tryItOut('PUTapi-listings--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-listings--id-"
                    onclick="cancelTryOut('PUTapi-listings--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-listings--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/listings/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/listings/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-listings--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-listings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-listings--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the listing. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-listings--id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-listings--id-"
               value="Dolores dolorum amet iste laborum eius est dolor."
               data-component="body">
    <br>
<p>Example: <code>Dolores dolorum amet iste laborum eius est dolor.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="PUTapi-listings--id-"
               value="12"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>floor</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="floor"                data-endpoint="PUTapi-listings--id-"
               value="66"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>66</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>surface</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="surface"                data-endpoint="PUTapi-listings--id-"
               value="13"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>13</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>boost_level</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="boost_level"                data-endpoint="PUTapi-listings--id-"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 10. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>min_duration</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="min_duration"                data-endpoint="PUTapi-listings--id-"
               value="72"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>72</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_rooms</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_rooms"                data-endpoint="PUTapi-listings--id-"
               value="19"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>19</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>number_persons</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="number_persons"                data-endpoint="PUTapi-listings--id-"
               value="74"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>74</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_ready</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-listings--id-" style="display: none">
            <input type="radio" name="is_ready"
                   value="true"
                   data-endpoint="PUTapi-listings--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-listings--id-" style="display: none">
            <input type="radio" name="is_ready"
                   value="false"
                   data-endpoint="PUTapi-listings--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_negotiable</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-listings--id-" style="display: none">
            <input type="radio" name="is_negotiable"
                   value="true"
                   data-endpoint="PUTapi-listings--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-listings--id-" style="display: none">
            <input type="radio" name="is_negotiable"
                   value="false"
                   data-endpoint="PUTapi-listings--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>main_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="main_image"                data-endpoint="PUTapi-listings--id-"
               value=""
               data-component="body">
    <br>
<p>Must be an image. Must not be greater than 2048 kilobytes. Example: <code>/tmp/phpa4dcy3</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>latitude</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="location.latitude"                data-endpoint="PUTapi-listings--id-"
               value="11613.31890586"
               data-component="body">
    <br>
<p>This field is required when <code>location</code> is present. Example: <code>11613.31890586</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>longitude</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="location.longitude"                data-endpoint="PUTapi-listings--id-"
               value="11613.31890586"
               data-component="body">
    <br>
<p>This field is required when <code>location</code> is present. Example: <code>11613.31890586</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location.city_id"                data-endpoint="PUTapi-listings--id-"
               value=""
               data-component="body">
    <br>
<p>This field is required when <code>location</code> is present. The <code>id</code> of an existing record in the cities table.</p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>categories</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="categories[0]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="categories[1]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the categories table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>features</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="features[0]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="features[1]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the features table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>near_places</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="near_places[0]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="near_places[1]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the near_places table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images</code></b>&nbsp;&nbsp;
<small>file[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images[0]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
        <input type="file" style="display: none"
               name="images[1]"                data-endpoint="PUTapi-listings--id-"
               data-component="body">
    <br>
<p>Must be an image. Must not be greater than 2048 kilobytes.</p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-listings--id-">DELETE api/listings/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-listings--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/listings/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-listings--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-listings--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-listings--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-listings--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-listings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-listings--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-listings--id-" data-method="DELETE"
      data-path="api/listings/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-listings--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-listings--id-"
                    onclick="tryItOut('DELETEapi-listings--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-listings--id-"
                    onclick="cancelTryOut('DELETEapi-listings--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-listings--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/listings/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-listings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-listings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-listings--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the listing. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-listings-details">GET api/listings/details</h2>

<p>
</p>



<span id="example-requests-GETapi-listings-details">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/listings/details" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/details"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-listings-details">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Data retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;features&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;TV&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Pool&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;WiFi&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/wifi.png&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;AC&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/ac.png&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;Garage&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/garage.png&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;Garden&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/garden.png&quot;
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;Balcony&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/balcony.png&quot;
            },
            {
                &quot;id&quot;: 8,
                &quot;name&quot;: &quot;Open Kitchen&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/kitchen.png&quot;
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;Ensuite Bathroom&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/bathroom.png&quot;
            },
            {
                &quot;id&quot;: 10,
                &quot;name&quot;: &quot;24/7 Security&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/security.png&quot;
            },
            {
                &quot;id&quot;: 11,
                &quot;name&quot;: &quot;Security Cameras&quot;,
                &quot;icon_path&quot;: &quot;/storage/featured_listings/camera.png&quot;
            }
        ],
        &quot;categories&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Apartment&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;House&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/house.png&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Villa&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/villa.png&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;Office&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/office.png&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;Store&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/store.png&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;Land&quot;,
                &quot;icon_path&quot;: &quot;/storage/category_listings/land.png&quot;
            }
        ],
        &quot;near_places&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Mosque&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Child School&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/child_school.png&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;School&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/school.png&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;Police Station&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/police_station.png&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;Beach&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/beach.png&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;Cafe&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/cafe.png&quot;
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;Hospital&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/hospital.png&quot;
            },
            {
                &quot;id&quot;: 8,
                &quot;name&quot;: &quot;Market&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/market.png&quot;
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;Bus Station&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/bus_station.png&quot;
            },
            {
                &quot;id&quot;: 10,
                &quot;name&quot;: &quot;Park&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/park.png&quot;
            },
            {
                &quot;id&quot;: 11,
                &quot;name&quot;: &quot;Car Park&quot;,
                &quot;icon_path&quot;: &quot;/storage/near_places/car_park.png&quot;
            }
        ],
        &quot;types&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Rent&quot;,
                &quot;icon_path&quot;: &quot;/storage/listing_types/rent.png&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Sell&quot;,
                &quot;icon_path&quot;: &quot;/storage/listing_types/sell.png&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Exchange&quot;,
                &quot;icon_path&quot;: &quot;/storage/listing_types/exchange.png&quot;
            }
        ],
        &quot;rent_durations&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Day&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Month&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;6 Months&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;Year&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-listings-details" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-listings-details"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-listings-details"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-listings-details" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-listings-details">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-listings-details" data-method="GET"
      data-path="api/listings/details"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-listings-details', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-listings-details"
                    onclick="tryItOut('GETapi-listings-details');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-listings-details"
                    onclick="cancelTryOut('GETapi-listings-details');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-listings-details"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/listings/details</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-listings-details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-listings-details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-listings-wilayas">GET api/listings/wilayas</h2>

<p>
</p>



<span id="example-requests-GETapi-listings-wilayas">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/listings/wilayas" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/wilayas"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-listings-wilayas">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Data retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;wilayas&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Adrar&quot;,
                &quot;code&quot;: &quot;1&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Chlef&quot;,
                &quot;code&quot;: &quot;2&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Laghouat&quot;,
                &quot;code&quot;: &quot;3&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;Oum El Bouaghi&quot;,
                &quot;code&quot;: &quot;4&quot;
            },
            {
                &quot;id&quot;: 5,
                &quot;name&quot;: &quot;Batna&quot;,
                &quot;code&quot;: &quot;5&quot;
            },
            {
                &quot;id&quot;: 6,
                &quot;name&quot;: &quot;B&eacute;ja&iuml;a&quot;,
                &quot;code&quot;: &quot;6&quot;
            },
            {
                &quot;id&quot;: 7,
                &quot;name&quot;: &quot;Biskra&quot;,
                &quot;code&quot;: &quot;7&quot;
            },
            {
                &quot;id&quot;: 8,
                &quot;name&quot;: &quot;Bechar&quot;,
                &quot;code&quot;: &quot;8&quot;
            },
            {
                &quot;id&quot;: 9,
                &quot;name&quot;: &quot;Blida&quot;,
                &quot;code&quot;: &quot;9&quot;
            },
            {
                &quot;id&quot;: 10,
                &quot;name&quot;: &quot;Bouira&quot;,
                &quot;code&quot;: &quot;10&quot;
            },
            {
                &quot;id&quot;: 11,
                &quot;name&quot;: &quot;Tamanrasset&quot;,
                &quot;code&quot;: &quot;11&quot;
            },
            {
                &quot;id&quot;: 12,
                &quot;name&quot;: &quot;Tbessa&quot;,
                &quot;code&quot;: &quot;12&quot;
            },
            {
                &quot;id&quot;: 13,
                &quot;name&quot;: &quot;Tlemcen&quot;,
                &quot;code&quot;: &quot;13&quot;
            },
            {
                &quot;id&quot;: 14,
                &quot;name&quot;: &quot;Tiaret&quot;,
                &quot;code&quot;: &quot;14&quot;
            },
            {
                &quot;id&quot;: 15,
                &quot;name&quot;: &quot;Tizi Ouzou&quot;,
                &quot;code&quot;: &quot;15&quot;
            },
            {
                &quot;id&quot;: 16,
                &quot;name&quot;: &quot;Alger&quot;,
                &quot;code&quot;: &quot;16&quot;
            },
            {
                &quot;id&quot;: 17,
                &quot;name&quot;: &quot;Djelfa&quot;,
                &quot;code&quot;: &quot;17&quot;
            },
            {
                &quot;id&quot;: 18,
                &quot;name&quot;: &quot;Jijel&quot;,
                &quot;code&quot;: &quot;18&quot;
            },
            {
                &quot;id&quot;: 19,
                &quot;name&quot;: &quot;S&eacute;tif&quot;,
                &quot;code&quot;: &quot;19&quot;
            },
            {
                &quot;id&quot;: 20,
                &quot;name&quot;: &quot;Sa&iuml;da&quot;,
                &quot;code&quot;: &quot;20&quot;
            },
            {
                &quot;id&quot;: 21,
                &quot;name&quot;: &quot;Skikda&quot;,
                &quot;code&quot;: &quot;21&quot;
            },
            {
                &quot;id&quot;: 22,
                &quot;name&quot;: &quot;Sidi Bel Abbes&quot;,
                &quot;code&quot;: &quot;22&quot;
            },
            {
                &quot;id&quot;: 23,
                &quot;name&quot;: &quot;Annaba&quot;,
                &quot;code&quot;: &quot;23&quot;
            },
            {
                &quot;id&quot;: 24,
                &quot;name&quot;: &quot;Guelma&quot;,
                &quot;code&quot;: &quot;24&quot;
            },
            {
                &quot;id&quot;: 25,
                &quot;name&quot;: &quot;Constantine&quot;,
                &quot;code&quot;: &quot;25&quot;
            },
            {
                &quot;id&quot;: 26,
                &quot;name&quot;: &quot;Medea&quot;,
                &quot;code&quot;: &quot;26&quot;
            },
            {
                &quot;id&quot;: 27,
                &quot;name&quot;: &quot;Mostaganem&quot;,
                &quot;code&quot;: &quot;27&quot;
            },
            {
                &quot;id&quot;: 28,
                &quot;name&quot;: &quot;M&#039;Sila&quot;,
                &quot;code&quot;: &quot;28&quot;
            },
            {
                &quot;id&quot;: 29,
                &quot;name&quot;: &quot;Mascara&quot;,
                &quot;code&quot;: &quot;29&quot;
            },
            {
                &quot;id&quot;: 30,
                &quot;name&quot;: &quot;Ouargla&quot;,
                &quot;code&quot;: &quot;30&quot;
            },
            {
                &quot;id&quot;: 31,
                &quot;name&quot;: &quot;Oran&quot;,
                &quot;code&quot;: &quot;31&quot;
            },
            {
                &quot;id&quot;: 32,
                &quot;name&quot;: &quot;El Bayadh&quot;,
                &quot;code&quot;: &quot;32&quot;
            },
            {
                &quot;id&quot;: 33,
                &quot;name&quot;: &quot;Illizi&quot;,
                &quot;code&quot;: &quot;33&quot;
            },
            {
                &quot;id&quot;: 34,
                &quot;name&quot;: &quot;Bordj Bou Arreridj&quot;,
                &quot;code&quot;: &quot;34&quot;
            },
            {
                &quot;id&quot;: 35,
                &quot;name&quot;: &quot;Boumerdes&quot;,
                &quot;code&quot;: &quot;35&quot;
            },
            {
                &quot;id&quot;: 36,
                &quot;name&quot;: &quot;El Tarf&quot;,
                &quot;code&quot;: &quot;36&quot;
            },
            {
                &quot;id&quot;: 37,
                &quot;name&quot;: &quot;Tindouf&quot;,
                &quot;code&quot;: &quot;37&quot;
            },
            {
                &quot;id&quot;: 38,
                &quot;name&quot;: &quot;Tissemsilt&quot;,
                &quot;code&quot;: &quot;38&quot;
            },
            {
                &quot;id&quot;: 39,
                &quot;name&quot;: &quot;El Oued&quot;,
                &quot;code&quot;: &quot;39&quot;
            },
            {
                &quot;id&quot;: 40,
                &quot;name&quot;: &quot;Khenchela&quot;,
                &quot;code&quot;: &quot;40&quot;
            },
            {
                &quot;id&quot;: 41,
                &quot;name&quot;: &quot;Souk Ahras&quot;,
                &quot;code&quot;: &quot;41&quot;
            },
            {
                &quot;id&quot;: 42,
                &quot;name&quot;: &quot;Tipaza&quot;,
                &quot;code&quot;: &quot;42&quot;
            },
            {
                &quot;id&quot;: 43,
                &quot;name&quot;: &quot;Mila&quot;,
                &quot;code&quot;: &quot;43&quot;
            },
            {
                &quot;id&quot;: 44,
                &quot;name&quot;: &quot;Ain Defla&quot;,
                &quot;code&quot;: &quot;44&quot;
            },
            {
                &quot;id&quot;: 45,
                &quot;name&quot;: &quot;Naama&quot;,
                &quot;code&quot;: &quot;45&quot;
            },
            {
                &quot;id&quot;: 46,
                &quot;name&quot;: &quot;Ain Temouchent&quot;,
                &quot;code&quot;: &quot;46&quot;
            },
            {
                &quot;id&quot;: 47,
                &quot;name&quot;: &quot;Ghardaia&quot;,
                &quot;code&quot;: &quot;47&quot;
            },
            {
                &quot;id&quot;: 48,
                &quot;name&quot;: &quot;Relizane&quot;,
                &quot;code&quot;: &quot;48&quot;
            },
            {
                &quot;id&quot;: 49,
                &quot;name&quot;: &quot;El M&#039;ghair&quot;,
                &quot;code&quot;: &quot;49&quot;
            },
            {
                &quot;id&quot;: 50,
                &quot;name&quot;: &quot;El Menia&quot;,
                &quot;code&quot;: &quot;50&quot;
            },
            {
                &quot;id&quot;: 51,
                &quot;name&quot;: &quot;Ouled Djellal&quot;,
                &quot;code&quot;: &quot;51&quot;
            },
            {
                &quot;id&quot;: 52,
                &quot;name&quot;: &quot;Bordj Baji Mokhtar&quot;,
                &quot;code&quot;: &quot;52&quot;
            },
            {
                &quot;id&quot;: 53,
                &quot;name&quot;: &quot;B&eacute;ni Abb&egrave;s&quot;,
                &quot;code&quot;: &quot;53&quot;
            },
            {
                &quot;id&quot;: 54,
                &quot;name&quot;: &quot;Timimoun&quot;,
                &quot;code&quot;: &quot;54&quot;
            },
            {
                &quot;id&quot;: 55,
                &quot;name&quot;: &quot;Touggourt&quot;,
                &quot;code&quot;: &quot;55&quot;
            },
            {
                &quot;id&quot;: 56,
                &quot;name&quot;: &quot;Djanet&quot;,
                &quot;code&quot;: &quot;56&quot;
            },
            {
                &quot;id&quot;: 57,
                &quot;name&quot;: &quot;In Salah&quot;,
                &quot;code&quot;: &quot;57&quot;
            },
            {
                &quot;id&quot;: 58,
                &quot;name&quot;: &quot;In Guezzam&quot;,
                &quot;code&quot;: &quot;58&quot;
            },
            {
                &quot;id&quot;: 59,
                &quot;name&quot;: &quot;Aflou&quot;,
                &quot;code&quot;: &quot;59&quot;
            },
            {
                &quot;id&quot;: 60,
                &quot;name&quot;: &quot;Barika&quot;,
                &quot;code&quot;: &quot;60&quot;
            },
            {
                &quot;id&quot;: 61,
                &quot;name&quot;: &quot;Ksar Chellala&quot;,
                &quot;code&quot;: &quot;61&quot;
            },
            {
                &quot;id&quot;: 62,
                &quot;name&quot;: &quot;Messaad&quot;,
                &quot;code&quot;: &quot;62&quot;
            },
            {
                &quot;id&quot;: 63,
                &quot;name&quot;: &quot;A&iuml;n Oussara&quot;,
                &quot;code&quot;: &quot;63&quot;
            },
            {
                &quot;id&quot;: 64,
                &quot;name&quot;: &quot;Boussa&acirc;da&quot;,
                &quot;code&quot;: &quot;64&quot;
            },
            {
                &quot;id&quot;: 65,
                &quot;name&quot;: &quot;El Bayadh Sidi Cheikh&quot;,
                &quot;code&quot;: &quot;65&quot;
            },
            {
                &quot;id&quot;: 66,
                &quot;name&quot;: &quot;El Kantara&quot;,
                &quot;code&quot;: &quot;66&quot;
            },
            {
                &quot;id&quot;: 67,
                &quot;name&quot;: &quot;Bir El Ater&quot;,
                &quot;code&quot;: &quot;67&quot;
            },
            {
                &quot;id&quot;: 68,
                &quot;name&quot;: &quot;Ksar El Boukhari&quot;,
                &quot;code&quot;: &quot;68&quot;
            },
            {
                &quot;id&quot;: 69,
                &quot;name&quot;: &quot;El Aricha&quot;,
                &quot;code&quot;: &quot;69&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-listings-wilayas" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-listings-wilayas"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-listings-wilayas"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-listings-wilayas" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-listings-wilayas">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-listings-wilayas" data-method="GET"
      data-path="api/listings/wilayas"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-listings-wilayas', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-listings-wilayas"
                    onclick="tryItOut('GETapi-listings-wilayas');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-listings-wilayas"
                    onclick="cancelTryOut('GETapi-listings-wilayas');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-listings-wilayas"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/listings/wilayas</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-listings-wilayas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-listings-wilayas"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-listings-cities">GET api/listings/cities</h2>

<p>
</p>



<span id="example-requests-GETapi-listings-cities">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/listings/cities" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"wilaya_id\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/listings/cities"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "wilaya_id": "consequatur"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-listings-cities">
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The selected wilaya id is invalid.&quot;,
    &quot;errors&quot;: {
        &quot;wilaya_id&quot;: [
            &quot;The selected wilaya id is invalid.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-listings-cities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-listings-cities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-listings-cities"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-listings-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-listings-cities">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-listings-cities" data-method="GET"
      data-path="api/listings/cities"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-listings-cities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-listings-cities"
                    onclick="tryItOut('GETapi-listings-cities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-listings-cities"
                    onclick="cancelTryOut('GETapi-listings-cities');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-listings-cities"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/listings/cities</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-listings-cities"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-listings-cities"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>wilaya_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="wilaya_id"                data-endpoint="GETapi-listings-cities"
               value="consequatur"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the wilayas table. Example: <code>consequatur</code></p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
