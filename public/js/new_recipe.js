//Quill content editor
document.addEventListener("DOMContentLoaded", () => {
	const quill = new Quill('#editor', {
	  modules: {
		toolbar: [
		  [{ 'header': [2, 3, 4, 5, 6, false] }],
		  ['bold', 'italic', 'underline'],
		  ['link', 'blockquote', 'image'],
		  [{ list: 'ordered' }, { list: 'bullet' }],
		  ['clean']
		]
	  },
	  placeholder: 'Content for the recipe page...',
	  theme: 'snow'
	});

	const form = document.querySelector('form');
	form.onsubmit = function() {
	  // Populate hidden form on submit
	  var about = document.querySelector('input[name=content]');
	  about.value = JSON.stringify(quill.getContents());

	  console.log("Submitted", $(form).serialize(), $(form).serializeArray());

	  // No back end to actually submit to!
	  alert('Open the console to see the submit data!')
	  return false;
	};
});
//Dynamically add/remove ingredients
function addField(plusElement, type) {

	const plusParent = plusElement.parentElement;
	const itemList = plusParent.parentElement;
	const formItem = document.createElement("div");
	const field = document.createElement("input");
	const plus = document.createElement("span");
	const minus = document.createElement("span");
	const up = document.createElement("span");

	formItem.classList.add("input-group", "mb-2");

	field.classList.add("form-control");
	field.setAttribute("type", "text");
	field.setAttribute("required", true);
	field.setAttribute("name", type + "s[]");

	plus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	plus.innerHTML = "+";
	plus.setAttribute("onclick", "addField(this, 'ingredient')");

	minus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	minus.innerHTML = "-";
	minus.setAttribute("onclick", "removeField(this)");

	up.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	up.innerHTML = "^";
	up.setAttribute("onclick", "moveFieldUp(this)");

	formItem.appendChild(field);
	formItem.appendChild(plus);
	formItem.appendChild(minus);
	formItem.appendChild(up);

	//Add down arrow to new input if not being added as last item
	if(!itemList.lastElementChild.contains(plusElement)) {
		const down = document.createElement("span");
		down.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		down.innerHTML = "v";
		down.setAttribute("onclick", "moveFieldDown(this)");

		formItem.appendChild(down);
	}

	if(itemList.childElementCount === 1) {
		const prevMinus = document.createElement("span");
		prevMinus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		prevMinus.innerHTML = "-";
		prevMinus.setAttribute("onclick", "removeField(this)");
		plusElement.after(prevMinus);
	}

	//Add down arrow to parent input if it doesn't have it already
	if(plusParent.lastChild.innerHTML !== "v") {
		const prevDown = document.createElement("span");
		prevDown.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		prevDown.innerHTML = "v";
		prevDown.setAttribute("onclick", "moveFieldDown(this)");
		plusParent.appendChild(prevDown);
	}

	plusParent.after(formItem);
}

function removeField(minusElement) {
	const minusParent = minusElement.parentElement;
	const itemList = minusParent.parentElement;

	if (itemList.lastElementChild.contains(minusParent)) {
		minusParent.previousElementSibling.lastElementChild.remove();
	} else if (itemList.firstElementChild.contains(minusParent)) {
		const up = minusParent.nextElementSibling.lastElementChild.previousElementSibling.remove();
	}

	minusParent.remove();

	if(itemList.childElementCount === 1) {
		for (let i = 0; i < (itemList.firstElementChild.childElementCount - 1); i++) {
			itemList.firstElementChild.lastElementChild.remove()
		}
	}
}

function moveFieldUp(upElement) {
	const upParent = upElement.parentElement;
	const itemList = upParent.parentElement;
	const putBefore = upParent.previousElementSibling;

	if(itemList.lastElementChild.contains(upElement)) {
		if(itemList.childElementCount !== 2) {
			const down = document.createElement("span");
			down.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
			down.innerHTML = "v";
			down.setAttribute("onclick", "moveFieldDown(this)");

			upParent.appendChild(down);
			putBefore.lastElementChild.remove();
		}
	}

	itemList.insertBefore(upParent, putBefore);

	if(itemList.firstElementChild.contains(upElement)) {

		if(itemList.childElementCount === 2) {
			const downParent = upParent.nextElementSibling;
			const downElement = downParent.lastElementChild;
			upParent.appendChild(downElement);
			downParent.appendChild(upElement);
		} else {
			putBefore.appendChild(upElement);
		}
	}
}

function moveFieldDown(downElement) {
	const downParent = downElement.parentElement;
	const itemList = downParent.parentElement;
	const putAfter = downParent.nextElementSibling;

	if(itemList.firstElementChild.contains(downElement)) {
		if(itemList.childElementCount !== 2) {
			const up = document.createElement("span");
			up.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
			up.innerHTML = "^";
			up.setAttribute("onclick", "moveFieldUp(this)");

			downParent.appendChild(up);
			putAfter.lastElementChild.previousElementSibling.remove();
		}
	}

	putAfter.after(downParent);

	if(itemList.lastElementChild.contains(downElement)) {

		if(itemList.childElementCount === 2) {
			const upParent = downParent.nextElementSibling;
			const upElement = upParent.lastElementChild;
			upParent.appendChild(downElement);
			downParent.appendChild(upElement);
		} else {
			putAfter.append(downElement);
		}
	}
}
