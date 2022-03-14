let namesRegex = /^[a-z\s]+$/i;
let numbersRegex = /^\d+$/;
let nameAddressRegex = /^[-a-z ,.\'0-9]*$/gi;

// error messages for edit and create components
export let errors = {
    nameError: '',
    descriptionError: '',
    priceError: '',
    fileError: '',
    emailError: '',
    passwordError: '',
    passwordConfirmError: '',
    firstNameError: '',
    lastNameError: '',
    restaurantNameError: '',
    addressError: '',
    streetNumberError: '',
    postalCodeError: '',
    cityError: '',
    vatNumberError: '',
    categoryError: '',
    phoneError: '',
    creditCardData: '',
    emptyCartError: ''
}

// validation functions for edit and create components

// validates food name
export const validateName = (value) => {
    if (!value || value.length < 2) {
        errors.nameError = 'Inserire almeno un dato valido';
        return false;
    }

    errors.nameError = '';
    return true;
}

// validates food description
export const validateDescription = (value) => {
    if (!value || value.length < 50) {
        errors.descriptionError = 'Inserire una descrizione di almeno 50 caratteri';
        return false;
    }

    errors.descriptionError = '';
    return true;
}

// validates food price
export const validatePrice = (value) => {
    console.log(value);
    if (!value || !value.match(/^\d*\.?\d*$/) || value <= 0 ) {
        errors.priceError = 'Inserire un prezzo valido';
        return false;
    }

    errors.priceError = '';
    return true;
}

// validates file type
export const validateFileType = (file, required) => {
    if (required && (!file || !file.type.includes('image'))) {
        errors.fileError = 'Formato file non valido. Inserisci una immagine';
        return false;
    }

    if (!required && (file && !file.type.includes('image'))) {
        errors.fileError = 'Formato file non valido. Inserisci una immagine';
        return false;
    }

    errors.fileError = '';
    return true;
}

// validation functions for register and checkout components

// validates email
export const validateEmail = (email) => {
    if (!email || !email.match(/^([a-zA-Z0-9\_\-\.]+)@([a-zA-Z0-9\_\-\.]+)\.([a-zA-Z]{2,5})$/g)) {
        errors.emailError = 'Email non valida';
        return false;
    }

    errors.emailError = '';
    return true;
}

// validates password (min 8 char | 1 uppercase char | 1 number | 1 special char)
export const validatePassword = (password) => {
    if (!password || !password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/g)) {
        errors.passwordError = 'Password non valida';
        return false;
    }

    errors.passwordError = '';
    return true;
}

// checks if password_confirmation field is the same as password
export const validatePasswordConfirm = (passwordConfirmed, password) => {
    if (passwordConfirmed !== password) {
        errors.passwordConfirmError = 'Questa password non corrisponde alla prima inserita';
        return false;
    }

    errors.passwordConfirmError = '';
    return true;
}

// validates first name
export const validateFirstName = (name) => {
    if (!name || !name.match(namesRegex)) {
        errors.firstNameError = 'Nome non valido';
        return false;
    }

    errors.firstNameError = '';
    return true;
}

// validates last name
export const validateLastName = (name) => {
    if (!name || !name.match(namesRegex)) {
        errors.lastNameError = 'Cognome non valido';
        return false;
    }

    errors.lastNameError = '';
    return true;
}

// validates restaurant name
export const validateRestaurantName = (restaurantName) => {
    if (!restaurantName || !restaurantName.match(nameAddressRegex)) {
        errors.restaurantNameError = 'Nome ristorante non valido';
        return false;
    }

    errors.restaurantNameError = '';
    return true;
}

// validates restaurant address
export const validateAddress = (address) => {
    if (!address || !address.match(nameAddressRegex)) {
        errors.addressError = 'Indirizzo non valido';
        return false;
    }

    errors.addressError = '';
    return true;  
}

// validates street number
export const validateStreetNumber = (number) => {
    if (!number || !number.match(numbersRegex)) {
        errors.streetNumberError = 'Numero civico non valido';
        return false;
    }

    errors.streetNumberError = '';
    return true;                
}

// validates postal code
export const validatePostalCode = (number) => {
    if (!number || !number.match(numbersRegex)) {
        errors.postalCodeError = 'CAP non valido';
        return false;
    }

    errors.postalCodeError = '';
    return true;                
}

// validates city
export const validateCity = (city) => {
    if (!city || !city.match(namesRegex)) {
        errors.cityError = 'Città non valida';
        return false;
    }

    errors.cityError = '';
    return true;                 
}

// validates italian VAT number (prefix IT followed by 14 digits)
export const validateVatNumber = (vatNumber) => {
    if (!vatNumber || !vatNumber.match(/^it\d{14}$/gi)) {
        errors.vatNumberError = 'Partita IVA non valida. Formato richiesto: IT seguito da 14 cifre';
        return false;
    }

    errors.vatNumberError = '';
    return true;
}

// checks if at least one category has been selected
export const validateCategory = (categories) => {
    if (categories.length === 0) {
        errors.categoryError = 'Devi scegliere almeno una categoria';
        return false; 
    }

    errors.categoryError = '';
    return true;
}

export const validatePhone = (phone) => {
    if (phone && !phone.match(/^\d{10}$/)) {
        errors.phoneError = 'Numero di telefono errato';
        return false;
    }

    errors.phoneError = '';
    return true;
}