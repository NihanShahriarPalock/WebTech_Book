function validate() {
  const x = document.getElementById("username");
  const y = document.getElementById("password");

  const a = document.getElementById("error1");
  const b = document.getElementById("error2");

  let flag = true;

  if (x.value === "") {
    a.innerHTML = "Please fill up the username";
    flag = false;
  } else {
    a.innerHTML = "";
  }

  if (y.value === "") {
    b.innerHTML = "Please fill up the password";
    flag = false;
  } else {
    b.innerHTML = "";
  }

  return flag;
}

function validatePassword() {
  const newPassword = document.getElementById("new_password").value;
  const confirmPassword = document.getElementById("confirm_password").value;
  const errorElement = document.getElementById("password_error");

  if (newPassword !== confirmPassword) {
    errorElement.innerHTML = "Passwords do not match";
    return false;
  } else {
    errorElement.innerHTML = "";
    return true;
  }
}

function validateUserEdit() {
  const emailInput = document.getElementById("email");
  const emailValue = emailInput.value;
  const emailError = document.getElementById("email_error");

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (emailValue.trim() === "") {
    emailError.innerHTML = "Email is required";
    return false;
  } else if (!emailPattern.test(emailValue)) {
    emailError.innerHTML = "Invalid email format";
    return false;
  } else {
    emailError.innerHTML = "";
    return true;
  }
}

function validateForgotPassword() {
  const emailInput = document.getElementById("email");
  const emailValue = emailInput.value;
  const emailError = document.getElementById("email_error");

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (emailValue.trim() === "") {
    emailError.innerHTML = "Email is required";
    return false;
  } else if (!emailPattern.test(emailValue)) {
    emailError.innerHTML = "Invalid email format";
    return false;
  } else {
    emailError.innerHTML = "";
    return true;
  }
}

function validateContentWriterLogin() {
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const username = usernameInput.value.trim();
  const password = passwordInput.value.trim();
  const usernameError = document.getElementById("username_error");
  const passwordError = document.getElementById("password_error");
  let isValid = true;

  if (username === "") {
    usernameError.textContent = "Username is required";
    isValid = false;
  } else {
    usernameError.textContent = "";
  }

  // Validate password
  if (password === "") {
    passwordError.textContent = "Password is required";
    isValid = false;
  } else {
    passwordError.textContent = "";
  }

  return isValid;
}

function validateLoginForm() {
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const username = usernameInput.value.trim();
  const password = passwordInput.value.trim();
  const usernameError = document.getElementById("username_error");
  const passwordError = document.getElementById("password_error");
  let isValid = true;

  // Validate username
  if (username === "") {
    usernameError.textContent = "Username is required";
    isValid = false;
  } else {
    usernameError.textContent = "";
  }

  if (password === "") {
    passwordError.textContent = "Password is required";
    isValid = false;
  } else {
    passwordError.textContent = "";
  }

  return isValid;
}

function validateForm() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirm_password").value;
  const email = document.getElementById("email").value;
  const role = document.getElementById("role").value;

  const usernameError = document.getElementById("username_error");
  const passwordError = document.getElementById("password_error");
  const confirmPasswordError = document.getElementById(
    "confirm_password_error"
  );
  const emailError = document.getElementById("email_error");

  let isValid = true;

  // Reset errors
  usernameError.innerHTML = "";
  passwordError.innerHTML = "";
  confirmPasswordError.innerHTML = "";
  emailError.innerHTML = "";

  if (!username.trim()) {
    usernameError.innerHTML = "Please enter a username";
    isValid = false;
  }

  if (!password.trim()) {
    passwordError.innerHTML = "Please enter a password";
    isValid = false;
  }

  if (password !== confirmPassword) {
    confirmPasswordError.innerHTML = "Passwords do not match";
    isValid = false;
  }

  if (!email.trim()) {
    emailError.innerHTML = "Please enter an email";
    isValid = false;
  } else if (!validateEmail(email)) {
    emailError.innerHTML = "Please enter a valid email";
    isValid = false;
  }

  return isValid;
}

function validateEmail(email) {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
}
