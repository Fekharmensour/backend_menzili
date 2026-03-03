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
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: March 2, 2026</li>
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
        &quot;icon&quot;: null,
        &quot;icon_path&quot;: &quot;/storage/listing_types/rent.png&quot;
    },
    {
        &quot;id&quot;: 2,
        &quot;name&quot;: &quot;Sell&quot;,
        &quot;icon&quot;: null,
        &quot;icon_path&quot;: &quot;/storage/listing_types/sell.png&quot;
    },
    {
        &quot;id&quot;: 3,
        &quot;name&quot;: &quot;Exchange&quot;,
        &quot;icon&quot;: null,
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
    &quot;message&quot;: &quot;Data retrieved successfully&quot;,
    &quot;data&quot;: {
        &quot;listing&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;title&quot;: &quot;شقة عصرية في وسط المدينة&quot;,
                &quot;description&quot;: &quot;شقة جميلة ومجهزة بالكامل تقع في قلب المدينة، قريبة من جميع المرافق مثل المحلات التجارية ووسائل النقل. مناسبة للعائلات أو الأزواج.&quot;,
                &quot;price&quot;: &quot;45000.00&quot;,
                &quot;floor&quot;: 3,
                &quot;surface&quot;: &quot;95.00&quot;,
                &quot;min_duration&quot;: 6,
                &quot;number_rooms&quot;: 3,
                &quot;number_persons&quot;: 5,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;listings/img-1.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;,
                    &quot;icon&quot;: null,
                    &quot;icon_path&quot;: null
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 2,
                &quot;title&quot;: &quot;فيلا فاخرة مع مسبح خاص&quot;,
                &quot;description&quot;: &quot;فيلا راقية تحتوي على مسبح خاص وحديقة واسعة، تقع في حي هادئ وآمن. مثالية للعائلات الكبيرة.&quot;,
                &quot;price&quot;: &quot;180000.00&quot;,
                &quot;floor&quot;: 1,
                &quot;surface&quot;: &quot;320.00&quot;,
                &quot;min_duration&quot;: 12,
                &quot;number_rooms&quot;: 6,
                &quot;number_persons&quot;: 10,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;listings/img-2.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;,
                    &quot;icon&quot;: null,
                    &quot;icon_path&quot;: null
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 3,
                &quot;title&quot;: &quot;استوديو مفروش بالقرب من الجامعة&quot;,
                &quot;description&quot;: &quot;استوديو صغير ومريح مفروش بالكامل، قريب جداً من الجامعة ووسائل النقل. مناسب للطلبة.&quot;,
                &quot;price&quot;: &quot;25000.00&quot;,
                &quot;floor&quot;: 2,
                &quot;surface&quot;: &quot;45.00&quot;,
                &quot;min_duration&quot;: 3,
                &quot;number_rooms&quot;: 1,
                &quot;number_persons&quot;: 2,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;listings/img-3.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;,
                    &quot;icon&quot;: null,
                    &quot;icon_path&quot;: null
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/near_places/mosque.png&quot;
                    }
                ],
                &quot;time_post&quot;: &quot;2026-03-02T15:37:31.000000Z&quot;
            },
            {
                &quot;id&quot;: 4,
                &quot;title&quot;: &quot;منزل عائلي واسع في حي هادئ&quot;,
                &quot;description&quot;: &quot;منزل عائلي بمساحة كبيرة يحتوي على حديقة وموقف سيارات، يقع في حي سكني هادئ وآمن.&quot;,
                &quot;price&quot;: &quot;90000.00&quot;,
                &quot;floor&quot;: 2,
                &quot;surface&quot;: &quot;210.00&quot;,
                &quot;min_duration&quot;: 12,
                &quot;number_rooms&quot;: 5,
                &quot;number_persons&quot;: 8,
                &quot;is_ready&quot;: true,
                &quot;is_negotiable&quot;: false,
                &quot;boost_level&quot;: 1,
                &quot;moderation_status&quot;: &quot;approved&quot;,
                &quot;image&quot;: &quot;listings/img-4.jpg&quot;,
                &quot;rent_duration&quot;: {
                    &quot;id&quot;: 1,
                    &quot;name&quot;: &quot;Day&quot;,
                    &quot;icon&quot;: null,
                    &quot;icon_path&quot;: null
                },
                &quot;categories&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Apartment&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/category_listings/apartment.png&quot;
                    }
                ],
                &quot;features&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;TV&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/tv.png&quot;
                    },
                    {
                        &quot;id&quot;: 2,
                        &quot;name&quot;: &quot;Pool&quot;,
                        &quot;icon&quot;: null,
                        &quot;icon_path&quot;: &quot;/storage/featured_listings/pool.png&quot;
                    }
                ],
                &quot;near_places&quot;: [
                    {
                        &quot;id&quot;: 1,
                        &quot;name&quot;: &quot;Mosque&quot;,
                        &quot;icon&quot;: null,
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
