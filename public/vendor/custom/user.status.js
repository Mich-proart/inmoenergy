function userStatusCode(data) {
    if (data == 0) {
        return `<span class="custom-badge ko">deshabilitado</span>`;
    } else {
        return `<span class="custom-badge operative">activo</span>`;
    }
}
