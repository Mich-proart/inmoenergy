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

    if (status === "en curso") {
        return `<span class="custom-badge inprogress">${status}</span>`;
    }

    if (status === "tramitado" || status === "finalizado") {
        return `<span class="custom-badge processed">${status}</span>`;
    }
    if (status === "en vigor") {
        return `<span class="custom-badge operative">${status}</span>`;
    }
}
