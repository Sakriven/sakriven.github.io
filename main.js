// Add the novalidate attribute when the JS loads
var forms = document.querySelectorAll('.data-validate');
for (var i = 0; i < forms.length; i++) {
    forms[i].setAttribute('novalidate', true);
}

//Validate the field 
var hasError = function(field) {
    if (field.disabled || field.type === 'file' || field.type === 'submit' || field.type === 'reset' || field.type === 'button') return;

    //Get validity
    var validity = field.validity;

    //if valid, reutn null
    if (validity.valid) return;

    // If field is required and empty
    if (validity.valueMissing) return 'Please fill out this field.';

    // If not the right type
    if (validity.typeMismatch) {
        //Email 
        if (field.type === 'email') return 'Please enter an email address.';
    }

    // If number input isn't a number
    if (validity.badInput) return 'Please enter a number.';

    // If all else fails, return a generic catchall error
    return 'The value you entered for this field is invalid.';
};

//Error Message
var showError = function(field, error) {
    //Add error class to field
    field.classList.add('error');

    //Get field id or name
    var id = field.id || field.name;
    if(!id) return;

    //Check if error message field already exists
    //If not, create one
    var message = field.form.querySelector('.error-message#error-for-' + id);
    if(!message) {
        message = document.createElement('div');
        message.className = 'error-message';
        message.id = 'error-for-' + id;
        field.parentNode.insertBefore(message, field.nextSibling);
    }

    //Add ARIA role to the field
    field.setAttribute('aria-describedby', 'error-for-' + id);


    //Update error message
    message.innerHTML = error;

    //Show error message
    message.style.display = 'block';
    message.style.visibility = 'visible';
};

//Remove the error message
var removeError = function (field) {

    //Remove error class to field
    field.classList.remove('error');

    //Remove ARIA role from the field
    field.removeAttribute('aria-describedby');

    //Get field id or name
    var id = field.id || field.name;
    if (!id) return;

    //Check if an error message is in the DOM
    var message = field.form.querySelector('.error-message#error-for-' + id + '');
    if (!message) return;

    //If so, hide it
    message.innerHTML = '';
    message.style.display = 'none';
    message.style.visibility = 'hidden';
}

//Listen to all blur events
document.addEventListener('blur', function(event) {

    //Only run if the field is in a form to be validated
    if(!event.target.form.classList.contains('data-validate'))
    return;

    //Validate the field
    var error = hasError(event.target);

    //If there's an error, show it
    if(error) {
        showError(event.target, error);
        return;
    }

    //Otherwise, remove any exisiting error message
    removeError(event.target);

}, true);

// Check all fields on submit
document.addEventListener('submit', function (event) {

    // Only run on forms flagged for validation
    if (!event.target.classList.contains('data-validate')) return;

    // Get all of the form elements
    var fields = event.target.elements;

    // Validate each field
    // Store the first field with an error to a variable so we can bring it into focus later
    var error, hasErrors;
    for (var i = 0; i < fields.length; i++) {
        error = hasError(fields[i]);
        if (error) {
            showError(fields[i], error);
            if (!hasErrors) {
                hasErrors = fields[i];
            }
        }
    }

    // If there are errrors, don't submit form and focus on first element with error
    if (hasErrors) {
        event.preventDefault();
        hasErrors.focus();
    }

    // Otherwise, let the form submit normally
    // You could also bolt in an Ajax form submit process here

}, false);