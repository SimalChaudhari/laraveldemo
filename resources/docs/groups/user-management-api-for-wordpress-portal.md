# User Management (API for Wordpress portal)

APIs for managing users

## Create User from Wordpress Hippamart.


This endpoint allows you to Create User from wordpress hippamart platform

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/create_hipaa_mart_portal_user_api" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"test@gmail.com","user_pass":"soluta","firstname":"animi","lastname":"optio","username":"velit","wp_user_id":"tempore","company_name":"odio","purchased_licenses":"adipisci","monthly_fees":"exercitationem"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/create_hipaa_mart_portal_user_api"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "test@gmail.com",
    "user_pass": "soluta",
    "firstname": "animi",
    "lastname": "optio",
    "username": "velit",
    "wp_user_id": "tempore",
    "company_name": "odio",
    "purchased_licenses": "adipisci",
    "monthly_fees": "exercitationem"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


<div id="execution-results-POSTapi-create_hipaa_mart_portal_user_api" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-create_hipaa_mart_portal_user_api"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-create_hipaa_mart_portal_user_api"></code></pre>
</div>
<div id="execution-error-POSTapi-create_hipaa_mart_portal_user_api" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-create_hipaa_mart_portal_user_api"></code></pre>
</div>
<form id="form-POSTapi-create_hipaa_mart_portal_user_api" data-method="POST" data-path="api/create_hipaa_mart_portal_user_api" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-create_hipaa_mart_portal_user_api', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-create_hipaa_mart_portal_user_api" onclick="tryItOut('POSTapi-create_hipaa_mart_portal_user_api');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-create_hipaa_mart_portal_user_api" onclick="cancelTryOut('POSTapi-create_hipaa_mart_portal_user_api');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-create_hipaa_mart_portal_user_api" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/create_hipaa_mart_portal_user_api</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body" required  hidden>
<br>
The string of the user.
</p>
<p>
<b><code>user_pass</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="user_pass" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The password of user.
</p>
<p>
<b><code>firstname</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="firstname" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The firstname of user.
</p>
<p>
<b><code>lastname</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="lastname" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The lastname of user.
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The username of user.
</p>
<p>
<b><code>wp_user_id</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="wp_user_id" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The wp_user_id of user from wordpress database.
</p>
<p>
<b><code>company_name</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="company_name" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The company name of user.
</p>
<p>
<b><code>purchased_licenses</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="purchased_licenses" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The purchased licenses of user.
</p>
<p>
<b><code>monthly_fees</code></b>&nbsp;&nbsp;<small>required</small>     <i>optional</i> &nbsp;
<input type="text" name="monthly_fees" data-endpoint="POSTapi-create_hipaa_mart_portal_user_api" data-component="body"  hidden>
<br>
string The monthly fees of user.
</p>

</form>


## Delete User.


This endpoint allows you to Create User from wordpress hippamart platform

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/delete_wp_portal_user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"test@gmail.com"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/delete_wp_portal_user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "test@gmail.com"
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


<div id="execution-results-POSTapi-delete_wp_portal_user" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-delete_wp_portal_user"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-delete_wp_portal_user"></code></pre>
</div>
<div id="execution-error-POSTapi-delete_wp_portal_user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-delete_wp_portal_user"></code></pre>
</div>
<form id="form-POSTapi-delete_wp_portal_user" data-method="POST" data-path="api/delete_wp_portal_user" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-delete_wp_portal_user', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-delete_wp_portal_user" onclick="tryItOut('POSTapi-delete_wp_portal_user');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-delete_wp_portal_user" onclick="cancelTryOut('POSTapi-delete_wp_portal_user');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-delete_wp_portal_user" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/delete_wp_portal_user</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-delete_wp_portal_user" data-component="body" required  hidden>
<br>
The string of the user.
</p>

</form>



