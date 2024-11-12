function pedingTicketPresentation(resultData) {
    if (resultData.length > 0) {
        return `
        <span> 
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-exclamation-lg" viewBox="0 0 16 16">
  <path d="M7.005 3.1a1 1 0 1 1 1.99 0l-.388 6.35a.61.61 0 0 1-1.214 0zM7 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0"/>
</svg>  Ticketes pendientes de resolver: ${resultData.length}
        </span>
        `;
    } else {
        return `
            <span>Sin tickets pendientes</span>
        `;
    }
}

function pendinTicketsSecondProgram(formality_id, url) {
    let resultData;

    const response = $.ajax({
        type: "GET",
        url: url,
        data: {
            id: formality_id,
            status: ["pendiente de cliente", "pendiente asignación"],
        },
        async: false,
        success: function (data) {
            resultData = data;
        },
    });

    return pedingTicketPresentation(resultData);
}
function pendinTicketsSeventhProgram(formality_id, url) {
    let resultData;

    const response = $.ajax({
        type: "GET",
        url: url,
        data: {
            id: formality_id,
            status: ["en curso", "pendiente validación", "asignado"],
        },
        async: false,
        success: function (data) {
            resultData = data;
        },
    });

    return pedingTicketPresentation(resultData);
}
function pendinTicketsSeventeenthProgram(formality_id, url) {
    let resultData;

    const response = $.ajax({
        type: "GET",
        url: url,
        data: {
            id: formality_id,
            status: [
                "en curso",
                "pendiente validación",
                "asignado",
                "pendiente asignación",
            ],
        },
        async: false,
        success: function (data) {
            resultData = data;
        },
    });

    return pedingTicketPresentation(resultData);
}
