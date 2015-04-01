$(document).ready(function () {
	$('#get').on('click', function () {
        $.ajax({
            url: 'api/users',
        }).done(function (data) {
            console.log(typeof data, data)
        })
	})
	$('#post').on('click', function () {
        $.ajax({
            url: 'api/users',
            dataType: 'json',
            method: 'POST',
            data: JSON.stringify({ name: "John", age: 23 }),
            contentType: 'application/json; charset=UTF-8',
        }).done(function (data) {
            console.log(typeof data, data)
        })
	})
})