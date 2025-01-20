// JavaScript to validate email
document.getElementById("email").addEventListener("blur", function () {
	const emailField = document.getElementById("email");
	const emailError = document.getElementById("emailError");
	const emailValue = emailField.value;

	// Check if the email ends with @dkut.ac.ke
	if (emailValue && !emailValue.endsWith("@dkut.ac.ke")) {
		emailError.style.display = "block"; // Show error message
	} else {
		emailError.style.display = "none"; // Hide error message
	}
});
