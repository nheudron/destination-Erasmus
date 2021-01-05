window.onload = () => {
	const filtersFrom = document.getElementById("form");

    document.querySelectorAll("form select").forEach(input => {
        console.log(input);
        input.addEventListener("change", function () {

				const Form = new FormData(filtersFrom);
				console.log(Form.values());
				Form.forEach((value, key) => {
					console.log(value);
				})
            });
    });
}