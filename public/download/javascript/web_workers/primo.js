// funcion para determinar si un numero es primo     

function checkPrimo(number) {
    var divisor = 1;
    var primo = 0;
    for (var i = 0; i <= number; i++) {
        if (number % i == 0) {
            primo++;
        }
        if (primo > 2)
            break;
    }
    if (primo == 2) {
        return true;
    }
    else {
        return false;
    }
}

// funcion para determinar si un conjunto de numeros es primo
function checkPrimoCota(number) {
    primos = "";
    for (i = 0; i <= number; i++) {
        if (checkPrimo(i))
            primos += i + " ";
    }
    return primos;
}


postMessage("¡Empezando a trabajar!");

onmessage = function (oEvent) {
    postMessage("Recibido el siguiente valor: " + oEvent.data);
    postMessage("Los siguientes son primos:" + checkPrimoCota(oEvent.data))
};
