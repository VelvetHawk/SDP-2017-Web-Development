var tag_id_counter = 0;
var mouse_on_entry_area = false;
var tag_focused = false;
var max_4 = false;

function addOnClick()
{
	document.addEventListener("keypress", function(event)
	{
		if (event.keyCode == 13 && mouse_on_entry_area) // Enter key
		{
			appendNewTag();
			event.preventDefault();
		}
		else if (event.keyCode == 13 && tag_focused) // Prevents the enter key from breaking a tag
			event.preventDefault();
	});
	// Get the number of tags
	var stop = false;
	for (var i = 0; !stop; i++)
	{
		var temp = document.getElementById(i);
		if (temp != null)
			tag_id_counter++;
		else
			stop = true;
	}
	//
	if (window.location.href.endsWith("create-task.php"))
		max_4 = true;
}

function appendNewTag()
{
	if (tag_id_counter < 4)
	{
		var tag_wrapper = document.createElement("span");
		tag_wrapper.setAttribute("class", "tag-wrapper");
		tag_wrapper.setAttribute("id", tag_id_counter);

		var text = document.createElement("span");
		text.setAttribute("class", "tag-text");
		text.setAttribute("contenteditable", "true");
		text.setAttribute("onfocus", "tagFocused()");
		text.setAttribute("onblur", "tagBlurred()");
		text.innerHTML = "Tag";

		var cross = document.createElement("span");
		cross.setAttribute("class", "tag-cancel");
		cross.setAttribute("onClick", "removeTag(" + tag_id_counter + ")"); // Each tag will have a unique id
		cross.innerHTML = "×";


		tag_wrapper.appendChild(text);
		tag_wrapper.appendChild(cross);
			        
		document.getElementById("entry-area").appendChild(tag_wrapper);
		tag_id_counter++;
	}
}

function removeTag(tag)
{
	// alert("Tag to be removed: " + tag);
	var element = document.getElementById(tag);
	element.parentNode.removeChild(element);
}

function mouseOn()
{
	mouse_on_entry_area = true;
}

function mouseOff()
{
	mouse_on_entry_area = false;
}

function tagFocused()
{
	tag_focused = true;
}

function tagBlurred()
{
	tag_focused = false;
}

function addTagsToSubmit()
{
	var current_tag;
	var value_list = "";
	var failed = false;
	for (var i = 0; i <= tag_id_counter; i++)
	{
		failed = false;
		try {
			current_tag = document.getElementById(i).childNodes[0].innerHTML.toLowerCase();
		}
		catch (e) {
			failed = true;
		}
		if (!failed)
		{
			if (typeof current_tag != "undefined" && i < tag_id_counter-1) // i is not pre-last value
				value_list += current_tag + ",";
			else
				value_list += current_tag;
		}
	}
	document.getElementById("tags").setAttribute("value", value_list);
}