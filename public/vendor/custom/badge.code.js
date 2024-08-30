function statusColor(status) {
    if (status === "pendiente asignación" || status === "asignado") {
        return `<span class="badge rounded-pill bg-primary text-light">${status}</span>`;
    }

    if (status === "K.O.") {
        return `<span class="badge rounded-pill bg-danger text-bg-danger">${status}</span>`;
    }

    if (status === "en curso") {
        return `<span class="badge rounded-pill bg-warning text-dark">${status}</span>`;
    }

    if (status === "tramitado" || status === "en vigor") {
        return `<span class="badge rounded-pill bg-success text-bg-success">${status}</span>`;
    }
}
