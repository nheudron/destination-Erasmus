window.onload = () => {
	const filtersFrom = document.getElementById("form");

    document.querySelectorAll("form select").forEach(input => {
        input.addEventListener("change", function () {

				const Form = new FormData(filtersFrom);
				Form.forEach((value, key) => {
					console.log(value);
				})
            });
    });
}