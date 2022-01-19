# User Management

APIs for managing company users

## list

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/users/list" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"start_date":"nam","end_date":"optio","company_id":2,"start":20,"length":13,"search":"laborum"}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/users/list"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "start_date": "nam",
    "end_date": "optio",
    "company_id": 2,
    "start": 20,
    "length": 13,
    "search": "laborum"
}

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "email": "testuser@tests.com",
    "password": "secret"
}
```
<div id="execution-results-GETapi-users-list" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users-list"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users-list"></code></pre>
</div>
<div id="execution-error-GETapi-users-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users-list"></code></pre>
</div>
<form id="form-GETapi-users-list" data-method="GET" data-path="api/users/list" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users-list', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users-list" onclick="tryItOut('GETapi-users-list');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users-list" onclick="cancelTryOut('GETapi-users-list');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users-list" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/list</code></b>
</p>
<p>
<label id="auth-GETapi-users-list" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-users-list" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The start date.
</p>
<p>
<b><code>end_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="end_date" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The end date.
</p>
<p>
<b><code>company_id</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="company_id" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The company_id of the user.
</p>
<p>
<b><code>start</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="start" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The start of users length.
</p>
<p>
<b><code>length</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="length" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The end length of users length.
</p>
<p>
<b><code>search</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="search" data-endpoint="GETapi-users-list" data-component="body"  hidden>
<br>
The search value.
</p>

</form>


## create

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/users/create" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"firstname":"test","lastname":"test","username":"username","email":"test@gmail.com","password":"nostrum","confirm_password":"officia","user_role":"admin, user","mobile":"mobile","company_id":13}'

```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/users/create"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "firstname": "test",
    "lastname": "test",
    "username": "username",
    "email": "test@gmail.com",
    "password": "nostrum",
    "confirm_password": "officia",
    "user_role": "admin, user",
    "mobile": "mobile",
    "company_id": 13
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "email": "testuser@tests.com",
    "password": "secret"
}
```
<div id="execution-results-POSTapi-users-create" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-create"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-create"></code></pre>
</div>
<div id="execution-error-POSTapi-users-create" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-create"></code></pre>
</div>
<form id="form-POSTapi-users-create" data-method="POST" data-path="api/users/create" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-create', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-users-create" onclick="tryItOut('POSTapi-users-create');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-users-create" onclick="cancelTryOut('POSTapi-users-create');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-users-create" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/create</code></b>
</p>
<p>
<label id="auth-POSTapi-users-create" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-users-create" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>firstname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="firstname" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The firstname of the user.
</p>
<p>
<b><code>lastname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastname" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The lastname of the user.
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The username of the user.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The password of user.
</p>
<p>
<b><code>confirm_password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="confirm_password" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The confirm password of user.
</p>
<p>
<b><code>user_role</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="user_role" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The role of the user.
</p>
<p>
<b><code>mobile</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="mobile" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The mobile of the user.
</p>
<p>
<b><code>company_id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="company_id" data-endpoint="POSTapi-users-create" data-component="body" required  hidden>
<br>
The company_id of the user.
</p>

</form>


## get

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://127.0.0.1:8000/api/users/get/magnam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/users/get/magnam"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```


> Example response (200):

```json
{
    "email": "testuser@tests.com",
    "password": "secret"
}
```
<div id="execution-results-GETapi-users-get--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-users-get--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users-get--id-"></code></pre>
</div>
<div id="execution-error-GETapi-users-get--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users-get--id-"></code></pre>
</div>
<form id="form-GETapi-users-get--id-" data-method="GET" data-path="api/users/get/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-users-get--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-users-get--id-" onclick="tryItOut('GETapi-users-get--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-users-get--id-" onclick="cancelTryOut('GETapi-users-get--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-users-get--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/users/get/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-users-get--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-users-get--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-users-get--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Update


Display Upadte User

update a user

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/users/update/eveniet?firstname=test&lastname=demo&username=user_name&email=test%40test.com&mobile=1234567890&password=123" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/users/update/eveniet"
);

let params = {
    "firstname": "test",
    "lastname": "demo",
    "username": "user_name",
    "email": "test@test.com",
    "mobile": "1234567890",
    "password": "123",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```


> Example response (200):

```json

{
 "firstname": "test",
 "lastname": "demo",
 "username": "user_name",
 "email": "test@test.com",
 "mobile": "1234567890",
}
```
<div id="execution-results-POSTapi-users-update--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-update--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-update--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-users-update--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-update--id-"></code></pre>
</div>
<form id="form-POSTapi-users-update--id-" data-method="POST" data-path="api/users/update/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-update--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-users-update--id-" onclick="tryItOut('POSTapi-users-update--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-users-update--id-" onclick="cancelTryOut('POSTapi-users-update--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-users-update--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/update/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-users-update--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
<p>
<b><code>firstname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="firstname" data-endpoint="POSTapi-users-update--id-" data-component="query" required  hidden>
<br>
The id of the firstname.
</p>
<p>
<b><code>lastname</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="lastname" data-endpoint="POSTapi-users-update--id-" data-component="query" required  hidden>
<br>
The id of the lastname.
</p>
<p>
<b><code>username</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="username" data-endpoint="POSTapi-users-update--id-" data-component="query" required  hidden>
<br>
The id of the username.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-users-update--id-" data-component="query" required  hidden>
<br>
The id of the email.
</p>
<p>
<b><code>mobile</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="mobile" data-endpoint="POSTapi-users-update--id-" data-component="query" required  hidden>
<br>
The id of the mobile.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-users-update--id-" data-component="query"  hidden>
<br>
The id of the password.
</p>
</form>


## Delete


Display Delete User

destroy a user

> Example request:

```bash
curl -X POST \
    "http://127.0.0.1:8000/api/users/destroy/voluptatem" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://127.0.0.1:8000/api/users/destroy/voluptatem"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```


> Example response (200):

```json

{
 "user_Id": "1",
 "username": "user_name",
}
```
<div id="execution-results-POSTapi-users-destroy--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-users-destroy--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-destroy--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-users-destroy--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-destroy--id-"></code></pre>
</div>
<form id="form-POSTapi-users-destroy--id-" data-method="POST" data-path="api/users/destroy/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-destroy--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-users-destroy--id-" onclick="tryItOut('POSTapi-users-destroy--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-users-destroy--id-" onclick="cancelTryOut('POSTapi-users-destroy--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-users-destroy--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/users/destroy/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-users-destroy--id-" data-component="url" required  hidden>
<br>

</p>
</form>



