// Append
var append = true;

// Keep track if user is logged in
function keep_alive() {
    var http = new XMLHttpRequest();
    // May need to fix this URL for the testweb3 server
    var url = "res/utils/still-logged.php";
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send("active=true&id=" + id);
};

// Get user id from cookies
function getIdFromCookie()
{
	var cookie = document.cookie;
	if (cookie.indexOf("id=") >= 0)
	{
		cookie = cookie.split(";");
		for (var i = 1; i < cookie.length; i++)
			if (cookie[i].indexOf("id=") >= 0)
			{
				var id = cookie[i].split("=");
				return id[1];
			}
	}
	// If the cookie doesn't contain an id, then return null
	return null;
}

// Called upon page loading
var id = getIdFromCookie();
if (id != null)
{
	keep_alive();
	setInterval(keep_alive, 55000);
}
else
{
	document.cookie = "id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}
// setInterval(keep_alive, 10000);

// Used in task.php
var form = document.getElementById("claim-form");
document.getElementById("claim").addEventListener("click", function ()
{
 	form.submit();
});

// // Flagging
function flagTask()
{
	if (append)
	{
		append = false;
		var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "res/utils/flag.php");

        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "id");
        hiddenField.setAttribute("value", document.getElementById('task_id').value);

        var area = document.createElement('textarea');
        area.name = 'post';
        area.maxLength = 1000;
        area.cols = 70;
        area.rows = 10;
        area.name = "reason";
        area.placeholder = "Please enter your reason for flagging...";

        var submit_button = document.createElement('button');
        submit_button.setAttribute('class', 'button');
        submit_button.setAttribute('onClick', 'document.form.submit()');
        submit_button.innerHTML = "Confirm";

        form.appendChild(area);
        form.appendChild(document.createElement('br'));
        form.appendChild(hiddenField);
        form.appendChild(submit_button);
        
        document.getElementById("view-task").appendChild(form);
	}
}

// Used to send task_id about flagged task
function getTaskId()
{
	var url = window.location.href.split(".php?");
	if (url[1].indexOf("id=") >= 0) // Means there is a task_id in the GET section
	{
		if (url[1].indexOf("&") < 0) // Means there is ONLY id= in the GET
		{
			var temp = url[1].split("=");
			return temp[1].replace("#", "");
		}
	}
};

function unFlag()
{
	var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "res/utils/unflag.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "task");
    hiddenField.setAttribute("value", getTaskId());

    form.appendChild(hiddenField);
    document.getElementById("review-task").appendChild(form);
    form.submit();
}

function cancelTask()
{
	var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "res/utils/cancel.php");

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "task");
    hiddenField.setAttribute("value", getTaskId());

    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
}

function banAndUnpublish()
{
	if (append)
	{
		append = false;
		var form = document.createElement('form');
		form.method = "post";
		form.action = "res/utils/ban.php";

		var area = document.createElement('textarea');
		area.name = 'post';
		area.maxLength = 1000;
		area.cols = 80;
		area.rows = 10;
		area.name = "reason";
		area.placeholder = "Please enter your reason for banning this user...";

		var hiddenField = document.createElement("input");
	    hiddenField.setAttribute("type", "hidden");
	    hiddenField.setAttribute("name", "task");
	    hiddenField.setAttribute("value", getTaskId());

		var submit_button = document.createElement('button');
		submit_button.setAttribute('class', 'button');
		submit_button.setAttribute('onClick', 'document.form.submit()');
		submit_button.innerHTML = "Confirm";

		form.appendChild(area);
		form.appendChild(document.createElement('br'));
		form.appendChild(hiddenField);
		form.appendChild(submit_button);

		document.getElementById("review-task").appendChild(form);
	}
}

// Append form for review on view-task.php
function appendArea()
{
	if (append)
	{
		append = false;
		var form = document.createElement('form');
		form.method = "post";
		form.action = "res/utils/confirm.php";

		var area = document.createElement('textarea');
		area.name = 'post';
		area.maxLength = 1000;
		area.cols = 80;
		area.rows = 10;
		area.name = "review";
		area.placeholder = "Enter a your review for this task...";

		var id = document.createElement('input');
		id.setAttribute("type", "hidden");
		id.setAttribute("name", "id");
		id.setAttribute("value", document.getElementById('task_id').value);

		var submit_button = document.createElement('button');
		submit_button.setAttribute('class', 'button');
		submit_button.setAttribute('onClick', 'document.form.submit()');
		submit_button.innerHTML = "Confirm";

		form.appendChild(area);
		form.appendChild(document.createElement('br'));
		form.appendChild(id);
		form.appendChild(submit_button);

		document.getElementById("view-task").appendChild(form);
	}
}

