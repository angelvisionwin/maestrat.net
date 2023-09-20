// Comprueba si un CIF es correcto

function CIFCorrecto(value) {
    "use strict";

    var cifRegEx = new RegExp(/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/gi);
    var letter = value.substring(0, 1), // [ T ]
        number = value.substring(1, 8), // [ P ][ P ][ N ][ N ][ N ][ N ][ N ]
        control = value.substring(8, 9), // [ C ]
        all_sum = 0,
        even_sum = 0,
        odd_sum = 0,
        i, n,
        control_digit,
        control_letter;

    function isOdd(n) {
        return n % 2 === 0;
    }

    // Quick format test
    if (value.length !== 9 || !cifRegEx.test(value)) {
        return false;
    }

    for (i = 0; i < number.length; i++) {
        n = parseInt(number[i], 10);

        // Odd positions
        if (isOdd(i)) {

            // Odd positions are multiplied first.
            n *= 2;

            // If the multiplication is bigger than 10 we need to adjust
            odd_sum += n < 10 ? n : n - 9;

            // Even positions
            // Just sum them
        } else {
            even_sum += n;
        }
    }

    all_sum = even_sum + odd_sum;
    control_digit = (10 - (all_sum).toString().substr(-1)).toString();
    control_digit = parseInt(control_digit, 10) > 9 ? "0" : control_digit;
    control_letter = "JABCDEFGHI".substr(control_digit, 1).toString();

    // Control must be a digit
    if (letter.match(/[ABEH]/)) {
        return control === control_digit;

        // Control must be a letter
    } else if (letter.match(/[KPQS]/)) {
        return control === control_letter;
    }

    // Can be either
    return control === control_digit || control === control_letter;

}

// Comprueba si es un DNI correcto (entre 5 y 8 letras seguidas de la letra que corresponda).

// Acepta NIEs (Extranjeros con X, Y o Z al principio)
function DNICorrecto(dni) {
    'use strict';

    var numero,
        inicial, letra,
        expresion_regular_dni = /^[XYZ]?\d{5,8}[A-Z]$/;

    dni = dni.toUpperCase();

    if (expresion_regular_dni.test(dni) === true) {
        numero = dni.substr(0, dni.length - 1);
        numero = numero.replace('X', 0);
        numero = numero.replace('Y', 1);
        numero = numero.replace('Z', 2);
        inicial = dni.substr(dni.length - 1, 1);
        numero = numero % 23;
        letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letra = letra.substring(numero, numero + 1);
        if (letra !=
            inicial) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
