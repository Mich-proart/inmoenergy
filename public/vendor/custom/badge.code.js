function statusColor(status) {
    if (status === "pendiente asignación" || status === "asignado") {
        return `<span class="custom-badge assigned">${status}</span>`;
    }

    if (status === "K.O.") {
        return `<span class="custom-badge ko">${status}</span>`;
    }

    if (status === "baja") {
        return `<span class="custom-badge down">${status}</span>`;
    }

    if (status === "en curso" || status === "pendiente de cliente") {
        return `<span class="custom-badge inprogress">${status}</span>`;
    }

    if (status === "tramitado" || status === "pendiente validación") {
        return `<span class="custom-badge processed">${status}</span>`;
    }
    if (status === "finalizado") {
        return `<span class="custom-badge down">${status}</span>`;
    }
    if (status === "en vigor" || status === "resuelto") {
        return `<span class="custom-badge operative">${status}</span>`;
    }
}

function isRenewableCode(data) {
    if (data === 1 || data === '1') {
        return `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
  <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
  <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
</svg>
        `;
    } else {
        return `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
  <path d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
</svg>
        `;
    }
}

function criticalCode(isCritical) {
    if (isCritical !== 0) {
        return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
</svg>`;
    } else {
        return ``;
    }
}

function formatEnglishToSpanishPotency(number) {

    if (number === null) {
        return `kW 0,00`;
    }
    
    let numberStr = number.toString();
    
    // Replace the decimal point with a comma
    numberStr = numberStr.replace('.', ',');
    
    // Remove trailing zeros after the comma
    numberStr = numberStr.replace(/,?0+$/, '');
  
    //return trimmedNumber;
    return `kW ${numberStr}`;
}

function formatEnglishToSpanishannual_consumption(number) {

    if (number === null) {
        return `kW 0`;
    }
    
    let numberStr = number.toString();
  
    //return trimmedNumber;
    return `kW ${numberStr}`;
}

function isResolvedTicket(idResolved) {
    if (idResolved === 1 || idResolved === '1') {
        return `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="green" class="bi bi-check2-circle" viewBox="0 0 16 16">
  <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0"/>
  <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
</svg>
        `;
    } else {
        return `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
  <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z"/>
  <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3"/>
</svg>
        `;
    }
}