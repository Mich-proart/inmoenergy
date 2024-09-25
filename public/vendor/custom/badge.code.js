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
