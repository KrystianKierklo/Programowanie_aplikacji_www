var computed = false;
var decimal = 0;

// function convert(entryform, from, to) {
// 	convertfrom = from.selectedIndex;
// 	convertto = to.selectedIndex;
// 	entryform.display.value =
// 		(entryform.input.value * from[convertfrom].value / to[convertto].value);
// }

// function addchar(input, character) {
// 	if ((character == '.' && decimal == '0') || character != '.') {
// 		input.value == '' || input.value == '0'
// 			? (input.value = character)
// 			: (input.value += character);
// 		computed = true;
// 		if (character == '.') {
// 			decimal - 1;
// 		}
// 	}
// }

// function openVothcom(){
//     windows.open("","Display window","toolbar-no,directories-no,menubar-no");
// }

function clear(form) {
	form.input.valule = 0;
	form.display.value = 0;
	decimal = 0;
}

function changeBackground(hexNumber) {
	document.bgColor = hexNumber;
}

setInterval(setClock, 1000);
const hourHand = document.querySelector('[data-hour-hand]');
const minuteHand = document.querySelector('[data-minute-hand]');
const secondHand = document.querySelector('[data-second-hand]');

function setClock() {
	const currentDate = new Date();
	const secondsRatio = currentDate.getSeconds() / 60;
	const minutesRatio = (secondsRatio + currentDate.getMinutes()) / 60;
	const hoursRatio = (minutesRatio + currentDate.getHours()) / 12;
	setRotation(secondHand, secondsRatio);
	setRotation(minuteHand, minutesRatio);
	setRotation(hourHand, hoursRatio);
}

function setRotation(element, rotationRatio) {
	element.style.setProperty('--rotation', rotationRatio * 360);
}

setClock();

$('#Test1').on('click', function () {
	$(this).animate(
		{
			width: '500px',
			opacity: 0.4,
			fontSize: '3em',
			borderWidth: '10px',
		},
		1500
	);
});
