//CKEditor
window.onload = () => {
	ClassicEditor
		.create( document.querySelector( '#editor' ), {
		})
		.catch( error => {
			console.error( error );
		} );
};

//Dynamically add/remove ingredients
function addField(plusElement, type) {

	const plusParent = plusElement.parentElement;
	const itemList = plusParent.parentElement;
	const formItem = document.createElement("div");
	const fields = plusParent.querySelectorAll("input, textarea");
	let field;
	const plus = document.createElement("span");
	const minus = document.createElement("span");
	const up = document.createElement("span");

	formItem.classList.add("input-group", "mb-2");

	plus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	plus.innerHTML = "<i class='fa-solid fa-plus'></i>";
	plus.setAttribute("onclick", "addField(this, 'ingredient')");

	minus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	minus.innerHTML = "<i class='fa-solid fa-minus'></i>";
	minus.setAttribute("onclick", "removeField(this)");

	up.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
	up.innerHTML = "<i class='fa-solid fa-arrow-up'></i>";
	up.setAttribute("onclick", "moveFieldUp(this)");

	for(let i=0; i < fields.length; i++) {
		field = fields[i].cloneNode();
		field.value="";

		formItem.appendChild(field);
	}

	formItem.appendChild(plus);
	formItem.appendChild(minus);
	formItem.appendChild(up);

	//Add down arrow to new input if not being added as last item
	if(!itemList.lastElementChild.contains(plusElement)) {
		const down = document.createElement("span");
		down.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		down.innerHTML = "<i class='fa-solid fa-arrow-down'></i>";
		down.setAttribute("onclick", "moveFieldDown(this)");

		formItem.appendChild(down);
	}

	if(itemList.childElementCount === 1) {
		const prevMinus = document.createElement("span");
		prevMinus.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		prevMinus.innerHTML = "<i class='fa-solid fa-minus'></i>";
		prevMinus.setAttribute("onclick", "removeField(this)");
		plusElement.after(prevMinus);
	}

	//Add down arrow to parent input if it doesn't have it already
	if(!plusParent.querySelector(".fa-arrow-down")) {
		const prevDown = document.createElement("span");
		prevDown.classList.add("btn", "btn-primary", "btn-outline-light", "text-white");
		prevDown.innerHTML = "<i class='fa-solid fa-arrow-down'></i>";
		prevDown.setAttribute("onclick", "moveFieldDown(this)");
		plusParent.appendChild(prevDown);
	}

	plusParent.after(formItem);
}

function removeField(minusElement) {
	const minusParent = minusElement.parentElement;
	const fields = minusParent.querySelectorAll("input, textarea");
	const itemList = minusParent.parentElement;

	if (itemList.lastElementChild.contains(minusParent)) {
		minusParent.previousElementSibling.lastElementChild.remove();
	} else if (itemList.firstElementChild.contains(minusParent)) {
		const up = minusParent.nextElementSibling.lastElementChild.previousElementSibling.remove();
	}

	minusParent.remove();

	if(itemList.childElementCount === 1) {
		for (let i = 0; i < (itemList.firstElementChild.childElementCount - fields.length); i++) {
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
			down.innerHTML = "<i class='fa-solid fa-arrow-down'></i>";
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
			putBefore.insertBefore(upElement, putBefore.lastElementChild);
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
			up.innerHTML = "<i class='fa-solid fa-arrow-up'></i>";
			up.setAttribute("onclick", "moveFieldUp(this)");

			downParent.insertBefore(up, downElement);
			putAfter.lastElementChild.previousElementSibling.remove();
		}
	}

	putAfter.after(downParent);

	if(itemList.lastElementChild.contains(downElement)) {

		if(itemList.childElementCount === 2) {
			const upParent = downParent.nextElementSibling;
			const upElement = upParent.lastElementChild;
			downParent.appendChild(upElement);
			upParent.appendChild(downElement);
		} else {
			putAfter.append(downElement);
		}
	}
}
